<?php

namespace App\Services;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use App\Utils\ConstUtil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Utils\MessageUtil;
use App\Utils\PaginateUtil;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class UserService
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository) {
        $this->userRepository = $userRepository;
    }

    // Declare the function as static
    public static function getValueCheckbox()
    {
        $lengthOfList = ConstUtil::getLengthOfContentYml('users','user_flg');
        $checkboxList = [
            ['id' => 'adminFlag', 'value' => '0', 'label' => 'Admin', 'checked' => true],
            ['id' => 'userFlag', 'value' => '1', 'label' => 'User', 'checked' => true],
            ['id' => 'supportFlag', 'value' => '2', 'label' => 'Support', 'checked' => true],
        ];
        $options = [];

        if($lengthOfList === null) return $options;

        for ($i = 0; $i < $lengthOfList; $i++) {
            $item = ConstUtil::getContentYml('users', 'user_flg', $i);
            
            switch ($item) {
                case 'admin':
                    $options[] = $checkboxList[0];
                    break;
                case 'user':
                    $options[] = $checkboxList[1];
                    break;
                case 'support':
                    $options[] = $checkboxList[2];
                    break;
            }
        }

        $userQueryParams = Session::get('userQueryParams');
        if($userQueryParams){
            if((count($userQueryParams) >= 1 || $userQueryParams['search']) && !isset($userQueryParams['user_flg'])) {
                $options = $checkboxList;
                $options[0]['checked'] = false;
                $options[1]['checked'] = false;
                $options[2]['checked'] = false;
            }
        }

        return $options;
    }

    // Handle input of add/update to return array of input data
    public function handleSaveData(Request $request, $method = '')
    {
        $input = $request->all();
        $data = [
            'email' => $input['email'],
            'name' => $input['name'],
            'user_flg' => $input['user_flg'],
            'phone' => $input['phone'],
            'address' => $input['address'],
            'date_of_birth' => $input['date_of_birth'],
        ];

        if (!empty($input['password'])) {
            $data['password'] = Hash::make($input['password']);
        }

        // Only add new user when method = add
        if ($method == 'add') {
            return $this->userRepository->store('users', $data);
        }
        
        // Get user id need to edit
        $id = $input['id'];
        return $this->userRepository->update('users', $id, $data);
    }

    
    /**
     * Validate the structure and content of an input Excel file.
     *
     * @param string $file The path to the input Excel file.
     * @return array An array indicating whether the validation passed or failed,
     *               along with an associated message.
     */
    public function validateInputFile($file) {

        $rows = Excel::toCollection([], $file);
        
        $data = $rows->first();

        // Verify header
        $expectedHeader = ["User ID", "Email", "Password", "User Flag", "Date Of Birth", "Name"];
        $header = $data->first()->toArray();


        if ($header !== $expectedHeader) {
            return [
                'error' => true,
                'msg' => MessageUtil::getMessage('errors', 'E008')
            ];
        }

       $lengthData = count($rows->first()->toArray());

        if ($lengthData <= 1) {
            return [
                'error' => true,
                'msg' => 'Your file is empty'
            ];
        }

        return [
            'error' => false,
            'msg' => "File ok"
        ];
    }

    /**
     * Handle user queries and retrieve paginated user data
     *
     * @param \Illuminate\Http\Request $request The HTTP request containing query parameters
     * @return \Illuminate\Pagination\LengthAwarePaginator The paginated user data
     */
    public function handleUserQuery($request) {
        // Get user query parameters
        $userQueryParams = $request->all();

        // Retrieve all users
        $users = $this->userRepository->getAll();

        // Store user query parameters in session
        if (!empty($userQueryParams)) {
            Session::put('userQueryParams', $userQueryParams);
        } else {
            Session::forget('userQueryParams');
        }

        // Retrieve users based on search criteria or paginate all users
        if (Session::has('userQueryParams')) {
            $users = $this->userRepository->search($userQueryParams);
            $users = PaginateUtil::paginateModel($users);
            if (count($userQueryParams) == 1 && isset($userQueryParams['search'])) {
                $users = [];
            }
        } else {
            $users = PaginateUtil::paginateModel(new User);
        }
        
        return $users;
    }
}