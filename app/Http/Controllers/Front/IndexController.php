<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;

class IndexController extends Controller
{
    public function index(){
        // Get Featured Items
        $featuredItemsCount = Product::where('is_featured', 'Yes')->count();
        $featuredItems = Product::where('is_featured', 'Yes')->get()->toArray();
        $featuredItemsChunk = array_chunk($featuredItems, 4);

        // Get New Products 
        $newMaxproProducts = Product::where('section_id', 1)->where('status', 1)->orderBy('id','Desc')->limit(4)->get()->toArray();
        $newHhoseProducts = Product::where('section_id', 2)->where('status', 1)->orderBy('id','Desc')->limit(2)->get()->toArray();
        $newShimgeProducts = Product::where('section_id', 3)->where('status', 1)->orderBy('id','Desc')->limit(2)->get()->toArray();

        // Get Exclusive Product
        $exclusiveProduct = Product::where('is_exclusive', 'Yes')->where('status', 1)->limit(1)->get();
        
        $page_name = "index";
        return view('front.index')->with(compact('page_name', 'featuredItemsCount', 'featuredItemsChunk', 'newMaxproProducts', 'newHhoseProducts', 'newShimgeProducts', "exclusiveProduct"));
    }
}
