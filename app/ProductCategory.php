<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    //
    // protected $table = 'product_categories';

    // process category slug
    public function setSlugAttribute($value)
    {
        if (empty($value)) {
            $this->attributes['slug'] = sanitize_title_with_dashes($this->attributes['name']);
        } else {
            $this->attributes['slug'] = sanitize_title_with_dashes($value);
        }
    }
}
