<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutPage extends Model
{
    use HasFactory;

    public static function AboutPageDetails(){
        $aboutPageDetails = AboutPage::where('status', 1)->get();
        return $aboutPageDetails;
    }  
}
