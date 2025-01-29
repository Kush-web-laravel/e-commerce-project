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
        Schema::table('users', function (Blueprint $table) {
            //
            $table->string('name')->after('id');
            $table->string('email')->after('name')->unique();
            $table->text('address')->after('mobile_number');
            $table->string('city')->after('address');
            $table->string('state')->after('city');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->dropColumn('name');
            $table->dropColumn('email');
            $table->dropColumn('address');
            $table->dropColumn('city');
            $table->dropColumn('state');
        });
    }
};
