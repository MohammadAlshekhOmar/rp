<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('provider_regions', function (Blueprint $table) {
            $table->id();
            $table->foreignId("provider_id")->nullable()->constrained("providers")->onDelete("cascade");
            $table->foreignId("region_id")->nullable()->constrained("regions")->onDelete("cascade");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('provider_regions');
    }
};
