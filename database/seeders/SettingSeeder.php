<?php

namespace Database\Seeders;

use App\Models\Setting;
use Dflydev\DotAccessData\Data;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run() {
        $data = [
            'site_name' => 'Pathway Driving School',
            'site_tagline' => 'One of the leading driving school in Bangladesh',
            'head_office' => '48/3, Senpara Parbata, Mirpur-13, Dhaka- 1216',
            'email' => 'example@email.com',
            'phone' => '+8801XXXXXXXXX',
            'site_primary_color' => '#2c31b4',
            'site_accent_color' => '#1c1f76',
            'site_secondary_color' => '#f5821f',
            'site_secondary_accent_color' => '#d5690c',
            'logo_dark' => 'logo-dark.png',
            'logo_light' => 'logo-light.png',
            'favicon' => 'favicon.png',
            'header_meta_tags' => '',
            'google_map_link' => 'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d2310.725900366271!2d90.37309233234191!3d23.805435306690985!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755c12edf19290d%3A0x5125ec57891fb4d7!2sPathway!5e1!3m2!1sen!2sbd!4v1680585946197!5m2!1sen!2sbd',
            'facebook_page' => 'https://www.facebook.com/PathwayDrivingTrainingSchool',
            'youtube_channel' => 'https://www.youtube.com/PathwayBD',
            'instagram' => 'https://www.instagram.com/pathwaydrivingtrainingschool/?fbclid=IwAR0FEEOnQ-hPsKCC5TZmmhFpRn6KaADOgyL1G9wGhBuGhhiC6NQbJWugNvk',
            'linkedin' => 'https://www.linkedin.com/in/pathway-driving-training-school?fbclid=IwAR3cQbaOK4Ck2pfmSL0odk43BBR648LIYq93t2_6hIVR2FNG_FHPToUVQBM',
        ];

        foreach ($data as $key => $value) {
            Setting::create([
                'key' => $key,
                'value' => $value
            ]);
        }
    }
}
