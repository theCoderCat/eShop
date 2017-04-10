<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Parsedown;

class eShopBaseModel extends Model
{
    //
    protected function getNextIncrement() {
        $table = self::getTable();
        $id = DB::table('INFORMATION_SCHEMA.TABLES')->select('AUTO_INCREMENT as id')->where('TABLE_NAME', $table)->first()->id;
        return $id;
    }

    // process category slug
    public function setSlugAttribute($value)
    {
        $slugRequired = Schema::hasColumn(self::getTable(), 'slug');
        if (!$slugRequired) return;
        
        if (empty($value)) {
            $value = str_slug($this->attributes['name']);
        }

        if (empty($value)) {
            $value = str_slug($this->attributes['title']);
        }
        
        $this->attributes['slug'] = $value;

        // if id attribute is set, this is probably editting product
        // else, this is creating new one
        // if one other record has current slug, append the slug with "-id"
        $condition = !empty($this->attributes['id']) ? [ [ "slug", $this->attributes['slug'] ], [ "id", "<>", $this->attributes['id'] ] ] : [ [ "slug", $this->attributes['slug'] ] ];

        $exist = self::where($condition)->first();
        if ($exist) {
            $id = self::getNextIncrement();
            $this->attributes['slug'] .= "-" . $id;
        }
        
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function($model){
            if (isset($model->description_md) && !empty($model->description_md)) {
                $Parsedown = new Parsedown;
                $model->description_html = $Parsedown->text($model->description_md);
            }
        });

        self::created(function($model){
            // ... code here
        });

        self::updating(function($model){
            if (isset($model->description_md) && !empty($model->description_md)) {
                $Parsedown = new Parsedown;
                $model->description_html = $Parsedown->text($model->description_md);
            }
        });

        self::updated(function($model){
            // ... code here
        });

        self::deleting(function($model){
            // ... code here
        });

        self::deleted(function($model){
            // ... code here
        });
    }
}
