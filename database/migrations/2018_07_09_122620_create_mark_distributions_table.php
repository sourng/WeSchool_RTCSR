<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMarkDistributionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mark_distributions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mark_distribution_type',50);
            $table->decimal('mark_percentage',8,2);
            $table->string('is_exam',3)->default("no");
            $table->string('is_active',3)->default("yes");
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
        Schema::dropIfExists('mark_distributions');
    }
}
