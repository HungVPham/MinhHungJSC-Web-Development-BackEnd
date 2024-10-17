<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    public function category(){
        return $this->belongsTo('App\BlogCategory', 'category_id');
    }

    public function images(){
        return $this->hasMany('App\BlogsImage');
    }
}
