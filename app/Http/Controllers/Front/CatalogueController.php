<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\CataloguePage;

class CatalogueController extends Controller
{
    public function CataloguePage(){
        $currentRoute = url()->current();
        $currentRoute = str_replace("http://127.0.0.1:8000/catalogues/", "",$currentRoute);
        $catalogueRoutes = CataloguePage::where('status', 1)->get()->pluck('url')->toArray();
        // dd($cmsRoutes); die;
        if(in_array($currentRoute, $catalogueRoutes)){
            $cataloguePageDetails = CataloguePage::where('url',$currentRoute)->first()->toArray();
            return view('front.pages.catalogue_page')->with(compact('cataloguePageDetails'));
        }else{
            abort(404);
        }
    }
}
