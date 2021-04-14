<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentActivityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_activity', function (Blueprint $table) {
            $table->integer('student_activity_id', true);
            $table->integer('student_id')->nullable()->index('student_activity_student_fk');
            $table->integer('subject_id')->nullable()->index('student_activity_subject_fk');
            $table->tinyInteger('active');
            $table->date('date_active');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_activity');
    }
}
