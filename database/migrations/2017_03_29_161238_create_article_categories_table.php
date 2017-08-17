<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->text('name');
            $table->string('slug')->unique();
            $table->text('description_md')->nullable();
            $table->text('description_html')->nullable();
            $table->text('short_description')->nullable();
            $table->integer('featured_image_id')->unsigned()->nullable()->nullable();
            $table->boolean('active')->default(true);
            $table->text('tag_title')->nullable();
            $table->text('tag_description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('article_categories', function (Blueprint $table) {
            $table->foreign('featured_image_id')->references('id')->on('files');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('article_categories', function (Blueprint $table) {
            $table->dropForeign(['featured_image_id']);
        });
        Schema::dropIfExists('article_categories');
    }
}
