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
        Schema::table('users' , function (Blueprint $table) {
            $table->uuid()->after('id');
            $table->integer('range_limit')->after('email_verified_at')->default('100');
            $table->string('responses_count')->after('range_limit')->default('0');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
