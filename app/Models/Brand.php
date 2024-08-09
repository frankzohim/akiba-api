<?php

namespace App\Models;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'state'
    ];

    public function images():BelongsToMany{
        return $this->belongsToMany(Image::class);
    }

    public function products():HasMany{
        return $this->hasMany(Product::class)
        ->with('images');
    }
}
