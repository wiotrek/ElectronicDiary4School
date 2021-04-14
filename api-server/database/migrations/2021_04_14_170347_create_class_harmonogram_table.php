<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassHarmonogramTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_harmonogram', function (Blueprint $table) {
            $table->integer('class_harmonogram_id', true);
            $table->integer('class_id')->nullable()->index('class_harmonogram_class_fk');
            $table->integer('subject_id')->nullable()->index('class_harmonogram_subject_fk');
            $table->date('date_meeting');
            $table->dateTime('start_time');
            $table->dateTime('end_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('class_harmonogram');
    }
}
