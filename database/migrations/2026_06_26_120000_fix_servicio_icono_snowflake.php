<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('servicios')
            ->where('icono', 'snowflake')
            ->update(['icono' => 'air-conditioner']);
    }

    public function down(): void
    {
        DB::table('servicios')
            ->where('icono', 'air-conditioner')
            ->whereIn('slug', ['aires-acondicionados'])
            ->update(['icono' => 'snowflake']);
    }
};
