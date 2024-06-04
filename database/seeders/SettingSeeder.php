<?php

namespace Database\Seeders;

use App\Models\System\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::create([
            'company_name' => 'Triangle POS',
            'company_email' => 'company@test.com',
            'company_phone' => '012345678901',
            'notification_email' => 'notification@test.com',
            'default_currency_id' => 1,
            'default_currency_position' => 'prefix',
            'footer_text' => 'Triangle Pos © 2021 || Developed by <strong><a target="_blank" href="https://fahimanzam.me">Fahim Anzam</a></strong>',
            'company_address' => 'Tangail, Bangladesh'
        ]);
        // Setting::create([
        //     'company_name' => 'Pandawa Green Park',
        //     'company_email' => 'pandawa@test.com',
        //     'company_phone' => '012345678901',
        //     'notification_email' => 'notification@test.com',
        //     'default_currency_id' => 1,
        //     'default_currency_position' => 'prefix',
        //     'footer_text' => 'Pandawa © 2021 || Developed by <strong><a target="_blank" href="https://fahimanzam.me">Fahim Anzam</a></strong>',
        //     'company_address' => 'Cemorokandang, Kec. Kedungkandang, Kota Malang, Jawa Timur'
        // ]);
    }
}
