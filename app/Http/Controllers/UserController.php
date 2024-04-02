<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Http\Requests\StoreUserRequest;
use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use App\Utils\MessageUtil;
use Illuminate\Http\Request;
use App\Utils\PaginateUtil;
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

    public function index(Request $request) {
        $userQueryParams = $request->all();

        $users = $this->userRepository->getAll();

        if(!empty($userQueryParams['clear'])) {
            Session::forget('userQueryParams');
            return redirect()->route('user');
        }

        if(!empty($userQueryParams)){
            Session::put('userQueryParams', $userQueryParams);
        } else {
            Session::forget('userQueryParams');
        }

        if(Session::has('userQueryParams')) {
            $users = $this->userRepository->search($userQueryParams);
            $users = PaginateUtil::paginateModel($users);
        } else {
            $users = PaginateUtil::paginateModel(new User);
        }

        if (count($users) === 0) {
            $msgInfo = MessageUtil::getMessage('infos', 'I005');
            return view('screens.user.index', ['users' => [], 'msgInfo' => $msgInfo]);
        }

        return view('screens.user.index', ['users' => $users]);
    }

    public function exportCSV() {
        $fileName = date('YmdHis').'_'. 'user.csv';
        return Excel::download(new UsersExport, $fileName);
    }

    public function create() {
        return view('screens.user.add');
    }

    public function store(StoreUserRequest $request) {
        $user = $this->userService->handleInput($request, 'add');
        if ($user) {
            $this->userRepository->store($user);

            $msgInfo = MessageUtil::getMessage('infos', 'I013');
            return redirect()->route('user')->with('msgInfo', $msgInfo);
        }
        return redirect()->back()->withErrors(MessageUtil::getMessage('errors', 'E014'));
    }

}