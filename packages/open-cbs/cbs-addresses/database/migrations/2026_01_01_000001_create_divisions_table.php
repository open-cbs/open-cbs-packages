<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cbs_addresses.divisions', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // English Name
            $table->string('bn_name')->nullable(); // Bangla Name
            $table->string('url')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cbs_addresses.divisions');
    }
};
