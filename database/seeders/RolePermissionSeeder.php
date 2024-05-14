<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'Admin']);
        Role::create(['name' => 'Owner']);
        Role::create(['name' => 'Direktur']);
        Role::create(['name' => 'Accountant']);
        Role::create(['name' => 'Manajer']);
        Role::create(['name' => 'Head of Warehouse']);
        Role::create(['name' => 'Cashier']);

        // Admin permission
        $adminPermissions = [
            'pemesanan_bahan_baku-list', 'pemesanan_bahan_baku-create', 'pemesanan_bahan_baku-edit', 'pemesanan_bahan_baku-delete',
            'stok_bahan_baku-list', 'stok_bahan_baku-create', 'stok_bahan_baku-edit', 'stok_bahan_baku-delete',
            'resep_roti-list', 'resep_roti-create', 'resep_roti-edit', 'resep_roti-delete',
            'produksi_roti-list', 'produksi_roti-create', 'produksi_roti-edit', 'produksi_roti-delete',
            'kasir-list', 'kasir-create', 'kasir-edit', 'kasir-delete', 'kasir-customer', 'kasir-pemesanan',
            'user-list', 'user-create', 'user-edit', 'user-delete',
            'role-list', 'role-create', 'role-edit', 'role-delete',
            'order-list', 'order-create', 'order-edit', 'order-delete',
            'katalog-list', 'katalog-create', 'katalog-edit', 'katalog-delete',
            'realisasi-list', 'realisasi-create', 'realisasi-edit', 'realisasi-delete',
        ];

        // Owner permission
        $ownerPermissions = [
            'pemesanan_bahan_baku-list', 'pemesanan_bahan_baku-create', 'pemesanan_bahan_baku-edit', 'pemesanan_bahan_baku-delete',
            'stok_bahan_baku-list', 'stok_bahan_baku-create', 'stok_bahan_baku-edit', 'stok_bahan_baku-delete',
            'resep_roti-list', 'resep_roti-create', 'resep_roti-edit', 'resep_roti-delete',
            'produksi_roti-list', 'produksi_roti-create', 'produksi_roti-edit', 'produksi_roti-delete',
            'kasir-list', 'kasir-create', 'kasir-edit', 'kasir-delete', 'kasir-customer', 'kasir-pemesanan',
            'user-list', 'user-create', 'user-edit', 'user-delete',
            'role-list', 'role-create', 'role-edit', 'role-delete',
            'order-list', 'order-create', 'order-edit', 'order-delete',
            'katalog-list', 'katalog-create', 'katalog-edit', 'katalog-delete',
            'realisasi-list', 'realisasi-create', 'realisasi-edit', 'realisasi-delete',
        ];

        // Direktur permission
        $direkturPermissions = [
            'pemesanan_bahan_baku-list',
            'pemesanan_bahan_baku-edit',
            'keuangan-list',
            'kasir-list',
            'produksi_roti-list',
            'produksi_roti-edit',
        ];

        // Akuntan Permission
        $accountantPermissions = [
            'pemesanan_bahan_baku-list',
            'pemesanan_bahan_baku-edit',
            'kasir-list',
            'keuangan-list',
            'kasir-customer',
            'kasir-pemesanan',
        ];

        // Manajer Permission
        $manajerPermissions = [
            'kasir-list',
            'kasir-edit',
            'keuangan-list',
            'pemesanan_bahan_baku-list',
            'produksi_roti-list'
        ];

        // Head Of Warehouse Permission
        $headOfWarehousePermissions = [
            'stok_bahan_baku-list',
            'stok_bahan_baku-edit',
            'pemesanan_bahan_baku-list',
            'kasir-list',
            'realisasi-list', 'realisasi-create', 'realisasi-edit', 'realisasi-delete',
        ];

        // Kasir Permission
        $cashierPermissions = [
            'kasir-list',
            'kasir-edit',
            'produksi_roti-list',
            'produksi_roti-edit'
        ];

        // Assign permissions to roles
        $adminRole = Role::where('name', 'Admin')->first();
        $adminRole->syncPermissions($adminPermissions);

        $ownerRole = Role::where('name', 'Owner')->first();
        $ownerRole->syncPermissions($ownerPermissions);

        $direkturRole = Role::where('name', 'Direktur')->first();
        $direkturRole->syncPermissions($direkturPermissions);

        $accountantRole = Role::where('name', 'Accountant')->first();
        $accountantRole->syncPermissions($accountantPermissions);

        $manajerRole = Role::where('name', 'Manajer')->first();
        $manajerRole->syncPermissions($manajerPermissions);

        $headOfWarehouseRole = Role::where('name', 'Head of Warehouse')->first();
        $headOfWarehouseRole->syncPermissions($headOfWarehousePermissions);

        $cashierRole = Role::where('name', 'Cashier')->first();
        $cashierRole->syncPermissions($cashierPermissions);
    }
}
