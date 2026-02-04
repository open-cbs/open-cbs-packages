<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cbs_cif.academic_informations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('person_id')->constrained('cbs_cif.persons');
            $table->string('level'); // SSC, HSC, GRADUATION
            $table->string('institute_name');
            $table->string('passing_year')->nullable();
            $table->string('result')->nullable(); // GPA, Class
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cbs_cif.academic_informations');
    }
};
