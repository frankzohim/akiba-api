<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Brand;
use App\Models\Store;
use App\Models\ProductCategory;

class Image extends Model
{
    use HasFactory;

    public function brands(){
        return $this->belongsToMany(Brand::class);
    }

    public function categories(){
        return $this->belongsToMany(ProductCategory::class);
    }

    public function stores(){
        return $this->belongsToMany(Store::class);
    }
}
