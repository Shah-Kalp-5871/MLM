<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key', 100)->unique();
            $table->text('value')->nullable();
            $table->string('type', 30)->default('string')->comment('string, integer, decimal, boolean, json');
            $table->string('group', 50)->default('general');
            $table->string('label', 200)->nullable();
            $table->boolean('is_public')->default(false)->comment('Visible to users?');
            $table->timestamps();
            $table->index('group');
        });
    }
    public function down(): void { Schema::dropIfExists('settings'); }
};