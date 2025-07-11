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
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("email");
            $table->bigInteger("phone")->nullable();
            $table->string("message");
            $table->foreignId("plot_id")->nullable()->constrained()->cascadeOnDelete();
            $table->enum("status", ["viewed", "new", "responded", "closed"])->default("new");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inquiries');
    }
};
