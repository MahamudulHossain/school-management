<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SettingSeeder extends Seeder
{
    public function run()
    {

        $country = [
            [
                'id' => 1,
                'country_title' => 'Bangladesh',
                'country_code' => 'BD',
                'phone_code' => '880',
                'language_code' => 'Bn',
                'currency_title' => 'Bangladeshi Taka',
                'currency_code' => 'BDT',
                'currency_major' => 'Taka',
                'currency_minor' => 'Paisha',
                'currency_symbol' => '৳',
            ]
        ];
        \DB::table('countries')->insert($country);

        $setting = [
            ['id' => '1',
            'org_name' => 'Mahamudul Hossainn.',
            'org_slogan' => 'Mahamudul Hossainn',
            'address_line1' => 'Test-1,',
            'address_line2' => 'Test-2',
            'contact_no1' => '01000000000',
            'contact_no2' => NULL,
            'email' => 'info@hossainn.com',
            'web' => 'https://www.hossainn.com',
            'language' => 'en',
            'logo' => 'no-foto.png',
            'default_password' => 'Eis_777',
            'price_formats' => 'Plain',
            'country_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ];
        \DB::table('settings')->insert($setting);


    }
}
