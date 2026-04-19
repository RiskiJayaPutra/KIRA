<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleAndUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Buat Roles (Menggunakan Spatie Permission dari Fase 7)
        $roleAdmin = Role::firstOrCreate(['name' => 'admin']);
        $roleKasir = Role::firstOrCreate(['name' => 'kasir']);
        $rolePengguna = Role::firstOrCreate(['name' => 'pengguna']);

        // 2. Buat Akun Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@kira.com'],
            [
                'name' => 'Kira Commander',
                'password' => Hash::make('password'),
            ]
        );
        $admin->assignRole($roleAdmin);

        // 3. Buat Akun Kasir
        $kasir = User::firstOrCreate(
            ['email' => 'kasir@kira.com'],
            [
                'name' => 'Kira Cashier',
                'password' => Hash::make('password'),
            ]
        );
        $kasir->assignRole($roleKasir);

        // 4. Buat Akun Pengguna Biasa
        $pengguna = User::firstOrCreate(
            ['email' => 'user@kira.com'],
            [
                'name' => 'Regular Collector',
                'password' => Hash::make('password'),
            ]
        );
        $pengguna->assignRole($rolePengguna);
    }
}
