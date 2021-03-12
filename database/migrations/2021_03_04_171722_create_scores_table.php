<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("student_id");
            $table->unsignedBigInteger("subject_id");
            $table->unsignedBigInteger("teacher_id");
            $table->unsignedBigInteger("class_id");
            $table->unsignedBigInteger("type_score");
            $table->unsignedBigInteger("grade_level");
            $table->float("score");
            $table->timestamps();

            $table->foreign("student_id")->references("id")->on("students");
            $table->foreign("subject_id")->references("id")->on("subjects");
            $table->foreign("teacher_id")->references("id")->on("teachers");
            $table->foreign("class_id")->references("id")->on("classrooms");
            $table->foreign("type_score")->references("id")->on("type_marks");
            // $table->foreign("grade_level")->references("id")->on("grade_levels");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scores');
    }
}
