<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    // process sanitized tag
    public function setSanitizedAttribute($value)
    {
        $this->attributes['sanitized'] = str_slug($value, '_');

    }
}
