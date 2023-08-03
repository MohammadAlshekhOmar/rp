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
        Schema::create('ad_translations', function (Blueprint $table) {
            $table->id();
            $table->text('text')->nullable();
            $table->string('locale')->index();

            $table->unique(['ad_id', 'locale']);
            $table->foreignId("ad_id")->nullable()->constrained("ads")->onDelete("cascade");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ad_translations');
    }
};
