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
        Schema::create('rates', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['item', 'location']);
            $table->string('amount');
            $table->unsignedBigInteger('il_id'); //item_id or location_id
            $table->unsignedBigInteger('tier_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('tier_id')->references('id')->on('tiers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rates');
    }
};
