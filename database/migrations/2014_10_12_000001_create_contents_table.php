<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('pocket_id');
            $table->text('content');
            $table->string('url')->nullable();
            $table->string('title')->nullable();
            $table->text('excerpt')->nullable();
            $table->text('image')->nullable();
            $table->timestamps();

            $table->foreign('pocket_id')->references('id')->on('pockets');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contents');
    }
}
