<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\eShopBaseModel;

class Brand extends eShopBaseModel
{
    //
    protected $fillable = [
        'name',
        'slug',
        'description_md',
        'logo_id',
    ];

    protected $appends = ['url'];

    public function getUrlAttribute()
    {
        return route('get-brand-by-slug', ['slug' => $this->attributes['slug']]);
    }

    public function logo()
    {
        return $this->hasOne('App\File', 'id', 'logo_id')->select('id', 'original_name');
    }
}
