<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use Validator;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Teacher::orderBy('created_at', 'DESC')->get();
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
            "gender" => 'required|in:male,female',
            "address" => 'required|string',
            "birthday" => 'required|date',
            "phone" => 'required',
            "email" => 'required|string',
        ]);
        if ($validate->fails()) {
            return response()->json(["status" => false, "error" => $validate->errors()], 400);
        }
        Teacher::create($request->all());
        return response()->json(["status" => true, "data" => $request->all()], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Teacher  $Teacher
     * @return \Illuminate\Http\Response
     */
    public function show(Teacher $Teacher)
    {
        return $Teacher;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Teacher  $Teacher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Teacher $Teacher)
    {
        $validate = Validator::make($request->all(), [
            "name" => 'required|string',
            "gender" => 'required|in:male,female',
            "address" => 'required|string',
            "birthday" => 'required|date',
            "phone" => 'required',
            "email" => 'required|string',
        ]);
        if ($validate->fails()) {
            return response()->json(["status" => false, "error" => $validate->errors()], 400);
        }
        $Teacher->update($request->all());
        return response()->json(["status" => true, "data" => $request->all()], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Teacher  $Teacher
     * @return \Illuminate\Http\Response
     */
    public function destroy(Teacher $Teacher)
    {
        $Teacher->delete();
        return response()->json(["status" => true], 200);
    }
}
