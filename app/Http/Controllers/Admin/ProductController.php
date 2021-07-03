<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use Session;
use App\Section;
use App\Category;
use App\ProductsImage;
use Image;
use App\MaxproProductAttributes;
use App\HhoseProductAttributes;
use App\ShimgeProductAttributes;
use App\Brand;


class ProductController extends Controller
{
    public function products(){
        Session::put('page', 'products');
        $products = Product::with(['category'=>function($query){
            $query->select('id', 'category_name');
        }
        ,'section'=>function($query){
            $query->select('id', 'name');
        }
        ,'brand'=>function($query){
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
        // Delete Product 
        Product::where('id',$id)->delete();

        $message = 'Sản phẩm đã được xóa thành công!';
        session::flash('success_message',$message);
        return redirect()->back();
    }

    public function addEditProduct(Request $request,$id=null){
        if($id==""){
            $title = "Thêm Sản Phẩm";
            $product = new Product;
            $productdata = array();
            $message = "Sản phẩm đã được thêm thành công!";
        }else{
            $title = "Sửa Sản Phẩm";
            $productdata = Product::find($id);
            $productdata = json_decode(json_encode($productdata),true);
            // echo "<pre>"; print_r($productdata); die;
            $product = Product::find($id);
            $message = "Sản phẩm đã được cập nhật thành công!";
        }

        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

             // Product Validations
            $rules = [
                'product_name' => 'required',
                'category_id' => 'required',
                'product_code' => 'required|regex:/^[\w-]*$/',
                'brand_id' => 'required',
                // 'main_image' => 'required',
            ];  
            $customMessages = [
                'category_id.required' => 'Vui lòng chọn thể loại sản phẩm.',
                'product_name.required' => 'Vui lòng đặt tên sản phẩm.',
                'brand_id.required' => 'Vui lòng chọn thương hiệu sản phẩm.',
                //'main_image.required' => 'Vui lòng chọn hình ảnh đại diện SP.',
                'product_code.required' => 'Vui lòng đăt mã sản phẩm.',
                'product_code.regex' => 'Vui lòng đạt mã hợp lệ sản phẩm. Ví dụ: SGP01, MP01, SPF01,...',
            ];
            $this->validate($request, $rules, $customMessages);

            // if(empty($data['is_featured'])){
            //     $is_featured = "No";
            // }else{
            //     $is_featured = "Yes";
            // }

            // Upload Product Images
            if($request->hasFile('main_image')){
                $image_tmp = $request->file('main_image');
                if($image_tmp->isValid()){
                    // get image original name
                    $image_name = $image_tmp->getClientOriginalName();
                    $imageName = rand(1,999999).'_'.$image_name;
                    $large_image_path = 'images/product_images/main_image/large/'.$imageName;
                    $medium_image_path = 'images/product_images/main_image/medium/'.$imageName;
                    $small_image_path = 'images/product_images/main_image/small/'.$imageName;
                    Image::make($image_tmp)->resize(750,650)->save($large_image_path);
                    Image::make($image_tmp)->resize(450,450)->save($medium_image_path);
                    Image::make($image_tmp)->resize(225,225)->save($small_image_path);
                    $product->main_image = $imageName;
                }
            }

            // Upload Product Video 
            if($request->hasFile('product_video')){
                $video_tmp = $request->file('product_video');
                if($video_tmp->isValid()){
                    $video_name = $video_tmp->getClientOriginalName();
                    $extension = $video_tmp->getClientOriginalExtension();
                    $videoName = $video_name.'-'.rand(1,999999).'.'.$extension;
                    $video_path = 'videos/product_videos/';
                    $video_tmp->move($video_path,$videoName);
                    $product->product_video = $videoName;
                }
            }

            // Save New Products
            $categoryDetails = Category::find($data['category_id']);
            $product->section_id = $categoryDetails['section_id'];
            $product->category_id = $data['category_id'];
            $product->product_name = $data['product_name'];
            $product->brand_id = $data['brand_id'];
            $product->product_weight = $data['product_weight'];
            $product->product_code = $data['product_code'];
            $product->product_price = $data['product_price'];
            $product->product_discount = $data['product_discount'];
            $product->product_description = $data['product_description'];
            $product->meta_title = $data['meta_title'];
            $product->meta_description = $data['meta_description'];
            $product->meta_keywords = $data['meta_keywords'];
            if(!empty($data['is_featured'])){
                $product->is_featured = $data['is_featured'];
            }else{
                $product->is_featured = "No";
            }
            $product->save();
            session::flash('success_message',$message);
            return redirect('admin/products');
        }

        // Section with Categories
        $categories = Section::with('categories')->get();
        $categories = json_decode(json_encode($categories), true);

        // Get all Brands
        $brands = Brand::where('status', 1)->get();
        $brands = json_decode(json_encode($brands), true);


        return view('admin.products.add_edit_product')->with(compact('title', 'categories', 'productdata', 'brands'));
    }   

    public function deleteProductImage($id){
        // Get Product Image
        $productImage = Product::select('main_image')->where('id', $id)->first();

        // Get Product Image path
        $small_image_path = 'images/product_images/main_image/small/';
        $medium_image_path = 'images/product_images/main_image/medium/';
        $large_image_path = 'images/product_images/main_image/large/';

        // Delete small Product Image from product folder if exists
        if(file_exists($small_image_path.$productImage->main_image)){
           unlink($small_image_path.$productImage->main_image);
        }

         // Delete medium Product Image from product folder if exists
        if(file_exists($medium_image_path.$productImage->main_image)){
            unlink($medium_image_path.$productImage->main_image);
        }

         // Delete large Product Image from product folder if exists
         if(file_exists($large_image_path.$productImage->main_image)){
            unlink($large_image_path.$productImage->main_image);
        }

        // Delete Product Images from product table
        Product::where('id',$id)->update(['main_image'=>'']);

        $message = 'Hình ảnh đã được xóa thành công!';
        session::flash('success_message',$message);
        return redirect()->back();
    }

    public function deleteProductVideo($id){
        // Get product video
        $productVideo = Product::select('product_video')->where('id', $id)->first();

        // Get product video path
        $product_video_path = 'videos/product_videos/';

        // Delete product video from product video folder if exists
        if(file_exists($product_video_path.$productVideo->product_video)){
           unlink($product_video_path.$productVideo->product_video);
        }

        // Delete product video from product table
        Product::where('id',$id)->update(['product_video'=>'']);
        $message = 'Video đã được xóa thành công!';
        session::flash('success_message',$message);
        return redirect()->back();
    }

    public function addMaxproAttributes(Request $request,$id){
        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r( $data); die;
            foreach ($data['sku'] as $key => $value){
                if(!empty($value)){

                    // Unique SKU
                    $attrCountSKU = MaxproProductAttributes::where('sku',$value)->count();
                    if($attrCountSKU>0){
                        $message = 'Mã SKU đã tồn tại!';
                        session::flash('error_message',$message);
                        return redirect()->back();
                    }


                    $attribute = new MaxproProductAttributes;
                    $attribute-> product_id = $id;
                    $attribute-> sku = $value;
                    $attribute-> price = $data['price'][$key];
                    $attribute-> voltage = $data['voltage'][$key];
                    $attribute-> power = $data['power'][$key];
                    $attribute-> stock = $data['stock'][$key];
                    $attribute-> save();
                }
            }
            $success_message = 'Sản phẩm cấp (1) đã được thêm thành công!';
            session::flash('success_message',$success_message);
        }
        $productdata = Product::select('id', 'product_code', 'product_name', 'product_weight', 'main_image')->with('MaxproAttributes')->find($id);
        $productdata = json_decode(json_encode($productdata), true);
        // echo "<pre>"; print_r($productdata); die;
        $title = "Thêm Sản Phẩm Cấp (1)";
        return view('admin.products.add_maxpro_attributes')->with(compact('productdata', 'title'));
    }

    public function addHhoseAttributes(Request $request,$id){
        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r( $data); die;
            foreach ($data['sku'] as $key => $value){
                if(empty($data['hhose_spflex_embossed'])){
                    $data['hhose_spflex_embossed'][$key] = "";
                }
        
                if(empty($data['hhose_spflex_smoothtexture'])){
                    $data['hhose_spflex_smoothtexture'][$key] = "";
                }
                if(!empty($value)){

                    // Unique SKU
                    $attrCountSKU = HhoseProductAttributes::where('sku',$value)->count();
                    if($attrCountSKU>0){
                        $message = 'Mã SKU đã tồn tại!';
                        session::flash('error_message',$message);
                        return redirect()->back();
                    }

                    $attribute = new HhoseProductAttributes;
                    $attribute-> product_id = $id;
                    $attribute-> sku = $value;
                    $attribute-> price = $data['price'][$key];
                    $attribute-> diameter = $data['diameter'][$key];
                    $attribute-> hhose_spflex_embossed = $data['hhose_spflex_embossed'][$key];
                    $attribute-> hhose_spflex_smoothtexture = $data['hhose_spflex_smoothtexture'][$key];
                    $attribute-> stock = $data['stock'][$key];
                    $attribute-> save();
                }
            }
            $success_message = 'Sản phẩm cấp (1) đã được thêm thành công!';
            session::flash('success_message',$success_message);
        }

        $productdata = Product::select('id', 'product_code', 'product_name', 'product_weight', 'main_image')->with('HhoseAttributes')->find($id);
        $productdata = json_decode(json_encode($productdata), true);
        // echo "<pre>"; print_r($productdata); die;
        $title = "Thêm Sản Phẩm Cấp (1)";
        return view('admin.products.add_hhose_attributes')->with(compact('productdata', 'title'));
    }

    public function addShimgeAttributes(Request $request,$id){
        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r( $data); die;
            foreach ($data['sku'] as $key => $value){
                if(!empty($value)){

                    // Unique SKU
                    $attrCountSKU = ShimgeProductAttributes::where('sku',$value)->count();
                    if($attrCountSKU>0){
                        $message = 'Mã SKU đã tồn tại!';
                        session::flash('error_message',$message);
                        return redirect()->back();
                    }

                    $attribute = new ShimgeProductAttributes;
                    $attribute-> product_id = $id;
                    $attribute-> sku = $value;
                    $attribute-> price = $data['price'][$key];
                    $attribute-> vertical = $data['vertical'][$key];
                    $attribute-> maxflow = $data['maxflow'][$key];
                    $attribute-> indiameter = $data['indiameter'][$key];
                    $attribute-> outdiameter = $data['outdiameter'][$key];
                    $attribute-> power = $data['power'][$key];
                    $attribute-> voltage = $data['voltage'][$key];
                    $attribute-> stock = $data['stock'][$key];
                    $attribute-> save();
                }
            }
            $success_message = 'Sản phẩm cấp (1) đã được thêm thành công!';
            session::flash('success_message',$success_message);
        }
        $productdata = Product::select('id', 'product_code', 'product_name', 'product_weight', 'main_image')->with('ShimgeAttributes')->find($id);
        $productdata = json_decode(json_encode($productdata), true);
        // echo "<pre>"; print_r($productdata); die;
        $title = "Thêm Sản Phẩm Cấp (1)";
        return view('admin.products.add_shimge_attributes')->with(compact('productdata', 'title'));
    }

    public function editMaxproAttributes(Request $request,$id){
        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            foreach ($data['attrId'] as $key => $attr){
                if(!empty($attr)){
                    MaxproProductAttributes::where(['id'=>$data['attrId'][$key]])->update(['price'=>$data['price'][$key], 'stock'=>$data['stock'][$key]]);
                }
            }
            $message = 'Sản phẩm cấp (1) đã được cập nhật thành công!';
            session::flash('success_message',$message);
            return redirect()->back();
        }
    }

    public function editHhoseAttributes(Request $request,$id){
        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            foreach ($data['attrId'] as $key => $attr){
                if(!empty($attr)){
                    HhoseProductAttributes::where(['id'=>$data['attrId'][$key]])->update(['price'=>$data['price'][$key], 'stock'=>$data['stock'][$key]]);
                }
            }
            $message = 'Sản phẩm cấp (1) đã được cập nhật thành công!';
            session::flash('success_message',$message);
            return redirect()->back();
        }
    }

    public function editShimgeAttributes(Request $request,$id){
        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            foreach ($data['attrId'] as $key => $attr){
                if(!empty($attr)){
                    ShimgeProductAttributes::where(['id'=>$data['attrId'][$key]])->update(['price'=>$data['price'][$key], 'stock'=>$data['stock'][$key]]);
                }
            }
            $message = 'Sản phẩm cấp (1) đã được cập nhật thành công!';
            session::flash('success_message',$message);
            return redirect()->back();
        }
    }

    public function updateMaxproAttributesStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            if($data['status']=="đang hoạt động"){
                $status = 0;
            }else{
                $status = 1;
            }
            MaxproProductAttributes::where('id',$data['MaxproAttributes_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'MaxproAttributes_id'=>$data['MaxproAttributes_id']]);
        }
    }

    public function updateHhoseAttributesStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            if($data['status']=="đang hoạt động"){
                $status = 0;
            }else{
                $status = 1;
            }
            HhoseProductAttributes::where('id',$data['HhoseAttributes_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'HhoseAttributes_id'=>$data['HhoseAttributes_id']]);
        }
    }

    public function updateShimgeAttributesStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            if($data['status']=="đang hoạt động"){
                $status = 0;
            }else{
                $status = 1;
            }
            ShimgeProductAttributes::where('id',$data['ShimgeAttributes_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'ShimgeAttributes_id'=>$data['ShimgeAttributes_id']]);
        }
    }

    public function updateImageStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            if($data['status']=="đang hoạt động"){
                $status = 0;
            }else{
                $status = 1;
            }
            ProductsImage::where('id',$data['Image_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'Image_id'=>$data['Image_id']]);
        }
    }

    public function deleteMaxproAttributes($id){
        // delete product attribute 
        MaxproProductAttributes::where('id',$id)->delete();

        $message = 'Sản phẩm cấp (1) đã được xóa thành công!';
        session::flash('success_message',$message);
        return redirect()->back();
    }

    public function deleteHhoseAttributes($id){
        // delete product attribute 
        HhoseProductAttributes::where('id',$id)->delete();

        $message = 'Sản phẩm cấp (1) đã được xóa thành công!';
        session::flash('success_message',$message);
        return redirect()->back();
    }

    public function deleteShimgeAttributes($id){
        // delete product attribute 
        ShimgeProductAttributes::where('id',$id)->delete();

        $message = 'Sản phẩm cấp (1) đã được xóa thành công!';
        session::flash('success_message',$message);
        return redirect()->back();
    }

    public function deleteImage($id){
        // delete product attribute 
        $productImage = ProductsImage::select('image')->where('id',$id)->first();

        // Get Product Image path
        $small_image_path = 'images/product_images/main_image/small/';
        $medium_image_path = 'images/product_images/main_image/medium/';
        $large_image_path = 'images/product_images/main_image/large/';

        // Delete small Product Image from product folder if exists
        if(file_exists($small_image_path.$productImage->image)){
           unlink($small_image_path.$productImage->image);
        }

         // Delete medium Product Image from product folder if exists
        if(file_exists($medium_image_path.$productImage->image)){
            unlink($medium_image_path.$productImage->image);
        }

         // Delete large Product Image from product folder if exists
         if(file_exists($large_image_path.$productImage->image)){
            unlink($large_image_path.$productImage->image);
        }

        // Delete Product Images from product_images table
        ProductsImage::where('id',$id)->delete();

        $message = 'Hình ảnh sản phẩm cấp (1) đã được xóa thành công!';
        session::flash('success_message',$message);
        return redirect()->back();
    }

    public function addImages(Request $request, $id){
        if($request->isMethod('post')){
            if($request->hasFile('images')){
                $images = $request->file('images');
                // echo "<pre>"; print_r($images); die;
                foreach ($images as $key => $image) {
                    $productImage = new ProductsImage;
                    $image_tmp = Image::make($image);
                    $originalName = $image->getClientOriginalName();
                    $imageName =  rand(1,999999).'_'.$originalName;
                    $large_image_path = 'images/product_images/main_image/large/'.$imageName;
                    $medium_image_path = 'images/product_images/main_image/medium/'.$imageName;
                    $small_image_path = 'images/product_images/main_image/small/'.$imageName;
                    Image::make($image_tmp)->resize(750,650)->save($large_image_path);
                    Image::make($image_tmp)->resize(450,450)->save($medium_image_path);
                    Image::make($image_tmp)->resize(225,225)->save($small_image_path);
                    $productImage->image = $imageName;
                    $productImage->product_id = $id;
                    $productImage->save();
                }
                $message = 'Hình ảnh cấp (1) đã được thêm thành công!';
                session::flash('success_message',$message);
                return redirect()->back();
            }
        }
        $productdata = Product::with('images')->select('id', 'product_code', 'product_name', 'product_weight', 'main_image', 'section_id')->find($id);
        $productdata = json_decode(json_encode($productdata), true);
        // echo "<pre>"; print_r($productdata); die;
        $title = "Thêm Hình Ảnh Cấp (1)";
        return view('admin.products.add_images')->with(compact('productdata', 'title'));
    }
}


