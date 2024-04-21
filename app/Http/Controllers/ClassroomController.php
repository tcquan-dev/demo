<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Classroom;
use Illuminate\Http\Request;
use App\Http\Requests\ClassroomRequest;
use App\Http\Resources\ClassroomCollection;

class ClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ClassroomCollection::collection(Classroom::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClassroomRequest $request)
    {
        try {
            Classroom::create($request->all());
            return response()->json([
                'status' => 'success',
                'message' => 'Thêm lớp học thành công!'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $classroom = Classroom::find($id);
        if (!$classroom) {
            return response()->json([
                'status' => 'error',
                'message' => 'Không tìm thấy lớp họcnày!'
            ], 404);
        } else {
            return new ClassroomCollection($classroom);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $classroom = Classroom::find($id);
        if (!$classroom) {
            return response()->json([
                'status' => 'error',
                'message' => 'Không tìm thấy lớp này!'
            ], 404);
        } else {
            $classroom->update($request->all());
            return response()->json([
                'status' => 'success',
                'message' => 'Cập nhật thông tin lớp học thành công!'
            ], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $classroom = classroom::find($id);
        if (!$classroom) {
            return response()->json([
                'status' => 'error',
                'message' => 'Không tìm thấy lớp học này!'
            ], 404);
        } else {
            $classroom->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Xóa lớp học thành công!'
            ], 200);
        }
    }
}
