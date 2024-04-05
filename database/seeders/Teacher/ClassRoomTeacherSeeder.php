<?php

namespace Database\Seeders\Teacher;

use App\Models\ClassRoom;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ClassRoomTeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subjects = ['Matematika', 'Bahasa Indonesia', 'Bahasa Inggris', 'IPA', 'IPS', 'Seni Budaya', 'Pendidikan Agama', 'Pendidikan Jasmani', 'Tata Boga', 'Tata Busana', 'Teknologi Informasi', 'Fisika', 'Kimia', 'Biologi', 'Sejarah', 'Geografi', 'Ekonomi'];
        for ($i = 0; $i < 10; $i++) {
            ClassRoom::create([
                'name' => 'Class ' . ($i + 1),
                'class_level' => 'Level ' . rand(1, 12),
                'subject' => $subjects[array_rand($subjects)],
                'unique_code' => Str::random(5),
                'description' => 'Description for class ' . ($i + 1),
                'teacher_id' => rand(3, 4),
            ]);
        }
    }
}
