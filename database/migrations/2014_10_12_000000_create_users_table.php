<?php

use App\Models\Role;
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
        Schema::disableForeignKeyConstraints();
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('email')->unique()->nullable();
            $table->foreignIdFor(Role::class)
            ->constrained()
            ->restrictOnUpdate()
            ->restrictOnDelete();
         
            $table->timestamp('email_verified_at')->nullable();
            $table->string("phone_number")->unique();
            $table->string('password');
            $table->boolean('isSecure')->default(0);
            $table->boolean('isSubscribe')->default(0);
            $table->boolean('isVerify')->default(0);
            $table->rememberToken();
            $table->integer('balance')->default(0);
            $table->string('position');
            $table->timestamp('suspended_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
