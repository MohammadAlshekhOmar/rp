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
        Schema::create('payment_method_translations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('locale')->index();

            $table->unique(['payment_method_id', 'locale']);
            $table->foreignId("payment_method_id")->nullable()->constrained("payment_methods")->onDelete("cascade");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_method_translations');
    }
};
