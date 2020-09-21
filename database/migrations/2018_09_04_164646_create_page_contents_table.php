<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePageContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page_contents', function (Blueprint $table) {
			$table->increments('id');
            $table->integer('page_id');
            $table->text('page_title');
            $table->longtext('page_content')->nullable();
			$table->longtext('meta_data')->nullable();
			$table->text('seo_meta_keywords')->nullable();
			$table->text('seo_meta_description')->nullable();
            $table->string('language')->default("english");
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
        Schema::dropIfExists('page_contents');
    }
}
