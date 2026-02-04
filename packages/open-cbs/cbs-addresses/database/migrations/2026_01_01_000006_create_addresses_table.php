<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cbs_addresses.addresses', function (Blueprint $table) {
            $table->id();
            $table->morphs('addressable'); // The entity owning this address (e.g., Customer, Branch)
            $table->string('type')->default('present'); // present, permanent, business, etc.

            // Link to standardized hierarchy
            $table->foreignId('division_id')->nullable()->constrained('cbs_addresses.divisions');
            $table->foreignId('district_id')->nullable()->constrained('cbs_addresses.districts');
            $table->foreignId('upazila_id')->nullable()->constrained('cbs_addresses.upazilas');
            $table->foreignId('union_id')->nullable()->constrained('cbs_addresses.unions');
            $table->foreignId('village_id')->nullable()->constrained('cbs_addresses.villages');

            $table->string('post_code')->nullable();
            $table->text('address_line_1')->nullable(); // House No, Road No, etc.
            $table->text('address_line_2')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cbs_addresses.addresses');
    }
};
