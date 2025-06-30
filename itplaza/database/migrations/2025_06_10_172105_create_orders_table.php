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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->date('date_completed')->nullable();
            $table->string('name');
            $table->string('phone_number')->nullable();
            $table->boolean('payment')->default(false);
            $table->boolean('transfer')->default(false);
            $table->boolean('check')->default(false);
            $table->boolean('wrong')->default(false);
            $table->boolean('verified')->default(false);
            $table->boolean('incomplete')->default(false);
            $table->string('performer')->nullable();
            $table->string('delivery')->nullable();
            $table->string('address')->nullable();
            $table->text('about_delivery')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
