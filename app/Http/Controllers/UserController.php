<?php

namespace App\Http\Controllers;

use App\HelperResponses\ApiResponse;
use App\Http\Repositories\UserRepository;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use stdClass;

class UserController extends Controller
{
    public function index()
    {
        try {
            $data = [];
            $dataRepo = new UserRepository();
            $user = $dataRepo->indexAll();
            $data['student'] = UserResource::collection($user);
            return ApiResponse::success($data, "Berhasil mengambil seluruh user", 202);
        } catch (\Exception $e) {
            return  ApiResponse::error($e, "Gagal mengambil list user", 500);
        }
    }


    public function store(UserStoreRequest $request)
    {
        if ($request->role == "admin" && $request->filled('nisn')) {
            $data['nisn'] = null;
            return response()->json([
                'info' => "admin atau guru tidak butuh nisn"
            ]);
        }
        DB::beginTransaction();
        try {
            $dataRepo = new UserRepository();

            $user = $dataRepo->createUser($request);
            DB::commit();
            $data['user'] = new UserResource($user);
            return  ApiResponse::success($data, "Berhasil membuat user", 202);
        } catch (\Exception $e) {
            DB::rollBack();
            return  ApiResponse::error($e, "Gagal membuat user", 500);
        }
    }


    public function show(User $user)
    {
        try {
            $data['user'] = new UserResource($user);
            $message = "Berhasil menampilkan user dengan id" . $user->id;
            return ApiResponse::success($data, $message, 202);
        } catch (\Exception $e) {
            return ApiResponse::error($e, "Gagal menampilkan user", 500);
        }
    }

    public function delete(User $user)
    {
        DB::beginTransaction();
        try {
            $userRepo = new UserRepository();
            $userData = $userRepo->deleteUser($user);
            DB::commit();
            return  ApiResponse::success(new stdClass, "Berhasil menghapus user ", 202);
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error($e, "Gagal menghapus user ", 500);
        }
    }



    public function update(UserUpdateRequest $request, User $user)
    {
        DB::beginTransaction();
        try {
            $data = [];
            $userRepo = new UserRepository();
            $userData = $userRepo->updateUser($request, $user);
            DB::commit();
            $data['user'] = new UserResource($user);
            return ApiResponse::success($data, "Berhasil mengupdate user", 202);
        } catch (\Exception $e) {
            DB::rollBack();
            return  ApiResponse::error($e, "Gagal mengupdate user", 500);
        }
    }
}
