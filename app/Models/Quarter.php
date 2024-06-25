<?php

namespace App\Models;
use App\Models\Town;
use App\Models\Escort;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Quarter extends Model implements Searchable
{
    use HasFactory;

    protected $fillable=[
        'quarter_name',
        'town_id'
    ];
     /**
     * Get the town that owns the quarter.
     */
    public function town()
    {
        return $this->belongsTo(Town::class);
    }

    // public function ads():HasMany{
    //     return $this->hasMany(Announcement::class);
    // }

    // public function result(){
    //     $result = $this->quarter_name.'('.$this->ads()->count().' Annonces)';
    //     return $result;
    // }

    public function getSearchResult(): SearchResult
    {
        $url = "#";
     
         return new \Spatie\Searchable\SearchResult(
            $this,
            $this->result(),
            $url
         );
    }
}
