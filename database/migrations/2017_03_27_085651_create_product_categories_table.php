<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->text('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->integer('icon_id')->unsigned();
            $table->boolean('active')->default(true);
            $table->text('tag_title')->nullable();
            $table->text('tag_description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('product_categories', function (Blueprint $table) {
            $table->foreign('icon_id')->references('id')->on('files');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_categories', function (Blueprint $table) {
            $table->dropForeign(['icon_id']);
        });
        Schema::dropIfExists('product_categories');
    }
}
