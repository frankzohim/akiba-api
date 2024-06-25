<?php

namespace App\Models;

use App\Models\Town;
use App\Models\Escort;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Country extends Model
{
    use HasFactory;

    protected $fillable=[
        'country_name'
    ];

    // public function escorts():HasMany{
    //     return $this->hasMany(Escort::class);
    // }

    public function towns():HasMany{
        return $this->hasMany(Town::class);
    }
}
