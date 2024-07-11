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
        Schema::create('asets', function (Blueprint $table) {
            $table->id();
            $table->string("invoice")->nullable();
            $table->string("code")->nullable();
            $table->string("name")->nullable();
            $table->string("inventory_number")->nullable();
            $table->date("purchase_date");
            $table->string("product_asset_id");
            $table->double("price", 16, 2)->default("0.00");
            $table->double("residual_value", 16, 2)->nullable();
            $table->string("depreciation_period")->nullable();
            $table->string("username")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asets');
    }
};
