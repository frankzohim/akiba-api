<?php

use App\Models\User;
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
        Schema::create('stores', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(User::class)
            ->constrained()
            ->restrictOnUpdate()
            ->restrictOnDelete();

            $table->string('name');
            $table->string('slug');
            $table->string('email')->nullable();
            $table->string('description');
            $table->string('phone_number');
            $table->boolean('state');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};
