<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToTeacherClassTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('teacher_class', function (Blueprint $table) {
            $table->foreign('class_id', 'teacher_class_class_fk')->references('class_id')->on('user_class')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('teacher_id', 'teacher_class_teacher_fk')->references('teacher_id')->on('teacher')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('teacher_class', function (Blueprint $table) {
            $table->dropForeign('teacher_class_class_fk');
            $table->dropForeign('teacher_class_teacher_fk');
        });
    }
}
