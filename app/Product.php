<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\eShopBaseModel;
use App\File;
use App\Brand;

class Product extends eShopBaseModel
{
    protected $fillable = [
        'brand_id',
        'category_id',
        'description_md',
        'featured_image_id',
        'images',
        'name',
        'slug',
        'tags',
        'price',
        'in_stock'
    ];
    //
    protected $appends = ['url', 'brand_logo'];

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

    public function getBrandLogoAttribute()
    {
        return $this->brand_id ? File::find($this->brand->id) : null;
    }
    public function category()
    {
        return $this->belongsTo('App\ProductCategory', 'category_id');
    }
}
