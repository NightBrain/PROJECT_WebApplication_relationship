<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('juniors', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('photo')->nullable();
            $table->foreignId('senior_id')->nullable()->constrained('seniors')->nullOnDelete();
            $table->boolean('is_random')->default(false);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('juniors');
    }
};
