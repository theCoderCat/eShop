<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSliderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slider_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('slider_id')->unsigned();
            $table->integer('image_id')->unsigned();
            $table->text('url')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('slider_items', function (Blueprint $table) {
            $table->foreign('slider_id')->references('id')->on('sliders')->onDelete('cascade');
            $table->foreign('image_id')->references('id')->on('files');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('slider_items', function (Blueprint $table) {
            $table->dropForeign(['slider_id']);
            $table->dropForeign(['image_id']);
        });
        Schema::dropIfExists('slider_items');
    }
}
