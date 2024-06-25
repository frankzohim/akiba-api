<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Role;
// use App\Models\Memberships_user;
// use App\Models\Announcement;
// use App\Models\Question;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class User extends Authenticatable implements Searchable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'phone_number',
        'role_id',
        'password',
        'isVerify',
        'suspended_at',
        'balance',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function ban()
    {
        $this->suspended_at = now();
        $this->save();
    }

    public function activate()
    {
        $this->suspended_at = null;
        $this->save();
    }

    // public function reviews():HasMany{
    //     return $this->hasMany(Review::class);
    // }
    public function findForPassport($username) {
        return $this->where('phone_number','=', $username)->first();
    }

    public function role():HasOne{
        return $this->hasOne(Role::class);
    }

    // public function questions():BelongsToMany{
    //     return $this->belongsToMany(Question::class)->withPivot('answer');
    // }

    // public function purchaseMembership():HasMany{
    //     return $this->hasMany(Memberships_user::class);
    // }

    // public function ads():HasMany{
    //     return $this->hasMany(Announcement::class)
    //     ->with('images')
    //     ->with('town');
    // }


    public function getSearchResult(): SearchResult
    {
        $url = "#";

        return new \Spatie\Searchable\SearchResult(
            $this,
            $this->username,
            $url,
        );
    }
}
