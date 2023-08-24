<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserOtp;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $users = [];
        $users[0] = User::create([
            'name' => 'RH Rony',
            'email' => 'rhrony0009@gmail.com',
            'mobile' => '01839096877',
            'password' => Hash::make('12345678'),
            'otp_verified_at' => Carbon::now(),
        ]);

        $users[1] = User::create([
            'name' => 'Shahedul Islam Efty',
            'email' => 'efty@imbdagency.com',
            'mobile' => '01797463378',
            'password' => Hash::make('12345678'),
            'branch_id' => 1,
            'otp_verified_at' => Carbon::now(),
        ]);

        $users[2] = User::create([
            'name' => 'Mahadi Hasan Fahim',
            'email' => 'fahim@imbdagency.com',
            'mobile' => '01881012561',
            'password' => Hash::make('12345678'),
            'branch_id' => 1,
            'otp_verified_at' => Carbon::now(),
        ]);

        $users[3] = User::create([
            'name' => 'Shamim Ahmed',
            'email' => 'shamimsrk02@gmail.com',
            'mobile' => '01616531952',
            'b_date' => '2023-06-24',
            'id_no' => '#AB12345',
            'branch_id' => 1,
            'password' => Hash::make('12345678'),
            'otp_verified_at' => Carbon::now(),
        ]);

        // $users[4] = User::create([
        //     'name' => 'Nafis Ahmed',
        //     'email' => 'nafis@imbdagency.com',
        //     'mobile' => '01955350449',
        //     'password' => Hash::make('12345678'),
        //     'branch_id' => 1,
        //     'otp_verified_at' => Carbon::now(),
        // ]);

        foreach ($users as $key => $user) {
            $role_id = $key + 1;
            $user->syncRoles($role_id);
            UserOtp::create([
                'user_id' => $user->id,
                'otp' => rand(0000, 9999),
            ]);
        }
    }
}
