<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    //
    protected $appends = ['url'];
    public function getUrlAttribute($value)
    {
        return route('getFileByIdAndName', ['id' => $this->attributes['id'], 'name' => $this->attributes['original_name']]);
    }
}
