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
            'company_name' => 'Koperasi',
            'company_email' => 'company@test.com',
            'company_phone' => '23849238423/234234234',
            "company_chairman" => "Achmat Vidianto",
            "company_treasurer" => "Achmat Vidianto",
            "company_secretary" => "Achmat Vidianto",
            'site_logo' => 'storate/logo.png',
            'notification_email' => 'notification@test.com',
            'default_currency_id' => 1,
            'default_currency_position' => 'prefix',
            'footer_text' => 'Triangle Pos © 2021 || Developed by <strong><a target="_blank" href="https://fahimanzam.me">Fahim Anzam</a></strong>',
            'company_address' => 'Cemorokandang, Kec. Kedungkandang, Kota Malang, Jawa Timur'
        ]);
    }
}
