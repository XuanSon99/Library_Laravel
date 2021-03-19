<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    use HasFactory;
    protected $fillable = [
        "student_id",
        "subject_id",
        "type_score",
        "score"
    ];
    public function getStudent()
    {
        return $this->hasMany('App\Models\Student', 'id', 'student_id')->select('id', 'name');
    }
    public function getSubject()
    {
        return $this->hasMany('App\Models\Subject', 'id', 'subject_id')->select('id', 'name');
    }
    public function getTypeScore()
    {
        return $this->hasMany('App\Models\TypeMark', 'id', 'type_score')->select('id', 'name');
    }
    public function getTeacher()
    {
        return $this->hasMany('App\Models\Teacher', 'id', 'teacher_id')->select('id', 'name');
    }
    public function getClassroom()
    {
        return $this->hasMany('App\Models\Classroom', 'id', 'class_id')->select('id', 'name');
    }
    public function getGradeLevel()
    {
        return $this->hasMany('App\Models\GradeLevel', 'id', 'grade_level')->select('id', 'name');
    }
}
