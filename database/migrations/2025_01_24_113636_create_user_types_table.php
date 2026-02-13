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
        Schema::create('user_types', function (Blueprint $table) {
            $table->id();
			$table->string('name');
            $table->timestamps();
        });
		Schema::table('users', function (Blueprint $table) {
			$table->unsignedBigInteger('customer_type_id')->nullable()->after('user_type');
			//add relation to user_types table
			$table->foreign('customer_type_id')->references('id')->on('user_types')->onDelete('cascade');
			$table->string('company_name')->nullable()->after('email');
		});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_types');
    }
};
