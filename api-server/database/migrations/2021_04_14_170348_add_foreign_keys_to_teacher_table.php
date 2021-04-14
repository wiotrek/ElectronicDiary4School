<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToTeacherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('teacher', function (Blueprint $table) {
            $table->foreign('role_id', 'teacher_role_fk')->references('role_id')->on('role')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('user_id', 'teacher_user_fk')->references('user_id')->on('user')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('teacher', function (Blueprint $table) {
            $table->dropForeign('teacher_role_fk');
            $table->dropForeign('teacher_user_fk');
        });
    }
}
