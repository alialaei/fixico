<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('feature_flag_logs', function (Blueprint $table) {
            $table->id();
            $table->string('flag_key');
            $table->string('user_identifier')->nullable();
            $table->string('decision'); // on or off
            $table->json('context')->nullable();
            $table->timestamps();

            $table->index('flag_key');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feature_flag_logs');
    }
};
