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
        "member"
    ];
    public function getTeacher()
    {
        return $this->hasMany('App\Models\Teacher', 'id', 'teacher_id')->select('id', 'name');
    }
}
