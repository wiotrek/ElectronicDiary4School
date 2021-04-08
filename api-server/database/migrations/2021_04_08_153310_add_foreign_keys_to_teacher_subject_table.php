<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToTeacherSubjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('teacher_subject', function (Blueprint $table) {
            $table->foreign('subject_id', 'teacher_subject_subject_fk')->references('subject_id')->on('subject')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('teacher_id', 'teacher_subject_teacher_fk')->references('teacher_id')->on('teacher')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('teacher_subject', function (Blueprint $table) {
            $table->dropForeign('teacher_subject_subject_fk');
            $table->dropForeign('teacher_subject_teacher_fk');
        });
    }
}
