<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            ['key' => 'maintenance_mode', 'value' => false],
            ['key' => 'app_name', 'value' => 'Voedselbank Maaskantje'],
            ['key' => 'max_pakket_per_gezin', 'value' => 1],
            ['key' => 'notification_enabled', 'value' => true],
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }
    }
}
