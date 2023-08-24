<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\UserOtp;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisterController extends Controller {
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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data) {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'mobile' => ['required', 'string', 'unique:users,mobile'],
            'nid' => ['required', 'string', 'min:10', 'unique:users,nid'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data) {
        $id_no = '#' . Str::upper(Str::random(2)) . rand(11111, 99999);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'mobile' => $data['mobile'],
            'nid' => $data['nid'],
            'id_no' => $id_no,
            'password' => Hash::make($data['password']),
        ]);

        $user->syncRoles(4);

        $otp = UserOtp::create([
            'user_id' => $user->id,
            'otp' => rand(1000, 9999),
        ]);

        $number = $data['mobile'];
        $message = "পাথওয়ে ড্রাইভিং স্কুলের ওয়েবসাইটে নিবন্ধন করার জন্য ধন্যবাদ! আপনার ওটিপি হল: " . bangla_digit($otp->otp);
        send_sms($number, $message);

        return $user;
    }
}
