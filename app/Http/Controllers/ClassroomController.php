<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Student;
use Illuminate\Http\Request;
use Validator;

class ClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listClassroom = Classroom::orderBy('created_at', 'DESC')->get();
        $data = [];
        foreach ($listClassroom as $Classroom) {
            $teacher = Classroom::find($Classroom->id)->getTeacher->first();
            $khoi = Classroom::find($Classroom->id)->getKhoi->first();
            $member = Student::where("class_id", $Classroom->id)->get()->count();
            $list = new \stdClass();
            $list->id = $Classroom->id;
            $list->teacher = $teacher;
            $list->khoi = $khoi;
            $list->name = $Classroom->name;
            $list->teacher_id = $Classroom->teacher_id;
            $list->khoi_id = $Classroom->khoi_id;
            $list->member = $member;
            array_push($data, $list);
        }
        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            "name" => 'required|string',
            "teacher_id" => 'required',
            "member" => 'required|integer'
        ]);
        if ($validate->fails()) {
            return response()->json(["status" => false, "error" => $validate->errors()], 400);
        }
        Classroom::create($request->all());
        return response()->json(["status" => true, "data" => $request->all()], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Classroom  $classroom
     * @return \Illuminate\Http\Response
     */
    public function show(Classroom $classroom)
    {
        return Student::where("class_id", $classroom->id)->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Classroom  $classroom
     * @return \Illuminate\Http\Response
     */
    public function edit(Classroom $classroom)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Classroom  $classroom
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Classroom $classroom)
    {
        $validate = Validator::make($request->all(), [
            "name" => 'required|string',
            "teacher_id" => 'required',
            "member" => 'required|integer'
        ]);
        if ($validate->fails()) {
            return response()->json(["status" => false, "error" => $validate->errors()], 400);
        }
        $classroom->update($request->all());
        return response()->json(["status" => true, "data" => $request->all()], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Classroom  $classroom
     * @return \Illuminate\Http\Response
     */
    public function destroy(Classroom $classroom)
    {
        $classroom->delete();
        return response()->json(["status" => true], 200);
    }
}
