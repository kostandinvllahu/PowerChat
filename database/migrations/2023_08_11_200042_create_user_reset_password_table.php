<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_reset_passwords', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->longText('token');
            $table->timestamp('expires_at')->default(\Carbon\Carbon::now()->addHour());
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_reset_passwords');
    }
};
