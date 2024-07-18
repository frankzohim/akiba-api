<?php

namespace App\Models;
use App\Models\Image;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Store extends Model
{
    use HasFactory;
     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'email',
        'phone_number',
        'description',
        'state',
        'user_id'
    ];

     public function images():BelongsToMany{
        return $this->belongsToMany(Image::class);
    }

    public function User():BelongsTo{
        return $this->belongsTo(User::class);
    }
}
