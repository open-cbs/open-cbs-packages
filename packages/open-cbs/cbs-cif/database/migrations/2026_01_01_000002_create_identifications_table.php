<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cbs_cif.identifications', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // NID, PASSPORT, BIRTH_CERT, TIN
            $table->string('number');
            $table->date('issue_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->string('issuing_country')->nullable();
            $table->string('issuing_authority')->nullable();
            $table->json('meta_data')->nullable(); // Extra fields

            // Polymorphic relation to owner (usually Person)
            $table->morphs('identifiable');

            $table->timestamps();
            $table->softDeletes();

            $table->unique(['type', 'number']); // Prevent duplicate IDs globally
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cbs_cif.identifications');
    }
};
