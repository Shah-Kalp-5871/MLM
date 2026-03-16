<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->text('address')->nullable();
            $table->string('city', 100)->nullable();
            $table->string('state', 100)->nullable();
            $table->string('country', 100)->nullable()->default('India');
            $table->string('profile_image')->nullable();
            // Payment details
            $table->string('bank_account_number', 30)->nullable();
            $table->string('bank_name', 100)->nullable();
            $table->string('ifsc_code', 15)->nullable();
            $table->string('upi_id', 100)->nullable();
            $table->string('wallet_address', 200)->nullable()->comment('USDT/Crypto address');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('user_profiles'); }
};