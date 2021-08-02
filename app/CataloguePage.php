<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CataloguePage extends Model
{
    use HasFactory;

    public static function CataloguePageDetails(){
        $cataloguePageDetails = CataloguePage::where('status', 1)->get();
        return $cataloguePageDetails;
    }  
}
