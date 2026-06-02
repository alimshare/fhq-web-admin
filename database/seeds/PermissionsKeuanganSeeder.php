<?php

namespace Database\Seeders;

use App\Model\Permission;
use App\Model\Role;
use Illuminate\Database\Seeder;

class PermissionsKeuanganSeeder extends Seeder
{
    /**
     * Seed permission untuk modul Keuangan (kas masuk & keluar)
     * dan tetapkan ke role Administrator.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            ['name' => 'Daftar Keuangan',     'slug' => 'list-keuangan',   'category' => 'keuangan', 'sequance' => 0],
            ['name' => 'Tambah Transaksi',    'slug' => 'add-keuangan',    'category' => 'keuangan', 'sequance' => 0],
            ['name' => 'Ubah Transaksi',      'slug' => 'edit-keuangan',   'category' => 'keuangan', 'sequance' => 0],
            ['name' => 'Hapus Transaksi',     'slug' => 'delete-keuangan', 'category' => 'keuangan', 'sequance' => 0],
        ];

        $admin = Role::where('slug', 'admin')->first();

        foreach ($permissions as $data) {
            $permission = Permission::firstOrCreate(
                ['slug' => $data['slug']],
                $data
            );

            // Tetapkan ke Administrator agar langsung dapat mengakses menu.
            if ($admin) {
                $admin->permissions()->syncWithoutDetaching([$permission->id]);
            }
        }
    }
}
