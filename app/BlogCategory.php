<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    use HasFactory;

    public function subcategories(){
        return $this->hasMany('App\BlogCategory','parent_id')->where('status',1);
    }

    public function parentcategory(){
        return $this->belongsTo('App\BlogCategory','parent_id')->where('status',1)->select('id','category_name');
    }
}
