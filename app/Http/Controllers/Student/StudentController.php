<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\StudentStoreRequest;
use App\Http\Requests\Student\StudentUpdateRequest;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\HttpException;

class StudentController extends Controller
{
    public function index()
    {
        try {
            $data = [];
            $data['student'] = User::where('role', 'admin')->get();
            return response()->json([
                'data' => $data,
                'message' => 'Berhasil membuat seluruh data akun murid'
            ], 202);
        } catch (\Exception $e) {
            DB::rollBack();
            throw new HttpResponseException(response()->json([
                'message' => 'Gagal mengambil list akun murid'
            ], 500));
        }
    }


    public function store(StudentStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $role = 'student';
            $user = User::create([
                'name' => $request->name,
                'role' => $role,
                'username' => $request->username,
                'nisn' => $request->nisn,
                'email' => $request->em♣ail,
                'password' => Hash::make($request->password)
            ]);
            DB::commit();

            $data['user'] = new UserResource($user);
            return response()->json([
                'data' => $data,
                'message' => 'Berhasil membuat akun murid'
            ], 202);
        } catch (\Exception $e) {

            DB::rollBack();
            throw new HttpResponseException(response()->json([
                'message' => 'Gagal membuat akun murid'
            ], 500));
        }
    }





    public function show(User $user)
    {

        try {
            $data['user'] = new UserResource($user);
            return response()->json([
                'data' => $data,
                'message' => 'Berhasil Menampilkan user ' . $user->id
            ]);
        } catch (\Exception $e) {
            throw new HttpResponseException(response()->json([
                'message' => 'Gagal mengambil user dengan id tersebut'
            ], 500));
        }
    }

    public function delete(User $user)
    {
        DB::beginTransaction();
        try {
            $user->delete();
            DB::commit();

            return response()->json([
                'message' => 'Berhasil menghapus akun murid'
            ], 202);
        } catch (\Exception $e) {
            DB::rollBack();
            throw new HttpResponseException(response()->json([
                'message' => 'Gagal menghapus akun murid'
            ], 500));
        }
    }


    public function update(StudentUpdateRequest $request, User $user)
    {
        DB::beginTransaction();
        try {
            $user->name = $request->name;
            $user->nisn = $request->nisn;
            $user->email = $request->email;


            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
            $user->save();

            DB::commit();
            return response()->json([
                'message' => 'Berhasil mengupdate akun murid'
            ], 202);
        } catch (\Exception $e) {
            DB::rollBack();
            throw new HttpResponseException(response()->json([
                'message' => 'Gagal mengupdate akun murid'
            ], 500));
        }
    }
}
