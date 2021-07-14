<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;

class IndexController extends Controller
{
    public function index(){
        // Get Featured Items
        $featuredItemsCount = Product::where('is_featured', 'Yes')->where('status', 1)->count();
        $featuredItems = Product::with('brand')->where('is_featured', 'Yes')->where('status', 1)->get()->toArray();
        $featuredItemsChunk = array_chunk($featuredItems, 4);

        // Get New Products 
        $newMaxproProducts = Product::with('brand')->where('section_id', 1)->where('status', 1)->orderBy('id','Desc')->limit(4)->get()->toArray();
        $newHhoseProducts = Product::with('brand')->where('section_id', 2)->where('status', 1)->orderBy('id','Desc')->limit(2)->get()->toArray();
        $newShimgeProducts = Product::with('brand')->where('section_id', 3)->where('status', 1)->orderBy('id','Desc')->limit(2)->get()->toArray();

        // Get Exclusive Product
        $exclusiveProduct = Product::with('brand')->where('is_exclusive', 'Yes')->where('status', 1)->limit(1)->get();
        
        $page_name = "index";
        return view('front.index')->with(compact('page_name', 'featuredItemsCount', 'featuredItemsChunk', 'newMaxproProducts', 'newHhoseProducts', 'newShimgeProducts', "exclusiveProduct"));
    }
}
