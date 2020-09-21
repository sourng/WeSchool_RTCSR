<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',80);
            $table->integer('category_id');
            $table->string('author',80);
            $table->string('publisher',80);
            $table->string('rack_no',20);
            $table->string('quantity',12);
            $table->text('description')->nullable();
            $table->date('publish_date',12);
            $table->string('photo',50)->default('book.png');
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
        Schema::dropIfExists('books');
    }
}
