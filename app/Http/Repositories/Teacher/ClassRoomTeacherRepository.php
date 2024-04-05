<?php

namespace App\Http\Repositories\Teacher;

use App\HelperResponses\ApiResponse;
use App\Models\ClassRoom;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ClassRoomTeacherRepository
{
    public function index()
    {
        $teacher = Auth::user();
        $class = ClassRoom::where('teacher_id', $teacher->id)->latest()->get();
        return $class;
    }

    public function store(Request $request)
    {
        $teacher  = Auth::user();
        $unique_code = Str::upper(Str::random(5));
        while (ClassRoom::where('unique_code', $unique_code)->exists()) {
            $unique_code = Str::upper(Str::random(5));
        }
        $data = [
            "name" => $request->name,
            "class_level" => $request->class_level,
            "subject" => $request->subject,
            "description" => $request->description,
            'teacher_id' => $teacher->id,
            'unique_code' => $unique_code,
        ];
        $class = ClassRoom::create($data);
        return $class;
    }


    public function delete(ClassRoom $classRoom)
    {
        $user = Auth::user();
        if ($user->id !== $classRoom->teacher_id) {
            return ApiResponse::errorWithStatus(null, 'Anda tidak memiliki hak akses', 403);
        }

        if (!$classRoom) {
            return ApiResponse::errorWithStatus(null, 'ClassRoom tidak ditemukan', 404);
        }


        return $classRoom->delete();
    }


    public function update(Request $request, ClassRoom $classRoom)
    {

        $teacher = Auth::user();
        $classRoom->name = $request->name;
        $classRoom->class_level = $request->class_level;
        $classRoom->subject = $request->subject;
        $classRoom->description = $request->description;
        $classRoom->teacher_id = $teacher->id;
        $classRoom->save();

        return $classRoom;
    }

    public function generateNewUniqueCode(ClassRoom $classRoom)
    {
        $unique_code = Str::upper(Str::random(5));

        while (ClassRoom::where('unique_code', $unique_code)->where('id', '!=', $classRoom->id)->exists()) {
            $unique_code = Str::upper(Str::random(5));
        }
        $classRoom->unique_code = $unique_code;
        $classRoom->save();
        return $classRoom;
    }
}
