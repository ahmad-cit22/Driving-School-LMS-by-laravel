<?php

namespace Database\Seeders;

use App\Models\CourseType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseTypeSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        CourseType::create([
            'type_name' => 'Short Course',
            'duration' => 5,
            'max_duration' => 8,
        ]);
        CourseType::create([
            'type_name' => 'Long Course',
            'duration' => 10,
            'max_duration' => 15,
        ]);
    }
}
