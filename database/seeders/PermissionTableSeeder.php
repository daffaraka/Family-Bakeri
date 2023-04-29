<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $modules = [

            'pemesanan_bahan_baku-list',
            'pemesanan_bahan_baku-create',
            'pemesanan_bahan_baku-edit',
            'pemesanan_bahan_baku-delete',
            'stok_bahan_baku-list',
            'stok_bahan_baku-create',
            'stok_bahan_baku-edit',
            'stok_bahan_baku-delete',
            'resep_roti-list',
            'resep_roti-create',
            'resep_roti-show',
            'resep_roti-edit',
            'resep_roti-delete',
            'produksi_roti-list',
            'produksi_roti-create',
            'produksi_roti-edit',
            'produksi_roti-delete',
            'kasir-list',
            'kasir-create',
            'kasir-edit',
            'kasir-delete',
            'keuangan-list'
        ];

        foreach ($modules as $module => $permissions) {
            Permission::create([
                'name' => $permissions,
                'guard_name' => 'web',
            ]);
        }
    }
}
