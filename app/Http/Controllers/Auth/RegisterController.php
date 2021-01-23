<?php

namespace App\Http\Controllers\Auth;

use App\Models\Globals\CompanySettings;
use App\Http\Controllers\Controller;
use App\Models\Globals\PaymentTerms;
use App\Models\Globals\ExpenseType;
use App\Models\Globals\EmailTemplates;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'company_name' => ['required', 'string', 'max:255'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
//        return User::create([
//            'name' => $data['name'],
//            'email' => $data['email'],
//            'password' => Hash::make($data['password']),
//        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        //Company Entry
        $new_company = CompanySettings::create([
            'user_id' => $user['id'],
            'company_name' => $data['company_name'],
        ]);

        //Payment Terms Entry
        $days_arr = [15,30,45,60];
        foreach ($days_arr as $days){
            PaymentTerms::create([
                'user_id' => $user['id'],
                'company_id' => $new_company['id'],
                'terms_name' => 'Net '.$days,
                'terms_days' => $days,
            ]);
        }

        //Expense Types Entry
        $expense_types = [
            'Advertising And Marketing',
            'Automobile Expense',
            'Bad Debt',
            'Bank Fees and Charges',
            'Consultant Expense',
            'Contract Assets',
            'Credit Card Charges',
            'Depreciation And Amortisation',
            'Depreciation Expense',
            'IT and Internet Expenses',
            'Janitorial Expense',
            'Lodging',
            'Meals and Entertainment',
            'Merchandise',
            'Office Supplies',
            'Other Expenses',
            'Postage',
            'Printing and Stationery',
            'Raw Materials And Consumables',
            'Rent Expense',
            'Repairs and Maintenance',
            'Salaries and Employee Wages',
            'Telephone Expense',
            'Transportation Expense',
            'Travel Expense'
        ];

        foreach($expense_types as $type) {
            ExpenseType::create([
                'user_id' => $user['id'],
                'company_id' => $new_company['id'],
                'name' => $type
            ]);
        }
        
        // Email Template Entry
        EmailTemplates::create([
            'user_id' => $user['id'],
            'name' => 'Invoice',
            'slug' => 'invoice'
        ]);

        $root = base_path() . '/public/upload/'.$user['id'];
        if (!file_exists($root)) {
            mkdir($root, 0777, true);
        }
        return $user;
    }
}
