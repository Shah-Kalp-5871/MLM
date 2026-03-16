<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('club_milestones', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('tier')->unique();            // 1–7
            $table->string('name', 100);                              // e.g. "Silver Club"
            $table->decimal('direct_business_target', 15, 2);        // Direct deposit volume needed
            $table->decimal('team_business_target', 15, 2);          // Team deposit volume needed
            $table->decimal('voucher_value', 15, 2);                  // Reward value
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('club_milestones'); }
};