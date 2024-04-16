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

    /**
     * Process and update/create user data based on the given row from Excel.
     *
     * @param array $row An array representing a row of data from Excel.
     * @return User|null Returns the updated user object if user ID is provided, 
     *                  otherwise creates and returns a new user object.
     * @throws \Maatwebsite\Excel\Validators\ValidationException Thrown when validation fails.
     */
    public function model(array $row) {
        // Increment row number for tracking purposes.
        ++$this->rowNum;

        // Extract data from the row.
        $userId = $row['user_id'];
        $this->$userId = $userId;
        $password = $row['password'];
        $isBcryptHash = preg_match('/^\$2y\$/', $password);
        if (!$isBcryptHash) {
            $password = Hash::make($password); // Hash the password if it's not already hashed.
        }
        $userFlg = $row['user_flag'];
        $dateOfBirth = $row['date_of_birth'];
        $name = $row['name'];
        $email = $row['email'];

        // Check if user ID is provided.
        if (!empty($userId)) {

            // Find the user by ID.
            $user = User::find($userId);
            if (!$user) {
                // If user does not exist, throw validation exception.
                $error = ['0' => MessageUtil::getMessage('errors', 'E015', ['User ID'])];
                $failures[] = new Failure($this->rowNum, 'User ID', $error, $row);
                
                throw new \Maatwebsite\Excel\Validators\ValidationException(
                    \Illuminate\Validation\ValidationException::withMessages($error),
                    $failures
                );
            }

            // Check if email exists for another user.
            $existsEmail = User::where('email', $email)->exists();

            if ($user->email !== $email && $existsEmail) {
                // If email exists for another user, throw validation exception.
                $error = ['0' => MessageUtil::getMessage('errors', 'E009', ['Email'])];
                $failures[] = new Failure($this->rowNum, 'User ID', $error, $row);
                throw new \Maatwebsite\Excel\Validators\ValidationException(
                    \Illuminate\Validation\ValidationException::withMessages($error),
                    $failures
                );
            }

             // Prepare data for update.
            $data =[
                'email' => $email,
                'password' => $password,
                'user_flg' => $userFlg,
                'date_of_birth' => $dateOfBirth,
                'name' => $name,
                'updated_by' => Auth::id(),
                'updated_at' => now(),
            ];
            
            // Update user data in the database.
            DB::table('users')->where('id', $userId)->update($data);
            
            // Return null as no new user is created.
            return null;

        } else {
            // If user ID is empty, create a new user.
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
        
        // Return the new user object.
        return $user;
    }

    /**
     * Define the validation rules for importing data from Excel.
     *
     * @return array An array containing the validation rules.
     */
    public function rules(): array {
        // Define validation rules for each field.
        $rules = [
            'email' => [
                'required',     // Email field is required.
                'max:100',      // Email field should not exceed 100 characters.
                new EmailRule,  // Custom email validation rule.
            ],
            'name' => 'max:50|required',   // Name field is required and should not exceed 50 characters.
            'password' => 'required',      // Password field is required.
            'user_id' => [
                'nullable',                 // User ID field can be nullable.
                'numeric',                  // User ID field should be numeric.
                new UserIdExistsRule        // Custom rule to check if user ID exists.
            ],
            'user_flag' => 'in:0,1,2|required',   // User flag field should be one of 0, 1, or 2 and is required.
            'date_of_birth' => 'date_format:Y-m-d',  // Date of birth should be in 'Y-m-d' format.
        ];

        return $rules;
    }

    /**
     * Define custom validation messages for specific validation rules.
     *
     * @return array An array containing custom validation messages.
     */
    public function customValidationMessages() {
        // Define custom error messages for specific validation rules.
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

    /**
     * Define the chunk size for reading data from the Excel file.
     *
     * @return int The chunk size.
     */
    public function chunkSize(): int {
        return 200; // Set the chunk size to 200 rows.
    }

    /**
     * Define the columns used for uniqueness checking when importing data.
     *
     * @return array An array containing the column names for uniqueness checking.
     */
    public function uniqueBy() {
        return ['email', 'id']; // Check for uniqueness based on 'email' and 'id' columns.
    }

    /**
     * Define the batch size for inserting data into the database.
     *
     * @return int The batch size.
     */
    public function batchSize(): int {
        return 1000; // Set the batch size to 1000 rows.
    }
}