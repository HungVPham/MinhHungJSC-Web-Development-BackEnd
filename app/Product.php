<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function category(){
        return $this->belongsTo('App\Category', 'category_id');
    }

    // public function subcategory(){
    //     return $this->belongsTo('App\Category', 'subcategory_id');
    // }

    public function section(){
        return $this->belongsTo('App\Section', 'section_id');
    }

    public function MaxproAttributes(){
        return $this->hasMany('App\MaxproProductAttributes');
    }

    public function HhoseAttributes(){
        return $this->hasMany('App\HhoseProductAttributes');
    }

    public function ShimgeAttributes(){
        return $this->hasMany('App\ShimgeProductAttributes');
    }
}
