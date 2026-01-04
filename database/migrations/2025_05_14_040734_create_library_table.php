<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('libraries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('module_id')->constrained()->onDelete('cascade');
            $table->timestamp('date_added')->nullable();
            $table->timestamp('last_opened')->nullable();
            $table->integer('progress')->default(0); // in percentage
            $table->integer('time_spent')->default(0);
            $table->string('status')->default('not_started'); // not_started, in_progress, completed, etc.
            $table->boolean('is_in_library')->default(false);
            $table->timestamps();

            $table->unique(['user_id', 'module_id']); // prevent duplicate entries
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('libraries');
    }
};
