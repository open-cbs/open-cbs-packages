<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cbs_cif.person_relationships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('person_id')->constrained('cbs_cif.persons')->cascadeOnDelete();
            $table->foreignId('related_person_id')->constrained('cbs_cif.persons')->cascadeOnDelete();
            $table->string('relationship_type'); // father, mother, spouse, etc.
            $table->timestamps();

            $table->unique(['person_id', 'related_person_id', 'relationship_type'], 'person_rel_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cbs_cif.person_relationships');
    }
};
