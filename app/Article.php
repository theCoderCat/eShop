<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\eShopBaseModel;

class Article extends eShopBaseModel
{
    //
    protected $fillable = [
        'title',
        'related_products',
        'description_md',
        'short_description',
        'featured_image_id',
        'slug',
        'tags',
    ];

    public function setRelatedProductsAttribute($value)
    {
        $this->attributes['related_products'] = '#' . implode("#", $value) . '#';
    }

    public function getRelatedProductsAttribute($value)
    {
        return array_values( array_filter( explode("#", $value) ) );
    }

    public function setTagsAttribute($value)
    {
        $this->attributes['tags'] = '#' . implode("#", $value) . '#';
    }

    public function getTagsAttribute($value)
    {
        return array_values( array_filter( explode("#", $value) ) );
    }
}
