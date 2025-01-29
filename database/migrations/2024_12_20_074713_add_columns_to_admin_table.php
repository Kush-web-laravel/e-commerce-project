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
        Schema::table('admins', function (Blueprint $table) {
            //
            $table->string('name')->after('id');
            $table->text('address')->after('email');
            $table->string('city')->after('address');
            $table->string('state')->after('city');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            //
            $table->dropColumn('name');
            $table->dropColumn('address');
            $table->dropColumn('city');
            $table->dropColumn('state');
        });
    }
};
