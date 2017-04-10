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

    protected $appends = ['url', 'logo'];

    public function getUrlAttribute($value)
    {
        return route('get-brand-by-slug', ['slug' => $this->attributes['slug']]);
    }

    public function getLogoAttribute($value) {
        return $this->logo_image ? $this->logo_image : null;
    }

    public function logo_image()
    {
        return $this->hasOne('App\File', 'id', 'logo_id')->select('id', 'original_name');
    }
}
