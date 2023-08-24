<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $branches = [];
        $branches[0] = [
            'branch_name' => 'Mirpur',
            'branch_address' => 'BRTA Mirpur, Dhaka',
            'email' => 'example@email.com',
            'phone' => '+88 01XXXXXXXXX',
        ];
        $branches[1] = [
            'branch_name' => 'Banani',
            'branch_address' => 'Banani, Dhaka',
            'email' => 'example@email.com',
            'phone' => '+88 01XXXXXXXXX',
        ];

        foreach ($branches as $key => $branche) {
            Branch::create($branche);
        }
    }
}
