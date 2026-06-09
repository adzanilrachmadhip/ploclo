<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('data_plo', function (Blueprint $table) {
            $table->id('id_plo');
            $table->string('nama_plo', 10)->unique();
            $table->text('description_plo');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_plo');
    }
};
