<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cbs_cif.persons', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable(); // Mr, Ms, Dr
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();


            // Relationships moved to person_relationships table


            $table->date('dob');
            $table->string('gender'); // M, F, O
            $table->string('blood_group')->nullable();
            $table->string('religion')->nullable();
            $table->string('occupation')->nullable();
            $table->decimal('monthly_income', 15, 2)->nullable();

            $table->string('mobile_number')->nullable();
            $table->string('email')->nullable();

            $table->string('photo_url')->nullable();
            $table->string('signature_url')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cbs_cif.persons');
    }
};
