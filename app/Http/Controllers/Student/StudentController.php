<?php

namespace App\Http\Controllers\Student;

use App\HelperResponses\ApiResponse;
use App\Http\Controllers\Controller;

use App\Http\Repositories\UserRepository;
use App\Http\Requests\Student\StudentStoreRequest;
use App\Http\Requests\Student\StudentUpdateRequest;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use stdClass;
use Symfony\Component\HttpKernel\Exception\HttpException;

class StudentController extends Controller
{
    public function index()
    {
        try {
            $data = [];
            $dataRepo = new UserRepository();
            $user = $dataRepo->indexStudent();
            $data['student'] = UserResource::collection($user);
            return ApiResponse::success($data, "Berhasil mengambil seluruh data akun murid", 202);
        } catch (\Exception $e) {
            DB::rollBack();
            return  ApiResponse::error($e, "Gagal mengambil list akun murid", 500);
        }
    }


    public function store(StudentStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $dataRepo = new UserRepository();
            $role = 'student';
            $user = $dataRepo->createUser($request, $role);
            DB::commit();
            $data['user'] = new UserResource($user);
            return  ApiResponse::success($data, "Berhasil membuat user murid", 202);
        } catch (\Exception $e) {
            DB::rollBack();
            return  ApiResponse::error($e, "Gagal membuat user murid", 500);
        }
    }



    public function show(User $user)
    {

        try {
            $data['user'] = new UserResource($user);
            $message = "Berhasil menampilkan user dengan id" . $user->id;
            return ApiResponse::success($data, $message, 202);
        } catch (\Exception $e) {
            return ApiResponse::error($e, "Gagal menampilkan user murid", 500);
        }
    }

    public function delete(User $user)
    {
        DB::beginTransaction();
        try {
            $userRepo = new UserRepository();
            $userData = $userRepo->deleteUser($user);

            DB::commit();
            return  ApiResponse::success(new stdClass, "Berhasil menghapus user murid", 202);
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error($e, "Gagal menghapus user murid", 500);
        }
    }


    public function update(StudentUpdateRequest $request, User $user)
    {
        DB::beginTransaction();
        try {
            $data = [];
            $userRepo = new UserRepository();
            $userData = $userRepo->updateUser($request, $user);
            DB::commit();
            $data['user'] = new UserResource($user);
            return ApiResponse::success($data, "Berhasil mengupdate user murid", 202);
        } catch (\Exception $e) {
            DB::rollBack();
            return  ApiResponse::error($e, "Gagal mengupdate user murid", 500);
        }
    }
}
