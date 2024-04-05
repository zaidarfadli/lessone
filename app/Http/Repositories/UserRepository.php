<?php


namespace App\Http\Repositories;

use App\HelperResponses\ApiResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use stdClass;

class UserRepository
{
    public function indexAll()
    {
        $user =  User::latest()->get();

        return $user;
    }
    public function indexStudent()
    {
        $student =  User::where('role', 'student')->get();

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


    public function createUser(Request $request)
    {
        $data = [
            'name' => $request->name,
            'role' => $request->role,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ];
        if ($request->filled('nisn')) {
            $data['nisn'] = $request->nisn;
        }
        $user = User::create($data);
        return $user;
    }

    public function deleteUser(User $user)
    {
        if (!$user->exists()) {
            return response()->json(['message' => 'Pengguna tidak ditemukan'], 404);
        }
        return $user->delete();
    }


    public function updateUser(Request $request, User $user)
    {

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        if ($request->filled('nisn')) {
            $user->nisn = $request->nisn;
        }
        $user->save();

        return $user;
    }
}
