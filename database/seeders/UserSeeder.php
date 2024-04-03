<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin 1',
                'role' => 'admin',
                'username' => 'admin1',
                'email' => 'admin1@example.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Admin 2',
                'role' => 'admin',
                'username' => 'admin2',
                'email' => 'admin2@example.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Teacher 1',
                'role' => 'teacher',
                'username' => 'teacher1',
                'nip' => '10101010',
                'email' => 'teacher1@example.com',
                'password' => Hash::make('password'),
            ], [
                'name' => 'Teacher 2',
                'role' => 'teacher',
                'username' => 'teacher2',
                'nip' => '12121212',
                'email' => 'teacher2@example.com',
                'password' => Hash::make('password'),
            ], [
                'name' => 'Student 1',
                'role' => 'student',
                'nisn' => '202020',
                'username' => 'student1',
                'email' => 'student1@example.com',
                'password' => Hash::make('password'),
            ], [
                'name' => 'Student 2',
                'role' => 'student',
                'nisn' => '212121',
                'username' => 'student2',
                'email' => 'student2@example.com',
                'password' => Hash::make('password'),
            ]

        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
