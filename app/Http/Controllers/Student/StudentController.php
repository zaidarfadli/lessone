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
}
