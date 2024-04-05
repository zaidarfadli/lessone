<?php

namespace App\Http\Repositories\Student;

use App\HelperResponses\ApiResponse;
use App\Models\ClassRoom;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ClassRoomStudentRepository
{

    public function index()
    {
        $student = Auth::user();
        // Mendapatkan daftar kelas siswa
        $classRooms = $student->classRoomsStudent()->get();

        return $classRooms;
    }

    public function joinClass(Request $request)
    {
        $student = Auth::user();

        $classRoom = ClassRoom::where('unique_code', $request->unique_code)->first();

        if (!$classRoom) {
            return ApiResponse::errorWithStatus(null, 'ClassRoom tidak ditemukan', 404);
        }

        if ($student->classRoomsStudent()->where('id', $classRoom->id)->exists()) {
            return ApiResponse::errorWithStatus($classRoom, 'Anda sudah bergabung dengan kelas ini', 400);
        }
        $joinClass =  $student->classRoomsStudent()->attach($classRoom);

        return $joinClass;
    }


    public function OutClass(ClassRoom $classRoom)
    {
        $user = Auth::user();
        return $user->classRoomsStudent()->detach($classRoom);
    }
}
