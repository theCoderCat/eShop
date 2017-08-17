<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->text('title');
            $table->string('slug')->unique();
            $table->text('description_md')->nullable();
            $table->text('description_html')->nullable();
            $table->text('short_description')->nullable();
            $table->string('tags')->nullable();
            $table->integer('featured_image_id')->unsigned()->nullable();
            $table->boolean('active')->default(true);
            $table->text('tag_title')->nullable();
            $table->text('tag_description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('articles', function (Blueprint $table) {
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
        Schema::table('articles', function (Blueprint $table) {
            $table->dropForeign(['featured_image_id']);
        });
        Schema::dropIfExists('articles');
    }
}
