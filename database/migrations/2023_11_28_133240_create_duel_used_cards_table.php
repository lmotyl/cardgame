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
        Schema::create('duel_used_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('duel_id')
                ->constrained();
            $table->foreignId('duel_player_id')
                ->constrained();
            $table->integer('card_id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('duel_used_cards');
    }
};
