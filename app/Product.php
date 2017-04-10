<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\eShopBaseModel;
use App\File;

class Product extends eShopBaseModel
{
    //
    protected $appends = ['url'];

    public function setTagsAttribute($value)
    {
        $this->attributes['tags'] = '#' . implode("#", $value) . '#';
    }

    public function getUrlAttribute($value)
    {
        return route('get-product-by-slug', ['slug' => $this->attributes['slug']]);
    }

    public function getTagsAttribute($value)
    {
        return array_values( array_filter( explode("#", $value) ) );
    }

    public function setImagesAttribute($value)
    {
        $this->attributes['images'] = '#' . implode("#", $value) . '#';
    }

    public function getImagesAttribute($value)
    {
        return array_values( array_filter( explode("#", $value) ) );
    }

    public function getProductImagesAttribute() {
        $imgID = $this->images;
        $imgs = File::whereIn('id', $imgID)->get();
        return $imgs;
    }

    public function featured_image()
    {
        return $this->hasOne('App\File', 'id', 'featured_image_id')->select('id', 'original_name');
    }

    public function brand()
    {
        return $this->belongsTo('App\Brand');
    }
    public function category()
    {
        return $this->belongsTo('App\ProductCategory', 'category_id');
    }
}
