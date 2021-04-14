<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentMarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_marks', function (Blueprint $table) {
            $table->integer('student_marks_id', true);
            $table->integer('student_id')->nullable()->index('student_marks_student_fk');
            $table->integer('marks_id')->nullable()->index('student_marks_marks_fk');
            $table->integer('subject_id')->nullable()->index('student_marks_subject_fk');
            $table->integer('marks_type_id')->nullable()->index('student_marks_marks_type_fk');
            $table->integer('approach_number')->nullable();
            $table->string('topic', 50);
            $table->dateTime('passing_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_marks');
    }
}
