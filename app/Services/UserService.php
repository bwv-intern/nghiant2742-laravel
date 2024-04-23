<?php

namespace App\Services;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use App\Rules\EmailRule;
use App\Rules\UserIdExistsRule;
use App\Utils\ConstUtil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Utils\MessageUtil;
use App\Utils\PaginateUtil;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

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

        $csvAsArray = array_map('str_getcsv', file($file));

        // Exptected header
        $expectedHeader = ["User ID", "Email", "Password", "User Flag", "Date Of Birth", "Name"];
        
        //Extract the first element from the array
        $header = $csvAsArray[0];

        // Verify header & expected header
        $headerMatch = $header === $expectedHeader;

        if (!$headerMatch) {
            return [
                'error' => true,
                'msg' => MessageUtil::getMessage('errors', 'E008')
            ];
        }
        
        // Check data is not empty
        if (count($csvAsArray) <= 1) {
            return [
                'error' => true,
                'msg' => 'Your file is empty'
            ];
        }

        // Rule Validation
        $rules = [
            'user_id' => [
                'nullable',
                'numeric',
                new UserIdExistsRule,
            ],
            'email' => [
                'required',
                'max:100',
                new EmailRule,
            ],
            'password' => 'required',
            'user_flag' => 'in:0,1,2|required',
            'date_of_birth' => 'date_format:Y-m-d',
            'name' => 'max:50|required',
        ];

        $customMessages = [
            'email.required' => MessageUtil::getMessage('errors', 'E001', ['Email']),
            'email.unique' => MessageUtil::getMessage('errors', 'E009', ['Email']),
            'name.required' => MessageUtil::getMessage('errors', 'E001', ['Name']),
            'password.required' => MessageUtil::getMessage('errors', 'E001', ['Password']),
            'user_flag.required' => MessageUtil::getMessage('errors', 'E001', ['User flag']),
            'user_id.numeric' => MessageUtil::getMessage('errors', 'E012', ['User ID','number']),
            'user_flag.in' => MessageUtil::getMessage('errors', 'E012', ['User flag','0, 1 or 2']),
            'date_of_birth.date_format' => MessageUtil::getMessage('errors', 'E012', ['Date of birth','YYYY-mm-dd']),
        ];
        // $rules['email'] = [...$rules['email'], 'unique:users,email,1'];
        // Re-keying
        foreach ($csvAsArray as $rowIndex => $row) {
            if ($rowIndex === 0) {
                continue; // Skip the header row
            }
        
            $keyedRow = [];
            for ($columnIndex = 0; $columnIndex < count($expectedHeader); $columnIndex++) {
                $key = str_replace(' ', '_', strtolower($expectedHeader[$columnIndex]));
                $keyedRow[$key] = $row[$columnIndex] ?? null;
            }
            $csvData[] = $keyedRow;
        }
        $listOfEmailInCSV = [];
        foreach ($csvData as $i => $row) {
            
            $customRule = $rules;
            if (!empty($row['user_id'])) {
                $customRule['email'] = [...$rules['email'], 'unique:users,email,'.$row['user_id']];
            } else {
                $customRule['email'] = [...$rules['email'], 'unique:users,email'];
            }
            
            // Validate the current row using the defined rules
            $validator = Validator::make($row, $customRule, $customMessages);

            // Check duplicate email in csv file
            if (in_array($row['email'], $listOfEmailInCSV)) {
                return [
                    'error' => true,
                    'msg' => "Row " . ($i + 2) . ": ". MessageUtil::getMessage('errors', 'E009', ['Email']),
                ];
            }

            // Add unique email into array
            array_push($listOfEmailInCSV, $row['email']);

            if ($validator->fails()) {
                // Return error message with specific row number
                return [
                    'error' => true,
                    'msg' => "Row " . ($i + 2) . ": ". $validator->errors()->first(),
                ];
            }
        }

        return [
            'error' => false,
            'msg' => "File ok",
            'data' => $csvData
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

    // Implement create new user or update user
    public function handleCreateOrUpdateUser($data) {
        DB::beginTransaction();

        try {
            foreach ($data as $key => $row) {
                $password = $row['password'];
                $isBcryptHash = preg_match('/^\$2y\$/', $password);
                if (!$isBcryptHash) {
                    $password = Hash::make($password); // Hash the password if it's not already hashed.
                }

                $user = [
                    'email' => $row['email'],
                    'password' => $password,
                    'user_flg' => $row['user_flag'],
                    'date_of_birth' => $row['date_of_birth'],
                    'name' => $row['name'],
                ];

                if (empty($row['user_id'])) {
                    // Save user with rollback on failure
                    $this->userRepository->store('users', $user);
                } else {
                    // Update user with rollback on failure
                    $this->userRepository->update('users', $row['user_id'], $user);
                }
            }

            DB::commit();

            return true; // User creation/update successful

        } catch (Exception $e) {
            DB::rollBack();

            // Handle user creation/update failure (log error, return false)
            return false;
        }
    }
}