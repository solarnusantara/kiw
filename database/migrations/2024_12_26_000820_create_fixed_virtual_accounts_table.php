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
        Schema::create('fixed_virtual_accounts', function (Blueprint $table) {
			$table->id();
            $table->string('external_id')->unique();
            $table->string('bank_code');
            $table->string('name');
            $table->boolean('is_single_use');
            $table->integer('expected_amount');
            $table->string('account_number')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fixed_virtual_accounts');
    }
};
