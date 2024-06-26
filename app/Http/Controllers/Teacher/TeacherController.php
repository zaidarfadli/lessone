<?php

namespace App\Http\Controllers\Teacher;

use App\HelperResponses\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Repositories\UserRepository;
use App\Http\Requests\Teacher\TeacherStoreRequest;
use App\Http\Requests\Teacher\TeacherUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use stdClass;

class TeacherController extends Controller
{
    public function index()
    {
        try {
            $data = [];
            $dataRepo = new UserRepository();
            $user = $dataRepo->indexTeacher();
            $data['student'] = UserResource::collection($user);
            return ApiResponse::success($data, "Berhasil mengambil seluruh data guru", 202);
        } catch (\Exception $e) {
            DB::rollBack();
            return  ApiResponse::error($e, "Gagal mengambil list data guru", 500);
        }
    }
}
