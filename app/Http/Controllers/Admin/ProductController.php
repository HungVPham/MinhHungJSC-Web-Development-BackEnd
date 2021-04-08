<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use Session;
use App\Section;

class ProductController extends Controller
{
    public function products(){
        Session::put('page', 'products');
        $products = Product::with(['category'=>function($query){
            $query->select('id', 'category_name');
        },'subcategory'=>function($query){
            $query->select('id', 'category_name');
        },'section'=>function($query){
            $query->select('id', 'name');
        }])->get();
        $products = json_decode(json_encode($products));
        return view('admin.products.products')->with(compact('products'));
    }

    public function updateProductStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            if($data['status']=="đang hoạt động"){
                $status = 0;
            }else{
                $status = 1;
            }
            Product::where('id',$data['product_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'product_id'=>$data['product_id']]);
        }
    }

    public function deleteProduct($id){
        // delete Product 
        Product::where('id',$id)->delete();

        $message = 'Sản phẩm đã được xóa thành công!';
        session::flash('success_message',$message);
        return redirect()->back();
    }

    public function addEditProduct(Request $request,$id=null){
        if($id==""){
            $title = "Thêm Sản Phẩm";
        }else{
            $title = "Sửa Sản Phẩm";
        }

        // Filter Arrays
        $maxpro_voltageArray = array('≤12V', '18V', '14.4V', '220-240V', '220-230V');
        $maxpro_powerArray = array('80W', '230W','240W', '250W', '300W', '320W', '350W', '400W', '450W', '500W', '550W', '600W', '620W', '680W', '710W', '750W', '760W', '800W', '850W', '900W', '950W', '1050W', '1100W', '1200W', '1250W', '1300W', '1350W', '1400W', '1500W', '1600W', '1800W', '2000W', '2100W', '2200W', '2400W', '2600W');

        // Section with Categories and Subcategories
        $categories = Section::with('categories')->get();
        $categories = json_decode(json_encode($categories), true);


        return view('admin.products.add_edit_product')->with(compact('title', 'maxpro_voltageArray', 'maxpro_powerArray', 'categories'));
    }
}
