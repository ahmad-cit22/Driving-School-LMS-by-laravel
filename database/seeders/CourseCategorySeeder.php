<?php

namespace Database\Seeders;

use App\Models\CourseCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseCategorySeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $categories = [
            [
                'category_name' => 'Car (Manual)',
                'image' => 'def-image.jpg',
            ],
            [
                'category_name' => 'Car (Auto)',
                'image' => 'def-image.jpg',
            ],
            [
                'category_name' => 'Bike',
                'image' => 'def-image.jpg',
            ],
            [
                'category_name' => 'Scooter',
                'image' => 'def-image.jpg',
            ]
        ];
        foreach ($categories as $category) {
            CourseCategory::create($category);
        }
    }
}
