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
        Schema::create('herbs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('sciname');
            $table->string('famname');
            $table->string('genname');
            $table->string('alias');
            $table->string('type');
            $table->string('medparts');
            $table->string('effect');
            $table->string('area');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('herbs');
    }
};