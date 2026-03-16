<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);                              // Starter, Pro, Elite
            $table->decimal('price', 15, 2);                         // Minimum investment amount
            $table->decimal('roi_percentage', 5, 2);                 // Daily ROI %
            $table->unsignedInteger('duration_days')->nullable();    // null = unlimited
            $table->text('description')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('packages'); }
};