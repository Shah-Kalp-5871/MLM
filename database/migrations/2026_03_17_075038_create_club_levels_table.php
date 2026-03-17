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
        Schema::create('club_levels', function (Blueprint $table) {
            $table->id();
            $table->integer('level')->unique();
            $table->string('title');
            $table->decimal('direct_required', 15, 2);
            $table->decimal('team_required', 15, 2);
            $table->decimal('reward_amount', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('club_levels');
    }
};
