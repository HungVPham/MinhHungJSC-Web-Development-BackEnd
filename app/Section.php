<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    public function categories(){
        return $this->hasMany('App\Category','section_id')->where(['parent_id'=>'ROOT','status'=>1])->with('subcategories');
    }

    public static function sections(){
        $getSections = Section::with('categories')->where('status',1)->get();
        $getSections = json_decode(json_encode($getSections), true);
        // echo "<pre>"; print_r($getSections); die;
        return $getSections;
    }

    public static function secDetails($url){
        $secDetails = Section::select('id', 'name', 'url', 'section_description')->where('status',1)->where('url',$url)->first()->toArray();
        // dd($secDetails); die;
        $secIds = array();
        $secIds[] = $secDetails['id'];
        // dd($secIds); die;
        return array('secIds'=>$secIds,  'secDetails'=>$secDetails);
    }
}
