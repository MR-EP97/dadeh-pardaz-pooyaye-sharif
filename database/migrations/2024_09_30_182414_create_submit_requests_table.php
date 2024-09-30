<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('submit_requests', function (Blueprint $table) {
            $table->id();
            $table->string('expense');
            $table->string('description');
            $table->integer('amount');
            $table->string('attachment')->nullable();
            $table->string('iban');
            $table->string('status')->default('pending');
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submit_requests');
    }
};
