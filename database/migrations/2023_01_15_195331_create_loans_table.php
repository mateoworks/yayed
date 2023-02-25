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
        Schema::create('loans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('number')->unique();
            $table->double('amount');
            $table->string('amount_letter');
            $table->double('interest')->default(2);
            $table->date('date_made');
            $table->date('date_payment');
            $table->string('status', 50)->default('activo');
            $table->foreignUuid('partner_id')
                ->references('id')
                ->on('partners')
                ->onDelete('cascade');
            $table->foreignUuid('solicitud_id')
                ->references('id')
                ->on('solicituds')
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
        Schema::dropIfExists('loans');
    }
};
