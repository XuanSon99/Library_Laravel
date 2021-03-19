<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    use HasFactory;
    protected $fillable = [
        "name",
        "teacher_id",
        "khoi_id",
    ];
    public function getTeacher()
    {
        return $this->hasMany('App\Models\Teacher', 'id', 'teacher_id')->select('id', 'name');
    }
    public function getKhoi()
    {
        return $this->hasMany('App\Models\GradeLevel', 'id', 'khoi_id')->select('id', 'name');
    }
}
