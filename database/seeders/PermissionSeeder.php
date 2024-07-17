<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;


class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        $role = menu();
        foreach ($role as $key => $value) {
            foreach ($value as $key1 => $value1) {
                $keyData = strtolower($key1);
                foreach ($value1 as $value2) {
                    $key = $keyData . "_" . strtolower($value2);

                    Permission::create(['name' => $key]);
                }
            }
        }
        $role3 = Role::create(['name' => 'Super-Admin']);
        $user =  User::create(['name' => 'Admin', 'email' => 'admin@test.com', 'password' => Hash::make('111'), "rekening_kas" => "1.100.20"]);
        $user->assignRole($role3);
        $user =  User::create(['name' => 'vidi', 'email' => 'atmajayasudirman123@gmail.com', 'password' => Hash::make('111'), "rekening_kas" => "1.100.20"]);
    }
}
