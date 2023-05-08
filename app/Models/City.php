<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class City extends Model implements Searchable
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'state',
        'country',
        'coord_lon',
        'coord_lat',
    ];

    public function getSearchResult(): SearchResult
    {
        $url = route('cities.index', $this->id);

        return new SearchResult($this, $this->name, $url);
    }
}
