<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComplainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complains', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('session_id');
            $table->string('complain_type',50);
            $table->string('source',50)->nullable();
            $table->string('complain_by',100);
            $table->string('phone',30)->nullable();
            $table->string('email',100)->nullable();
            $table->date('date');
            $table->text('taken_action')->nullable();
            $table->text('note')->nullable();
            $table->string('attach_document')->nullable();
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
        Schema::dropIfExists('complains');
    }
}
