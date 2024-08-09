<?php

namespace App\Models;
use App\Models\Store;
use App\Models\Image;
use App\Models\Brand;
use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'reference',
        'product_category_id',
        'brand_id',
        'store_id',
        'slug',
        'sku',
        'summary',
        'description',
        'price',
        'sale_quantity',
        'stock_quantity',
        'video',
        'state'
    ];

    public function Store():BelongsTo{
        return $this->belongsTo(Store::class);
    }

    public function images(){
        return $this->belongsToMany(Image::class);
    }

    public function productCategory():BelongsTo{
        return $this->belongsTo(ProductCategory::class);
    }

    public function brand():BelongsTo{
        return $this->belongsTo(Brand::class);
    }
}


