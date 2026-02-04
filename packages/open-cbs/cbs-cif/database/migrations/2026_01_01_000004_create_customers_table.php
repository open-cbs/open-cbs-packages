<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cbs_cif.customers', function (Blueprint $table) {
            $table->id();
            $table->string('cif_id')->unique(); // The readable core banking ID

            $table->foreignId('person_id')->constrained('cbs_cif.persons'); // Link to biological person
            // $table->foreignId('branch_id')->constrained('cbs_branches.branches'); // Domicile branch - Commenting out for now until branch module is ready
            $table->foreignId('branch_id'); // Keeping it loosely coupled for now

            $table->string('status')->default('active'); // active, dormant, closed, frozen
            $table->string('risk_grading')->default('low'); // low, medium, high
            $table->string('kyc_status')->default('pending'); // pending, verified, rejected

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cbs_cif.customers');
    }
};
