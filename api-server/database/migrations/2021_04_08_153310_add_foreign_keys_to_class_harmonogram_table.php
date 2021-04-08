<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToClassHarmonogramTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('class_harmonogram', function (Blueprint $table) {
            $table->foreign('class_id', 'class_harmonogram_class_fk')->references('class_id')->on('user_class')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('subject_id', 'class_harmonogram_subject_fk')->references('subject_id')->on('subject')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('class_harmonogram', function (Blueprint $table) {
            $table->dropForeign('class_harmonogram_class_fk');
            $table->dropForeign('class_harmonogram_subject_fk');
        });
    }
}
