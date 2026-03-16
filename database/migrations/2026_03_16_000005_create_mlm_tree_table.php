<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('mlm_tree', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ancestor_id');   // upline
            $table->unsignedBigInteger('descendant_id'); // downline
            $table->unsignedSmallInteger('distance');       // depth: 0=self, 1=direct, 2=indirect, etc.
            $table->foreign('ancestor_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('descendant_id')->references('id')->on('users')->cascadeOnDelete();
            $table->index(['ancestor_id', 'distance']);
            $table->index(['descendant_id']);
            $table->unique(['ancestor_id', 'descendant_id']);
        });
    }
    public function down(): void { Schema::dropIfExists('mlm_tree'); }
};