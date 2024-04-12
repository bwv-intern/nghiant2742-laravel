<?php

namespace App\Imports;

use App\Models\User;
use App\Rules\EmailRule;
use App\Rules\UserIdExistsRule;
use App\Utils\MessageUtil;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class UsersImport implements ToModel, WithHeadingRow, WithValidation, WithChunkReading, WithUpserts, WithBatchInserts
{
    protected $rowNum = 1;
    protected $userId;

    public function model(array $row) {

        ++$this->rowNum;
        $userId = $row['user_id'];
        $this->$userId = $userId;
        $password = $row['password'];
        $isBcryptHash = preg_match('/^\$2y\$/', $password);
        if (!$isBcryptHash) {
            $password = Hash::make($password);
        }
        $userFlg = $row['user_flag'];
        $dateOfBirth = $row['date_of_birth'];
        $name = $row['name'];
        $email = $row['email'];

            // is user id exist?
        if (!empty($userId)) {

            // Find user
            $user = User::find($userId);
            if (!$user) {
                $error = ['0' => MessageUtil::getMessage('errors', 'E015', ['User ID'])];
                $failures[] = new Failure($this->rowNum, 'User ID', $error, $row);
                
                throw new \Maatwebsite\Excel\Validators\ValidationException(
                    \Illuminate\Validation\ValidationException::withMessages($error),
                    $failures
                );
            }

            $existsEmail = User::where('email', $email)->exists();

            if ($user->email !== $email && $existsEmail) {
                $error = ['0' => MessageUtil::getMessage('errors', 'E009', ['Email'])];
                $failures[] = new Failure($this->rowNum, 'User ID', $error, $row);
                throw new \Maatwebsite\Excel\Validators\ValidationException(
                    \Illuminate\Validation\ValidationException::withMessages($error),
                    $failures
                );
            }

            $data =[
                'email' => $email,
                'password' => $password,
                'user_flg' => $userFlg,
                'date_of_birth' => $dateOfBirth,
                'name' => $name,
                'updated_by' => Auth::id(),
                'updated_at' => now(),
            ];
            
            DB::table('users')->where('id', $userId)->update($data);
            
            return null;

        } else {
            // Case User ID empty, add new user
            $user = new User([
                'email' => $email,
                'password' => $password,
                'user_flg' => $userFlg,
                'date_of_birth' => $dateOfBirth,
                'name' => $name,
                'created_by' => Auth::id(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
        
        return $user;
    }

    public function rules(): array {
        $rules = [
            'email' => [
                'required',
                'max:100',
                new EmailRule,
            ],
            'name' => 'max:50|required',
            'password' => 'required',
            'user_id' => [
                'nullable',
                'numeric',
                new UserIdExistsRule
            ],
            'user_flag' => 'in:0,1,2|required',
            'date_of_birth' => 'date_format:Y-m-d',
        ];

        return $rules;
    }

    public function customValidationMessages() {
        return [
            'email.required' => MessageUtil::getMessage('errors', 'E001', ['Email']),
            'email.unique' => MessageUtil::getMessage('errors', 'E009', ['Email']),
            'name.required' => MessageUtil::getMessage('errors', 'E001', ['Name']),
            'password.required' => MessageUtil::getMessage('errors', 'E001', ['Password']),
            'user_flag.required' => MessageUtil::getMessage('errors', 'E001', ['User flag']),
            'user_id.numeric' => MessageUtil::getMessage('errors', 'E012', ['User ID','number']),
            'user_flag.in' => MessageUtil::getMessage('errors', 'E012', ['User flag','0, 1 or 2']),
            'date_of_birth.date_format' => MessageUtil::getMessage('errors', 'E012', ['Date of birth','YYYY-mm-dd']),
        ];
    }

    public function chunkSize(): int {
        return 200;
    }

    public function uniqueBy() {
        return ['email', 'id'];
    }

    public function batchSize(): int {
        return 1000;
    }
}