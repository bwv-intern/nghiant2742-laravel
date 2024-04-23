<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\ImportRequest;
use App\Interfaces\UserRepositoryInterface;
use App\Utils\MessageUtil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Services\UserService;
use Exception;
use Illuminate\Support\Facades\DB;

class UserController extends Controller 
{
    private UserRepositoryInterface $userRepository;
    private UserService $userService;

    public function __construct(UserRepositoryInterface $userRepository, UserService $userService) {
        $this->userRepository = $userRepository;
        $this->userService = $userService;
    }

    /**
     * Display a listing of the users.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request) {
        // Check if 'clear' parameter is set to clear session data
        $isClear = $request->query('clear');
        if ($isClear) {
            Session::forget('userQueryParams');
            return redirect()->route('user');
        }

        $users = $this->userService->handleUserQuery($request);

        // If no users found, display an info message
        if (count($users) === 0) {
            $msgInfo = MessageUtil::getMessage('infos', 'I005');
            return view('screens.user.index', ['users' => [], 'msgInfo' => $msgInfo]);
        }

        // Display the index view with the users data
        return view('screens.user.index', ['users' => $users]);
    }

    /**
     * Export users data to CSV format.
     *
     * @param Request $request
     * 
     */
    public function exportCSV(Request $request) {

        $userQueryParams = $request->all();
        $users = $this->userRepository->search($userQueryParams);
        $usersEloquent = $users->get();
        $usersArray = $usersEloquent->toArray();

        // If no users found, display an info message
        if (count($usersArray) === 0) {
            $msgInfo = MessageUtil::getMessage('infos', 'I005');
            return redirect()->route('user', $request->all())->with('msgInfo', $msgInfo);
        }

        $fileName = date('YmdHis') . '_user.csv';
        return $this->userService->export($usersArray, $fileName);
    }    

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create() {
        return view('screens.user.add');
    }

    /**
     * Store a newly created user in storage.
     *
     * @param StoreUserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreUserRequest $request) {
        // Handle saving data
        $isSaved = $this->userService->handleSaveData($request, 'add');

        // Redirect with success or error message
        if ($isSaved) {
            $msgInfo = MessageUtil::getMessage('infos', 'I013');
            return redirect()->route('user')->with('msgInfo', $msgInfo);
        }
        return redirect()->back()->withErrors(MessageUtil::getMessage('errors', 'E014'));
    }

    /**
     * Display the specified user.
     *
     * @param string $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show(string $id) {
        // Retrieve user by id
        $user = $this->userRepository->getById($id);
        if(!$user){
            return redirect()->route('404');
        }
        return view('screens.user.edit')->with('user', $user);
    }

    /**
     * Update the specified user in storage.
     *
     * @param string $id
     * @param UpdateUserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(string $id, UpdateUserRequest $request) {
        // Set the 'id' parameter in the request
        $request['id'] = $id;

        // Handle saving data
        $isSaved = $this->userService->handleSaveData($request, 'update');

        // Redirect with success or error message
        if ($isSaved) {
            $msgInfo = MessageUtil::getMessage('infos', 'I013');
            return redirect()->route('user')->with('msgInfo', $msgInfo);
        }
        return redirect()->back()->withErrors(MessageUtil::getMessage('errors', 'E014'));
    }

    /**
     * Remove the specified user from storage.
     *
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(string $id) {
        // Delete user by id
        $isDeleted = $this->userRepository->delete($id);

        // Redirect with success or error message
        if ($isDeleted) {
            return redirect()->route('user');
        }
        return redirect()->back()->withErrors("Delete failed");
    }

    /**
    * Import users data to CSV format.
    *
    * @return \Illuminate\Support\Collection
    */
    public function importCSV(ImportRequest $request) 
    {
        $file = $request->file('csv_file');
        $tmpName = $file->getPathname();
        // Validate ipnut file
        $result = $this->userService->validateInputFile($tmpName);
        
        if ($result['error']) {
            return redirect()->back()->withErrors(['msg' => $result['msg']]);
        }
        
        // data to create or update
        $data = $result['data'];

        DB::beginTransaction();
        
        try {
            $this->userService->import($data);

            return redirect()->route('user')->with('msgInfo', MessageUtil::getMessage('infos', 'I013'));
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['msg' => MessageUtil::getMessage('errors', 'E014')]);
        }
    }
}