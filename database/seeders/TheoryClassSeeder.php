<?php

namespace Database\Seeders;

use App\Models\TheoryClass;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TheoryClassSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $classes = [];
        $classes[0] = [
            'day' => 7,
            'branch_id' => 1,
        ];
        $classes[1] = [
            'day' => 1,
            'branch_id' => 1,
        ];
        $classes[2] = [
            'day' => 7,
            'branch_id' => 2,
        ];

        foreach ($classes as $class) {
            TheoryClass::create($class);
        }
    }
}
