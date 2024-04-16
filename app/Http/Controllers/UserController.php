<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\ImportRequest;
use App\Imports\UsersImport;
use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use App\Utils\MessageUtil;
use Illuminate\Http\Request;
use App\Utils\PaginateUtil;
use Maatwebsite\Excel\Validators\ValidationException;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use App\Services\UserService;

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
        // Get user query parameters
        $userQueryParams = $request->all();

        // Retrieve all users
        $users = $this->userRepository->getAll();

        // Check if 'clear' parameter is set to clear session data
        if (!empty($userQueryParams['clear'])) {
            Session::forget('userQueryParams');
            return redirect()->route('user');
        }

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
        } else {
            $users = PaginateUtil::paginateModel(new User);
        }

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
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportCSV() {
        $fileName = date('YmdHis') . '_user.csv';
        return Excel::download(new UsersExport, $fileName);
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
        $result = $this->userService->validateInputFile($file);
        
        if ($result['error']) {
            return redirect()->back()->withErrors(['msg' => $result['msg']]);
        }
        
        try {

            Excel::import(new UsersImport, $file);

            return redirect()->route('user')->with('msgInfo', MessageUtil::getMessage('infos', 'I013'));
        } catch (ValidationException $e) {
            $failures = $e->failures();
            
            foreach ($failures as $failure) {
                // row that went wrong
                $row = $failure->row();
                $msgError = $failure->errors()[0];
            }

            return redirect()->back()->withErrors(['msg' => MessageUtil::getMessage('errors', 'E019', [$row, $msgError])]);
        }

    }
}