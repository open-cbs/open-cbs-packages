<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() !== 'sqlite') {
            DB::statement('CREATE SCHEMA IF NOT EXISTS cbs_cif');
        }
    }

    public function down(): void
    {
        // DB::statement('DROP SCHEMA IF EXISTS cbs_cif CASCADE');
    }
};
