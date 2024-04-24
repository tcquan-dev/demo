<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreTeacherRequest;
use App\Http\Requests\UpdateTeacherRequest;
use App\Http\Resources\TeacherCollecion;
use App\Models\Classroom;
use App\Models\Teacher;
use Exception;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return TeacherCollecion::collection(Teacher::orderBy('updated_at', 'desc')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTeacherRequest $request)
    {
        try {
            Teacher::create($request->all());
            return response()->json([
                'status' => 'success',
                'message' => 'Thêm giáo viên thành công!'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Add a teacher to the classroom.
     */
    public function addTeacherToClassroom(Request $request)
    {
        try {
            $teacher = Teacher::findOrFail($request['teacher_id']);
            $classroom = Classroom::findOrFail($request['classroom_id']);

            if ($teacher && $classroom->teachers()->wherePivot('teacher_id', $teacher->id)->exists()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Giáo viên đã có trong lớp học này!'
                ], 409);
            } else {
                $classroom->teachers()->attach($teacher->id);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Thêm giáo viên vào lớp học thành công!'
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove a teacher from the classroom.
     */
    public function removeTeacherFromClassroom(Request $request)
    {
        try {
            $teacher = Teacher::findOrFail($request['teacher_id']);
            $classroom = Classroom::findOrFail($request['classroom_id']);

            if ($classroom->teachers()->wherePivot('teacher_id', $teacher->id)->exists()) {
                $classroom->teachers()->detach($teacher->id);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Chuyển giáo viên ra khỏi lớp học thành công!'
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Giáo viên không có trong lớp học này!'
                ], 404);
            }
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
        $teacher = Teacher::find($id);
        if (!$teacher) {
            return response()->json([
                'status' => 'error',
                'message' => 'Không tìm thấy giáo viên này!'
            ], 404);
        } else {
            return new TeacherCollecion($teacher);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTeacherRequest $request, $id)
    {
        $teacher = Teacher::find($id);
        if (!$teacher) {
            return response()->json([
                'status' => 'error',
                'message' => 'Không tìm thấy giáo viên này!'
            ], 404);
        } else {
            $teacher->update($request->all());
            return response()->json([
                'status' => 'success',
                'message' => 'Cập nhật thông tin giáo viên thành công!'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $teacher = Teacher::find($id);
        if (!$teacher) {
            return response()->json([
                'status' => 'error',
                'message' => 'Không tìm thấy giáo viên này!'
            ], 404);
        } else {
            $teacher->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Xóa giáo viên thành công!'
            ]);
        }
    }
}
