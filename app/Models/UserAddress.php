<?php

namespace App\Models;

use App\Models\Town;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;

     protected $fillable=[
        'address_line_1',
        'address_line_2'
    ];


    public function town():HasOne{
        return $this->hasOne(Town::class);
    }

}
