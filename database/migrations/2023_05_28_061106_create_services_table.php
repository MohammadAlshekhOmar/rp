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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->double('price');
            $table->boolean('has_detail')->default(false);
            $table->foreignId("payment_method_id")->nullable()->constrained("payment_methods")->onDelete("cascade");
            $table->foreignId("category_id")->nullable()->constrained("categories")->onDelete("cascade");
            $table->foreignId("provider_id")->nullable()->constrained("providers")->onDelete("cascade");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
