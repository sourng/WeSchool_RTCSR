<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_attendances', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('exam_id');
            $table->integer('subject_id');
            $table->integer('student_id');
            $table->integer('class_id');
            $table->integer('section_id');
            $table->date('date');
            $table->integer('attendance')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exam_attendances');
    }
}
