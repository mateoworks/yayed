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
        Schema::create('payments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('number')->default(0);
            $table->date('scheduled_date');
            $table->date('made_date');
            $table->string('type')->nullable();
            $table->double('social_contribution')->nullable();
            $table->string('period')->nullable();
            $table->string('concept')->nullable();
            $table->double('principal_amount')->default(0);
            $table->double('interest_amount');
            $table->string('other')->nullable();
            $table->double('other_amount')->nullable();
            $table->mediumText('observations')->nullable();
            $table->foreignUuid('loan_id')
                ->references('id')
                ->on('loans')
                ->onDelete('cascade');
            $table->foreignUuid('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('restrict');
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
        Schema::dropIfExists('payments');
    }
};
