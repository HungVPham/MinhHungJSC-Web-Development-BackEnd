<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{   
    public static function getBanners(){
        // Get Banners
        $getBanners = Banner::where('status',1)->get()->toArray();
        
        return $getBanners;
    }

    public static function getMainBanner(){
        // Get Banners
        $getMainBanner = Banner::where('status',1)->where('is_main','Yes')->get()->toArray();
        
        return $getMainBanner;
    }

    public static function getSubBanners(){
        // Get Banners
        $getSubBanners = Banner::where('status', 1)->where('is_main','No')->get()->toArray();

        return $getSubBanners;
    }  
}
    
