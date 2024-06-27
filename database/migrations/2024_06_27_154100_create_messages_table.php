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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('apartment_id');
            // $table->foreign('apartment_id')->references('id')->on('apartments')->onDelete('cascade');
            $table->date('date');
            $table->text('content');
            $table->string('email', 100);
            $table->string('name', 50);
            $table->string('last_name', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};