<?php

namespace App\Http\Controllers\Teacher;

use App\HelperResponses\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Repositories\Teacher\ClassRoomTeacherRepository;
use App\Http\Requests\ClassRoom\ClassRoomUpdateRequest;
use App\Http\Requests\ClassRoomStoreRequest;
use App\Http\Resources\ClassRoomResource;
use App\Models\ClassRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use stdClass;

class ClassRoomTeacherController extends Controller
{
    public function index()
    {
        try {
            $data = [];
            $dataRepo = new ClassRoomTeacherRepository();
            $class = $dataRepo->index();
            $data['classRoom'] = ClassRoomResource::collection($class);
            return ApiResponse::success($data, "Berhasil mengambil kelas room", 202);
        } catch (\Exception $e) {
            return  ApiResponse::error($e, "Gagal mengambil list user", 500);
        }
    }

    public function store(ClassRoomStoreRequest $request)
    {

        DB::beginTransaction();
        try {
            $dataRepo = new ClassRoomTeacherRepository();
            $classRoom = $dataRepo->store($request);
            DB::commit();
            $data['classRoom'] = new ClassRoomResource($classRoom);
            return ApiResponse::success($data, "Berhasil membuat kelas room baru", 202);
        } catch (\Exception $e) {
            DB::rollBack();
            return  ApiResponse::error($e, "Gagal membuat kelas room", 500);
        }
    }

    public function delete(ClassRoom $classRoom)
    {
        DB::beginTransaction();
        try {
            $dataRepo = new ClassRoomTeacherRepository();
            $classRoom = $dataRepo->delete($classRoom);
            DB::commit();
            return ApiResponse::success(new stdClass, "Berhasil menghapus kelass room", 202);
        } catch (\Exception $e) {
            DB::rollBack();
            return  ApiResponse::error($e, "Gagal menghapus kelas room", 500);
        }
    }

    public function update(ClassRoomUpdateRequest $request, ClassRoom $classRoom)
    {

        DB::beginTransaction();
        try {
            $dataRepo = new ClassRoomTeacherRepository();
            $classRoom = $dataRepo->update($request, $classRoom);
            DB::commit();
            $data['classRoom'] = new ClassRoomResource($classRoom);
            return ApiResponse::success($data, "Berhasil menguodate kelas room", 202);
        } catch (\Exception $e) {
            DB::rollBack();
            return  ApiResponse::error($e, "Gagal mengupdate kelas room", 500);
        }
    }

    public function updateCode(ClassRoom $classRoom)
    {

        DB::beginTransaction();
        try {
            $dataRepo = new ClassRoomTeacherRepository();
            $classRoom = $dataRepo->generateNewUniqueCode($classRoom);
            DB::commit();
            $data['classRoom'] = new ClassRoomResource($classRoom);
            return ApiResponse::success($data, "Berhasil mengubah kode unik kelas room", 202);
        } catch (\Exception $e) {
            DB::rollBack();
            return  ApiResponse::error($e, "Gagal mengubah kode unik kelas room", 500);
        }
    }
}
