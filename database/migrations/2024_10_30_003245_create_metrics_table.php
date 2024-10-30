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
        Schema::create('metrics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('url_id')->constrained('urls')->onDelete('cascade');
            $table->string('ip_addr')->nullable();
            $table->string('device_type')->nullable();
            $table->string('browser_type')->nullable();
            $table->string('operating_system')->nullable();
            $table->string('referrer_source')->nullable();
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('metrics');
    }
};
