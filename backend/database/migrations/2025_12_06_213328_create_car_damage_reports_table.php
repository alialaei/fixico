<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('car_damage_reports', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('status')->default('open'); // open, in_review, closed
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('car_damage_reports');
    }
};
