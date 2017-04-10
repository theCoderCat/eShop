<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brands', function (Blueprint $table) {
            $table->increments('id');
            $table->text('name');
            $table->string('slug')->unique();
            $table->text('description_md')->nullable();
            $table->text('description_html')->nullable();
            $table->integer('logo_id')->unsigned();
            $table->boolean('active')->default(true);
            $table->text('tag_title')->nullable();
            $table->text('tag_description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });


        Schema::table('brands', function(Blueprint $table) {
            $table->foreign('logo_id')->references('id')->on('files');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('brands', function(Blueprint $table) {
            $table->dropForeign(['logo_id']);
        });
        Schema::dropIfExists('brands');
    }
}
