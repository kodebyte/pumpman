<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\EmployeeRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Buat Role
        $adminRole = EmployeeRole::firstOrCreate(
            ['code' => 'super_admin'], 
            ['name' => 'Super Admin']
        );

        EmployeeRole::firstOrCreate(
            ['code' => 'warehouse_staff'], 
            ['name' => 'Staf Gudang']
        );

        // 2. Buat User Admin
        Employee::create([
            'employee_role_id' => $adminRole->id,
            'name' => 'Super Admin',
            'email' => 'admin@kodebyte.com',
            'password' => Hash::make('password'),
        ]);
    }
}
