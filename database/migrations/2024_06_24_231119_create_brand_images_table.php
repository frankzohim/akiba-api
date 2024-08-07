<?php

use App\Models\Image;
use App\Models\Brand;
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
        Schema::create('brand_image', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Brand::class)
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
        Schema::dropIfExists('brand_image');
    }
};
