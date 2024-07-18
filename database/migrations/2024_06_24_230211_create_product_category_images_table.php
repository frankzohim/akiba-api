<?php

use App\Models\ProductCategory;
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
        Schema::create('image_product_category', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ProductCategory::class)
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
        Schema::dropIfExists('image_product_category');
    }
};
