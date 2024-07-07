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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('code', 7);
            $table->date('date');
            $table->string("name", 50)->nullable();
            $table->string("gender", 1)->nullable();
            $table->string("bloodtype", 3)->nullable();
            $table->string("religion", 30)->nullable();
            $table->string("bornplace", 50)->nullable();
            $table->date('borndate')->default('1900-01-01');
            $table->string('marriagestatus', 30)->nullable();
            $table->string('work', 50)->nullable();
            $table->string('identitycardnumber', 50)->nullable();
            $table->string('familyidentitycardnumber', 30)->nullable();
            $table->string('contact', 30)->nullable();
            $table->string('email', 50)->nullable();
            $table->boolean('propertytype')->nullable();
            $table->string('address', 250)->nullable();
            $table->string('village', 250)->nullable();
            $table->string('subdistrict', 250)->nullable();
            $table->string('city', 250)->nullable();
            $table->string('zipcode', 10)->nullable();
            $table->string('principalaccount', 30)->nullable();
            $table->double('principalamount', 16, 2)->default('0.00');
            $table->string('mandatoryaccount', 30)->nullable();
            $table->double('mandatoryamount', 16, 2)->default('0.00');
            $table->boolean('status')->default(true);
            $table->string('branch_entry', 3)->nullable();
            $table->string('username', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};