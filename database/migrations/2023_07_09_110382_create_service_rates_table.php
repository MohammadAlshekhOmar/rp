<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_rates', function (Blueprint $table) {
            $table->id();
            $table->integer('rate');
            $table->text('text')->nullable();
            $table->foreignId("service_id")->nullable()->constrained("services")->onDelete("cascade");
            $table->foreignId("user_id")->nullable()->constrained("users")->onDelete("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_rates');
    }
};
