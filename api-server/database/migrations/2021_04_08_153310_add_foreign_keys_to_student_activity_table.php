<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToStudentActivityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('student_activity', function (Blueprint $table) {
            $table->foreign('student_id', 'student_activity_student_fk')->references('student_id')->on('student')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('subject_id', 'student_activity_subject_fk')->references('subject_id')->on('subject')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('student_activity', function (Blueprint $table) {
            $table->dropForeign('student_activity_student_fk');
            $table->dropForeign('student_activity_subject_fk');
        });
    }
}
