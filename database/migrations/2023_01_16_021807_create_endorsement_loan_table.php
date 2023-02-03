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
        Schema::create('endorsement_loan', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('endorsement_id')
                ->references('id')
                ->on('endorsements')
                ->onDelete('cascade');
            $table->foreignUuid('loan_id')
                ->references('id')
                ->on('loans')
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
        Schema::dropIfExists('endorsement_loan');
    }
};
