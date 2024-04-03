<?php


namespace App\Http\Repositories;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    public function indexAll()
    {
        $user =  User::latest()->get();

        return $user;
    }
    public function indexStudent()
    {
        $student =  User::where('role', 'admin')->get();

        return $student;
    }

    public function indexTeacher()
    {
        $teacher =  User::where('role', 'teacher')->get();

        return $teacher;
    }

    public function indexAdmin()
    {
        $admin =  User::where('role', 'admin')->get();

        return $admin;
    }


    public function createUser(Request $request, $role = 'student')
    {
        $data = [
            'name' => $request->name,
            'role' => $role,
            'username' => $request->username,
            'nisn' => $request->nisn,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ];

        if ($request->filled('nip')) {
            $data['nip'] = $request->nip;
        }

        $user = User::create($data);
    }
}
