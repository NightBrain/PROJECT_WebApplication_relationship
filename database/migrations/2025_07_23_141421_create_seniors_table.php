<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('seniors', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('photo')->nullable();
            $table->enum('status', ['available', 'full'])->default('available');
            $table->integer('max_juniors')->default(1);
            $table->integer('current_juniors')->default(0);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('seniors');
    }
};
