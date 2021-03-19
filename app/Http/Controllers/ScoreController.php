<?php

namespace App\Http\Controllers;

use App\Models\Score;
use App\Models\Student;
use App\Models\Subject;
use App\Models\TypeMark;
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
        $studentList = Score::groupBy('student_id')->select('student_id')->orderBy('created_at', 'DESC')->get()->toArray();
        $data = [];
        foreach ($studentList as $student) {
            $list = new \stdClass();
            $subjectList = Score::groupBy('subject_id')->where("student_id", $student)->select('subject_id')->get();
            $list->info = Student::where("id", $student)->select('id', 'name')->first();
            $list->subjectList = $subjectList;
            foreach ($subjectList as $key => $subject) {
                $list->subjectList[$key]->subject = Subject::where("id", $subject->subject_id)->select('id', 'name')->first();
                $type_scoreList = Score::groupBy('type_score')->where(["student_id" => $student, "subject_id" => $subject->subject_id])->select('type_score')->get();
                $list->subjectList[$key]->setAttribute('typeList', $type_scoreList);
                foreach ($type_scoreList as $k => $value) {
                    $subjectList[$key]->typeList[$k]->scoreType = TypeMark::where("id", $value->type_score)->select('id', 'name')->first();
                    $score = Score::where(["student_id" => $student, "subject_id" => $subject->subject_id, "type_score" => $value->type_score])->select('score', 'id')->orderBy('created_at', 'DESC')->get();
                    $subjectList[$key]->typeList[$k]->setAttribute('score', $score);
                }
            }
            array_push($data, $list);
        }
        // $studentList = Student::select('*')->get();
        // foreach ($studentList as $key => $value) {
        //     $studentList[$key]['scores'] = Score::select(["scores.*", "classrooms.name as className", "subjects.name as subjectName"])
        //         ->leftjoin("classrooms", 'classrooms.id', "class_id")
        //         ->leftjoin("subjects", 'subjects.id', "subject_id")
        //         ->leftjoin("type_marks", 'type_marks.id', "type_score")
        //         ->where("student_id", $value->id)->get();
        // }
        // return response()->json($studentList);
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
            // "type_score" => 'required',
            // "teacher_id" => 'required',
            // "class_id" => 'required',
            // "grade_level" => 'required',
            // "score" => 'required',
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
            // "type_score" => 'required',
            // "teacher_id" => 'required',
            // "class_id" => 'required',
            // "score" => 'required',
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
