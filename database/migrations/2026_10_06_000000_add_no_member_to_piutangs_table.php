<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('piutangs', function (Blueprint $table) {
            $table->unsignedBigInteger('no_member')->nullable()->after('transaksi_id');
            $table->index('no_member');
        });
    }

    public function down(): void
    {
        Schema::table('piutangs', function (Blueprint $table) {
            $table->dropIndex(['no_member']);
            $table->dropColumn('no_member');
        });
    }
};
