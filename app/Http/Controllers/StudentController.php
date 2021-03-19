<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Validator;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($class_id)
    {
        if ($class_id != "all") {
            $listStudent = Student::where("class_id", $class_id)->orderBy('created_at', 'DESC')->get();
        } else {
            $listStudent = Student::orderBy('created_at', 'DESC')->get();
        }
        $data = [];
        foreach ($listStudent as $student) {
            $classroom = Student::find($student->id)->getClass->first();
            $list = new \stdClass();
            $list->id = $student->id;
            $list->class_id = $student->class_id;
            $list->classroom = $classroom;
            $list->name = $student->name;
            $list->address = $student->address;
            $list->gender = $student->gender;
            $list->birthday = $student->birthday;
            array_push($data, $list);
        }
        return $data;
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
            "class_id" => 'required',
            "name" => 'required|string',
            "address" => 'required|string',
            "gender" => 'required|in:male,female',
            "birthday" => 'required|date'
        ]);
        if ($validate->fails()) {
            return response()->json(["status" => false, "error" => $validate->errors()], 400);
        }
        Student::create($request->all());
        return response()->json(["status" => true, "data" => $request->all()], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        return $student;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        $validate = Validator::make($request->all(), [
            "class_id" => 'required',
            "name" => 'required|string',
            "address" => 'required|string',
            "gender" => 'required|in:male,female',
            "birthday" => 'required|date'
        ]);
        if ($validate->fails()) {
            return response()->json(["status" => false, "error" => $validate->errors()], 400);
        }
        $student->update($request->all());
        return response()->json(["status" => true, "data" => $request->all()], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        $student->delete();
        return response()->json(["status" => true], 200);
    }
}
