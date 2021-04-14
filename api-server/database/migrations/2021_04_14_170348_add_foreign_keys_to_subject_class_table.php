<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToSubjectClassTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subject_class', function (Blueprint $table) {
            $table->foreign('subject_id', 'subject_class_subject_fk')->references('subject_id')->on('subject')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('class_id', 'subject_class_user_class_fk')->references('class_id')->on('user_class')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subject_class', function (Blueprint $table) {
            $table->dropForeign('subject_class_subject_fk');
            $table->dropForeign('subject_class_user_class_fk');
        });
    }
}
