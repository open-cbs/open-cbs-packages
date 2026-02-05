<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() !== 'sqlite') {
            DB::statement('CREATE SCHEMA IF NOT EXISTS cbs_addresses');
        }
    }

    public function down(): void
    {
        // We generally do not drop schemas in down() to prevent data loss in production,
        // but for development it might be useful. 
        // For safety, we keep it empty or commented out.
        // DB::statement('DROP SCHEMA IF EXISTS cbs_addresses CASCADE');
    }
};
