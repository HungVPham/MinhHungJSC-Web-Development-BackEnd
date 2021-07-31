<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CmsPage extends Model
{
    use HasFactory;

    
    public static function CmsPageDetails(){
        $cmsPageDetails = CmsPage::where('status', 1)->get();
        return $cmsPageDetails;
    }  
}
