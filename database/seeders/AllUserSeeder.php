<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AllUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create Admin User
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole('Admin');

        // Create Owner Users
        $owner1 = User::create([
            'name' => 'Owner1',
            'email' => 'owner1@gmail.com',
            'password' => Hash::make('password'),
        ]);
        $owner1->assignRole('Owner');

        $owner2 = User::create([
            'name' => 'Owner2',
            'email' => 'owner2@gmail.com',
            'password' => Hash::make('password'),
        ]);
        $owner2->assignRole('Owner');

        $owner3 = User::create([
            'name' => 'Owner3',
            'email' => 'owner3@gmail.com',
            'password' => Hash::make('password'),
        ]);
        $owner3->assignRole('Owner');

        // Create Direktur Users
        $direktur1 = User::create([
            'name' => 'Direktur1',
            'email' => 'direktur1@gmail.com',
            'password' => Hash::make('password'),
        ]);
        $direktur1->assignRole('Direktur');

        $direktur2 = User::create([
            'name' => 'Direktur2',
            'email' => 'direktur2@gmail.com',
            'password' => Hash::make('password'),
        ]);
        $direktur2->assignRole('Direktur');

        // Create Accountant User
        $accountant = User::create([
            'name' => 'Accountant',
            'email' => 'accountant@gmail.com',
            'password' => Hash::make('password'),
        ]);
        $accountant->assignRole('Accountant');

        // Create Manajer User
        $manajer = User::create([
            'name' => 'Manajer',
            'email' => 'manajer@gmail.com',
            'password' => Hash::make('password'),
        ]);
        $manajer->assignRole('Manajer');

        // Create Head of Warehouse User
        $headOfWarehouse = User::create([
            'name' => 'Head of Warehouse',
            'email' => 'headofwarehouse@gmail.com',
            'password' => Hash::make('password'),
        ]);
        $headOfWarehouse->assignRole('Head of Warehouse');

        // Create Cashier Users
        $cashier1 = User::create([
            'name' => 'Cashier1',
            'email' => 'cashier1@gmail.com',
            'password' => Hash::make('password'),
        ]);
        $cashier1->assignRole('cashier');

        $cashier2 = User::create([
            'name' => 'Cashier2',
            'email' => 'cashier2@gmail.com',
            'password' => Hash::make('password'),
        ]);
        $cashier2->assignRole('Cashier');
    }
}
