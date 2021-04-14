<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToStudentSubjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('student_subject', function (Blueprint $table) {
            $table->foreign('student_id', 'student_subject_student_fk')->references('student_id')->on('student')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('subject_id', 'student_subject_subject_subject_id_fk')->references('subject_id')->on('subject')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('student_subject', function (Blueprint $table) {
            $table->dropForeign('student_subject_student_fk');
            $table->dropForeign('student_subject_subject_subject_id_fk');
        });
    }
}
