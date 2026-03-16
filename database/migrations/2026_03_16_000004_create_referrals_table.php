<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('referrals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('referrer_id');  // user who invited
            $table->unsignedBigInteger('referred_user_id');  // new user
            $table->boolean('has_invested')->default(false)->comment('Did referral make a deposit?');
            $table->timestamp('invested_at')->nullable();
            $table->timestamps();
            $table->foreign('referrer_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('referred_user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->index('referrer_id');
            $table->unique(['referrer_id', 'referred_user_id']);
        });
    }
    public function down(): void { Schema::dropIfExists('referrals'); }
};