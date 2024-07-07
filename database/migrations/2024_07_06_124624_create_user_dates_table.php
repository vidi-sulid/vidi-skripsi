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
        Schema::create('user_dates', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->dateTime('date_start', 0);
            $table->dateTime('date_end', 0);
            $table->string('description');
            $table->string('user_id', 11)->default(false);
            $table->timestamps();
            $table->string('username', 50)->default('');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_dates');
    }
};
