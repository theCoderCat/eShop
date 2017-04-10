<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->text('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->integer('featured_image_id')->unsigned();
            $table->text('images')->nullable();
            $table->integer('brand_id')->unsigned()->nullable();
            $table->integer('category_id')->unsigned()->nullable();
            $table->boolean('active')->default(true);
            $table->boolean('featured')->default(false);
            $table->text('tag_title')->nullable();
            $table->text('tag_description')->nullable();
            $table->float('rating', 1, 1)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('products', function (Blueprint $table) {
            $table->foreign('featured_image_id')->references('id')->on('files');
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('product_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['featured_image_id']);
            $table->dropForeign(['brand_id']);
            $table->dropForeign(['category_id']);
        });
        Schema::dropIfExists('products');
    }
}
