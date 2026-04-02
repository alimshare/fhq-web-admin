<?php

namespace Database\Seeders;

use App\Setting;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = [
            [
                'key' => 'app_name',
                'value' => 'FHQ Web Admin',
                'type' => 'string',
                'group' => 'general',
                'description' => 'Application name displayed in the interface'
            ],
            [
                'key' => 'app_title',
                'value' => 'FHQ An-Nashr - Sistem Administrasi',
                'type' => 'string',
                'group' => 'general',
                'description' => 'Page title for the application'
            ],
            [
                'key' => 'app_description',
                'value' => 'Sistem Administrasi untuk Pengelolaan Halaqoh dan Santri FHQ An-Nashr',
                'type' => 'string',
                'group' => 'general',
                'description' => 'Application description for meta tags and SEO'
            ],
            [
                'key' => 'app_logo',
                'value' => '/assets/images/logo.png',
                'type' => 'string',
                'group' => 'appearance',
                'description' => 'Path to the application logo'
            ],
            [
                'key' => 'app_favicon',
                'value' => '/assets/images/favicon.ico',
                'type' => 'string',
                'group' => 'appearance',
                'description' => 'Path to the favicon'
            ],
            [
                'key' => 'primary_color',
                'value' => '#2196F3',
                'type' => 'string',
                'group' => 'appearance',
                'description' => 'Primary color for the application theme'
            ],
            [
                'key' => 'secondary_color',
                'value' => '#FFC107',
                'type' => 'string',
                'group' => 'appearance',
                'description' => 'Secondary color for the application theme'
            ],
            [
                'key' => 'contact_email',
                'value' => 'admin@fhq-annashr.com',
                'type' => 'string',
                'group' => 'contact',
                'description' => 'Contact email address'
            ],
            [
                'key' => 'contact_phone',
                'value' => '+62 123 456 7890',
                'type' => 'string',
                'group' => 'contact',
                'description' => 'Contact phone number'
            ],
            [
                'key' => 'organization_name',
                'value' => 'FHQ An-Nashr',
                'type' => 'string',
                'group' => 'organization',
                'description' => 'Full organization name'
            ],
            [
                'key' => 'organization_address',
                'value' => 'Jl. Contoh No. 123, Kota, Provinsi',
                'type' => 'string',
                'group' => 'organization',
                'description' => 'Organization address'
            ],
            [
                'key' => 'max_upload_size',
                'value' => '10',
                'type' => 'int',
                'group' => 'system',
                'description' => 'Maximum file upload size in MB'
            ],
            [
                'key' => 'maintenance_mode',
                'value' => '0',
                'type' => 'bool',
                'group' => 'system',
                'description' => 'Enable maintenance mode (1 = enabled, 0 = disabled)'
            ],
            [
                'key' => 'timezone',
                'value' => 'Asia/Jakarta',
                'type' => 'string',
                'group' => 'system',
                'description' => 'Application timezone'
            ],
            [
                'key' => 'language',
                'value' => 'id',
                'type' => 'string',
                'group' => 'system',
                'description' => 'Default application language (id = Indonesian, en = English)'
            ],
            [
                'key' => 'footer_text',
                'value' => '© 2026 FHQ An-Nashr. All rights reserved.',
                'type' => 'string',
                'group' => 'appearance',
                'description' => 'Footer copyright text'
            ],
            [
                'key' => 'welcome_message',
                'value' => 'Selamat datang di Sistem Administrasi FHQ An-Nashr',
                'type' => 'string',
                'group' => 'content',
                'description' => 'Welcome message displayed on dashboard'
            ],
            [
                'key' => 'terms_and_conditions',
                'value' => 'Terms and conditions content here...',
                'type' => 'string',
                'group' => 'content',
                'description' => 'Terms and conditions text'
            ],
            [
                'key' => 'privacy_policy',
                'value' => 'Privacy policy content here...',
                'type' => 'string',
                'group' => 'content',
                'description' => 'Privacy policy text'
            ]
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }
    }
}
