<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToStudentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('student', function (Blueprint $table) {
            $table->foreign('class_id', 'student_class_fk')->references('class_id')->on('user_class')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('role_id', 'student_role_fk')->references('role_id')->on('role')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('user_id', 'student_user_fk')->references('user_id')->on('user')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('student', function (Blueprint $table) {
            $table->dropForeign('student_class_fk');
            $table->dropForeign('student_role_fk');
            $table->dropForeign('student_user_fk');
        });
    }
}
