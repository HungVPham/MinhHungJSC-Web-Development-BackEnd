<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Popup extends Model
{
    use HasFactory;

    public static function getPopup(){
        // Get Banners
        $getPopup = Popup::where('status',1)->orderBy('created_at', 'desc')->first();
        return $getPopup;
    }

    public static function countPopup(){

        $countPopup = Popup::where('status', 1)->count();

        return $countPopup;
    }
}
