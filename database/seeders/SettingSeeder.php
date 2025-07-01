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
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }
    }
}
