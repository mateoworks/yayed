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
        Schema::create('partners', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('number')->default(0);
            $table->string('names', 100);
            $table->string('surname_father', 100);
            $table->string('surname_mother', 100)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('gender', 30)->nullable();
            $table->string('address', 200);
            $table->string('address_number', 30)->nullable();
            $table->string('barrio', 50)->nullable();
            $table->string('cp', 6)->nullable();
            $table->string('suburb', 100)->nullable();
            $table->string('municipio', 100)->nullable();
            $table->string('estado', 100)->nullable();
            $table->string('dwelling', 60)->nullable();
            $table->integer('dependents')->nullable();
            $table->string('civil_status', 50)->nullable();
            $table->string('curp', 50)->unique()->nullable();
            $table->string('key_ine', 50)->unique()->nullable();
            $table->string('image', 100)->nullable();
            $table->date('birthday')->nullable();
            $table->string('job')->nullable();
            $table->string('email')->nullable();
            $table->double('social_contribution')->default(0)->nullable();
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
        Schema::dropIfExists('partners');
    }
};
