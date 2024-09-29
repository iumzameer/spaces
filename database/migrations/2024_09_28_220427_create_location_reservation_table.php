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
        Schema::create('location_reservation', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['normal', 'commercial']);
            $table->string('etype_description')->nullable();
            $table->timestamp('from');
            $table->timestamp('to');
            $table->unsignedBigInteger('reservation_id');
            $table->unsignedBigInteger('etype_id');
            $table->unsignedBigInteger('location_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('reservation_id')->references('id')->on('reservations');
            $table->foreign('etype_id')->references('id')->on('etypes');
            $table->foreign('location_id')->references('id')->on('locations');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('location_reservation');
    }
};
