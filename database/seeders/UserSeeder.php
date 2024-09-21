<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'John Doe',
            'employee_id' => '001',
            'position' => 'GM',
            'department' => 'PC_Res',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'Jane Smith',
            'employee_id' => '002',
            'position' => 'GL',
            'department' => 'LS_Dept',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'Alice Johnson',
            'employee_id' => '003',
            'position' => 'TL',
            'department' => 'MS_Dept',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'Bob Lee',
            'employee_id' => '004',
            'position' => 'SiSP/SP.',
            'department' => 'GS_Dept',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'Charlie Kim',
            'employee_id' => '005',
            'position' => 'SiSP/SP.',
            'department' => 'BS_Dept',
            'password' => Hash::make('password123'),
        ]);

        // 新しい5件のレコード
        User::create([
            'name' => 'David Park',
            'employee_id' => '006',
            'position' => 'GM',
            'department' => 'Ch_Dept',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'Emily Davis',
            'employee_id' => '007',
            'position' => 'TL',
            'department' => 'PC_Res',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'Frank Moore',
            'employee_id' => '008',
            'position' => 'GL',
            'department' => 'LS_Dept',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'Grace Lee',
            'employee_id' => '009',
            'position' => 'SiSP/SP.',
            'department' => 'MS_Dept',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'Henry Brown',
            'employee_id' => '010',
            'position' => 'TL',
            'department' => 'GS_Dept',
            'password' => Hash::make('password123'),
        ]);

    }
}
