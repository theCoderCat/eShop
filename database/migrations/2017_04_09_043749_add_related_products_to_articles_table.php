<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRelatedProductsToArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            //
            $table->integer('category_id')->unsigned()->nullable()->after('short_description');
            $table->string('related_products')->nullable()->after('short_description');
        });

        Schema::table('articles', function (Blueprint $table) {
            //
            $table->foreign('category_id')->references('id')->on('article_categories');
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
            //
            $table->dropForeign(['category_id']);

            $table->dropColumn(['category_id', 'related_products']);
        });
    }
}
