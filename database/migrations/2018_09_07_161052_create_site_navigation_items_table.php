<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiteNavigationItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_navigation_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('navigation_id');
			$table->string("menu_label");
			$table->text("link")->nullable();
			$table->integer('page_id')->nullable();
			$table->integer('parent_id')->nullable();
			$table->string('css_class')->nullable();
			$table->string('css_id')->nullable();
			$table->integer('menu_order')->default(100);
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
        Schema::dropIfExists('site_navigation_items');
    }
}
