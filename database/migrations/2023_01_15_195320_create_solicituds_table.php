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
        Schema::create('solicituds', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('folio');
            $table->date('date_solicitud');
            $table->date('date_payment');
            $table->dateTime('aut_den')->nullable();
            $table->double('period');
            $table->double('mount');
            $table->mediumText('concept')->nullable();
            $table->string('condition')->default('en proceso');
            $table->foreignUuid('partner_id')
                ->references('id')
                ->on('partners')
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
        Schema::dropIfExists('solicituds');
    }
};
