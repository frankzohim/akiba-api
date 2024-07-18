<?php

use App\Models\Store;
use App\Models\Image;
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
        Schema::create('image_store', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Store::class)
            ->constrained()
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->foreignIdFor(Image::class)
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_images');
    }
};
