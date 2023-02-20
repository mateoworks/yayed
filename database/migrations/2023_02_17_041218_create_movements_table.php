<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movements', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('type');
            $table->string('concept')->nullable();
            $table->double('amount');
            $table->string('description')->nullable();
            $table->dateTime('date_movement');
            $table->string('image')->nullable();
            $table->unsignedBigInteger('category_movement_id')->nullable();
            $table->foreign('category_movement_id')
                ->references('id')
                ->on('category_movements')
                ->onDelete('cascade');
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
        Schema::dropIfExists('movements');
    }
};
