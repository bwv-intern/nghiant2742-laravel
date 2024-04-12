<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Http\Requests\ImportRequest;
use App\Imports\UsersImport;
use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use App\Services\UserService;
use App\Utils\MessageUtil;
use Illuminate\Http\Request;
use App\Utils\PaginateUtil;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Validators\ValidationException;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
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

    public function create() {
        return view('screens.user.add');
    }

    public function exportCSV() {
        $fileName = date('YmdHis').'_'. 'user.csv';
        return Excel::download(new UsersExport, $fileName);
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function importCSV(ImportRequest $request) 
    {
        $file = $request->file('csv_file');
        $result = $this->userService->handleImport($file);
        
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