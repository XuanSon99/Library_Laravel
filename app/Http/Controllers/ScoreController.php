<?php

namespace App\Http\Controllers;

use App\Models\Score;
use Illuminate\Http\Request;
use Validator;

class ScoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listScore = Score::orderBy('created_at', 'DESC')->get();
        $data = [];
        foreach ($listScore as $Score) {
            $teacher = Score::find($Score->id)->getTeacher->first();
            $student = Score::find($Score->id)->getStudent->first();
            $subject = Score::find($Score->id)->getSubject->first();
            $typescore = Score::find($Score->id)->getTypeScore->first();
            $classroom = Score::find($Score->id)->getClassroom->first();
            $gradelevel = Score::find($Score->id)->getGradeLevel->first();
            $list = new \stdClass();
            $list->id = $Score->id;
            $list->score = $Score->score;
            $list->student_id = $Score->student_id;
            $list->teacher_id = $Score->teacher_id;
            $list->subject_id = $Score->subject_id;
            $list->type_score = $Score->type_score;
            $list->class_id = $Score->class_id;
            $list->grade_level = $Score->grade_level;

            $list->teacher = $teacher;
            $list->student = $student;
            $list->subject = $subject;
            $list->typescore = $typescore;
            $list->classroom = $classroom;
            $list->gradelevel = $gradelevel;
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
            "student_id" => 'required',
            "subject_id" => 'required',
            "type_score" => 'required',
            "teacher_id" => 'required',
            "class_id" => 'required',
            "grade_level" => 'required',
            "score" => 'required',
        ]);
        if ($validate->fails()) {
            return response()->json(["status" => false, "error" => $validate->errors()], 400);
        }
        Score::create($request->all());
        return response()->json(["status" => true, "data" => $request->all()], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Score  $Score
     * @return \Illuminate\Http\Response
     */
    public function show(Score $Score)
    {
        return $Score;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Score  $Score
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Score $Score)
    {
        $validate = Validator::make($request->all(), [
            "student_id" => 'required',
            "subject_id" => 'required',
            "type_score" => 'required',
            "teacher_id" => 'required',
            "class_id" => 'required',
            "score" => 'required',
        ]);
        if ($validate->fails()) {
            return response()->json(["status" => false, "error" => $validate->errors()], 400);
        }
        $Score->update($request->all());
        return response()->json(["status" => true, "data" => $request->all()], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Score  $Score
     * @return \Illuminate\Http\Response
     */
    public function destroy(Score $Score)
    {
        $Score->delete();
        return response()->json(["status" => true], 200);
    }
}
