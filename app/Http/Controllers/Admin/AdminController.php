<?php

namespace App\Http\Controllers\Admin;

use App\HelperResponses\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Repositories\UserRepository;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use stdClass;

class AdminController extends Controller
{
    public function index()
    {
        try {
            $data = [];
            $dataRepo = new UserRepository();
            $user = $dataRepo->indexAdmin();
            $data['student'] = UserResource::collection($user);
            return ApiResponse::success($data, "Berhasil mengambil seluruh data akun admin", 202);
        } catch (\Exception $e) {
            return  ApiResponse::error($e, "Gagal mengambil list akun admin", 500);
        }
    }
}
