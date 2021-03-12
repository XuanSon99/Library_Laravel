<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $fillable = [
        "class_id",
        "name",
        "address",
        "gender",
        "birthday",
    ];
    public function getClass()
    {
        return $this->hasMany('App\Models\Classroom', 'id', 'class_id')->select('id', 'name');
    }
}
