<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToStudentMarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('student_marks', function (Blueprint $table) {
            $table->foreign('marks_id', 'student_marks_marks_fk')->references('marks_id')->on('marks')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('marks_type_id', 'student_marks_marks_type_fk')->references('marks_type_id')->on('marks_type')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('student_id', 'student_marks_student_fk')->references('student_id')->on('student')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('subject_id', 'student_marks_subject_fk')->references('subject_id')->on('subject')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('student_marks', function (Blueprint $table) {
            $table->dropForeign('student_marks_marks_fk');
            $table->dropForeign('student_marks_marks_type_fk');
            $table->dropForeign('student_marks_student_fk');
            $table->dropForeign('student_marks_subject_fk');
        });
    }
}
