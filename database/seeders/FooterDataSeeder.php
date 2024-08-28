<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FooterDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('header_footer')->insert([
            'column_1_heading_1' => 'About Uzaq',
            'column_1_field_1' => 'Field 1 Value',
            'column_1_field_2' => 'Field 2 Value',
            'column_1_field_3' => 'Field 3 Value',
            'column_1_field_4' => 'Field 4 Value',
            'column_2_heading_1' => 'Our Policy',
            'column_2_field_1' => 'Privacy Policy',
            'column_2_field_2' => 'Terms of Use',
            'column_2_field_3' => 'Terms & Conditions',
            'column_3_heading_1' => 'Contact Us',
            'column_3_field_1' => '+91 9816900193',
            'column_3_field_2' => 'uzaqinfo@gmail.com',
            'column_3_field_3' => 'Bangalore, Karnataka IN',
        ]);
    }
}
