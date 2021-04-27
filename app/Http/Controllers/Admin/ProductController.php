<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use Session;
use App\Section;
use App\Category;
use Image;
use App\MaxproProductAttributes;
use App\HhoseProductAttributes;
use App\ShimgeProductAttributes;


class ProductController extends Controller
{
    public function products(){
        Session::put('page', 'products');
        $products = Product::with(['category'=>function($query){
            $query->select('id', 'category_name');
        }
        // ,'subcategory'=>function($query){
        //     $query->select('id', 'category_name');
        // }
        ,'section'=>function($query){
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
                // 'main_image' => 'required',
            ];  
            $customMessages = [
                'category_id.required' => 'Vui lòng chọn thể loại sản phẩm.',
                'product_name.required' => 'Vui lòng đặt tên cho sản phẩm.',
                //'main_image.required' => 'Vui lòng chọn hình ảnh đại diện cho SP.',
                'product_code.required' => 'Vui lòng đăt mã cho sản phẩm.',
                'product_code.regex' => 'Vui lòng đạt mã hợp lệ cho sản phẩm. Ví dụ: SGP01, MP01, SPF01,...',
            ];
            $this->validate($request, $rules, $customMessages);

            if(empty($data['is_featured'])){
                $is_featured = "No";
            }else{
                $is_featured = "Yes";
            }

            /* if(empty($data['hhose_spflex_embossed'])){
                $hhose_spflex_embossed = NULL;
            }else{
                $hhose_spflex_embossed = "Yes";
            }

            if(empty($data['hhose_spflex_smoothtexture'])){
                $hhose_spflex_smoothtexture = NULL;
            }else{
                $hhose_spflex_smoothtexture = "Yes";
            }

            if(empty($data['maxpro_power'])){
                $data['maxpro_power'] = NULL;
            }

            if(empty($data['maxpro_voltage'])){
                $data['maxpro_voltage'] = NULL;
            }

            if(empty($data['hhose_diameter'])){
                $data['hhose_diameter'] = NULL;
            }


            if(empty($data['shimge_power'])){
                $data['shimge_power'] = NULL;
            }

            if(empty($data['shimge_maxflow'])){
                $data['shimge_maxflow'] = NULL;
            } */

            // Upload Product Images
            if($request->hasFile('main_image')){
                $image_tmp = $request->file('main_image');
                if($image_tmp->isValid()){
                    // get image original name
                    $image_name = $image_tmp->getClientOriginalName();
                    $extension = $image_tmp->getClientOriginalExtension();
                    $imageName = $image_name.'-'.rand(1,999999).'.'.$extension;
                    $large_image_path = 'images/product_images/main_image/large/'.$imageName;
                    $medium_image_path = 'images/product_images/main_image/medium/'.$imageName;
                    $small_image_path = 'images/product_images/main_image/small/'.$imageName;
                    Image::make($image_tmp)->resize(750,650)->save($large_image_path);
                    Image::make($image_tmp)->resize(450,450)->save($medium_image_path);
                    Image::make($image_tmp)->resize(225,225)->save($small_image_path);
                    $product->main_image = $imageName;
                }
            }

            /*if($request->hasFile('image_v1')){
                $image_tmp = $request->file('image_v1');
                if($image_tmp->isValid()){
                    //upload images after resize
                    $image_name = $image_tmp->getClientOriginalName();
                    // get image original extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    // image file naming convention (original name - random # from 1 to 999999)
                    $imageName = $image_name.'-'.rand(1,999999).'.'.$extension;
                    // define image saving paths
                    $large_image_path = 'images/product_images/image_v1/large/'.$imageName;
                    $medium_image_path = 'images/product_images/image_v1/medium/'.$imageName;
                    $small_image_path = 'images/product_images/image_v1/small/'.$imageName;
                    // save image in assigned folder after resizing. 
                    Image::make($image_tmp)->resize(750,650)->save($large_image_path);
                    Image::make($image_tmp)->resize(450,450)->save($medium_image_path);
                    Image::make($image_tmp)->resize(225,225)->save($small_image_path);
                    //upload images after resize
                    $product->image_v1 = $imageName;
                }
            }

            if($request->hasFile('image_v2')){
                $image_tmp = $request->file('image_v2');
                if($image_tmp->isValid()){
                    $image_name = $image_tmp->getClientOriginalName();
                    $extension = $image_tmp->getClientOriginalExtension();
                    $imageName = $image_name.'-'.rand(1,999999).'.'.$extension;
                    $large_image_path = 'images/product_images/image_v2/large/'.$imageName;
                    $medium_image_path = 'images/product_images/image_v2/medium/'.$imageName;
                    $small_image_path = 'images/product_images/image_v2/small/'.$imageName;
                    Image::make($image_tmp)->resize(750,650)->save($large_image_path);
                    Image::make($image_tmp)->resize(450,450)->save($medium_image_path);
                    Image::make($image_tmp)->resize(225,225)->save($small_image_path);
                    $product->image_v2 = $imageName;
                }
            }

            if($request->hasFile('image_v3')){
                $image_tmp = $request->file('image_v3');
                if($image_tmp->isValid()){
                    $image_name = $image_tmp->getClientOriginalName();
                    $extension = $image_tmp->getClientOriginalExtension();
                    $imageName = $image_name.'-'.rand(1,999999).'.'.$extension;
                    $large_image_path = 'images/product_images/image_v3/large/'.$imageName;
                    $medium_image_path = 'images/product_images/image_v3/medium/'.$imageName;
                    $small_image_path = 'images/product_images/image_v3/small/'.$imageName;
                    Image::make($image_tmp)->resize(750,650)->save($large_image_path);
                    Image::make($image_tmp)->resize(450,450)->save($medium_image_path);
                    Image::make($image_tmp)->resize(225,225)->save($small_image_path);
                    $product->image_v3 = $imageName;
                }
            }*/

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
            $product->product_weight = $data['product_weight'];
            $product->product_code = $data['product_code'];
            $product->product_price = $data['product_price'];
            $product->product_discount = $data['product_discount'];
            $product->product_description = $data['product_description'];
            // $product->maxpro_voltage = $data['maxpro_voltage'];
            // $product->maxpro_power = $data['maxpro_power'];
            // $product->hhose_diameter = $data['hhose_diameter'];
            // $product->hhose_spflex_embossed = $hhose_spflex_embossed;
            // $product->hhose_spflex_smoothtexture = $hhose_spflex_smoothtexture;
            // $product->shimge_power = $data['shimge_power'];
            // $product->shimge_maxflow = $data['shimge_maxflow'];
            $product->meta_title = $data['meta_title'];
            $product->meta_description = $data['meta_description'];
            $product->meta_keywords = $data['meta_keywords'];
            $product->category_id = $data['category_id'];
            $product->is_featured = $is_featured;
            $product->save();
            session::flash('success_message',$message);
            return redirect('admin/products');
        }

        // Filter Arrays
        // $maxpro_voltageArray = array('≤12V', '18V', '14.4V', '220-240V', '220-230V');
        // $maxpro_powerArray = array('80W', '230W','240W', '250W', '300W', '320W', '350W', '400W', '450W', '500W', '550W', '600W', '620W', '680W', '710W', '750W', '760W', '800W', '850W', '900W', '950W', '1050W', '1100W', '1200W', '1250W', '1300W', '1350W', '1400W', '1500W', '1600W', '1800W', '2000W', '2100W', '2200W', '2400W', '2600W');
        // $hhose_diameterArray = array('1/4 in.', '5/16 in.', '3/8 in.', '1/2 in.', '5/8 in.', '3/4 in.', '1 in.', '1-1/4 in.', '1-1/4 in.', '1-1/2 in.', '2 in.');
        // $shimge_powerArray = array('125W', '250W', '370W', '550W', '750W', '1100W', '1500W', '2200W', '3000W', '4000W', '5500W', '7500W');
        // $shimge_maxflowArray = array('1.9 m³/h', '2.0 m³/h', '2.2 m³/h', '2.4 m³/h', '3.0 m³/h', '3.4 m³/h', '3.6 m³/h', '4.2 m³/h', '4.5 m³/h', '5.1 m³/h', '5.4 m³/h', '7.2 m³/h', '7.8 m³/h',  '21 m³/h', '30 m³/h', '36 m³/h', '39 m³/h', '66 m³/h', '72 m³/h', '78 m³/h');

        // Section with Categories and Subcategories
        $categories = Section::with('categories')->get();
        $categories = json_decode(json_encode($categories), true);


        return view('admin.products.add_edit_product')->with(compact('title', 'categories', 'productdata'));
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

    /*public function deleteProductImage1($id){
        $productImage = Product::select('image_v1')->where('id', $id)->first();
        $small_image_path = 'images/product_images/image_v1/small/';
        $medium_image_path = 'images/product_images/image_v1/medium/';
        $large_image_path = 'images/product_images/image_v1/large/';
        if(file_exists($small_image_path.$productImage->image_v1)){
           unlink($small_image_path.$productImage->image_v1);
        }
        if(file_exists($medium_image_path.$productImage->image_v1)){
        unlink($medium_image_path.$productImage->image_v1);
        }
        if(file_exists($large_image_path.$productImage->image_v1)){
        unlink($large_image_path.$productImage->image_v1);
        }
        Product::where('id',$id)->update(['image_v1'=>'']);
        $message = 'Hình ảnh đã được xóa thành công!';
        session::flash('success_message',$message);
        return redirect()->back();
    }

    public function deleteProductImage2($id){
        $productImage = Product::select('image_v2')->where('id', $id)->first();
        $small_image_path = 'images/product_images/image_v2/small/';
        $medium_image_path = 'images/product_images/image_v2/medium/';
        $large_image_path = 'images/product_images/image_v2/large/';
        if(file_exists($small_image_path.$productImage->image_v2)){
           unlink($small_image_path.$productImage->image_v2);
        }
        if(file_exists($medium_image_path.$productImage->image_v2)){
        unlink($medium_image_path.$productImage->image_v2);
        }
        if(file_exists($large_image_path.$productImage->image_v2)){
        unlink($large_image_path.$productImage->image_v2);
        }
        Product::where('id',$id)->update(['image_v2'=>'']);
        $message = 'Hình ảnh đã được xóa thành công!';
        session::flash('success_message',$message);
        return redirect()->back();
    }

    public function deleteProductImage3($id){
        $productImage = Product::select('image_v3')->where('id', $id)->first();
        $small_image_path = 'images/product_images/image_v3/small/';
        $medium_image_path = 'images/product_images/image_v3/medium/';
        $large_image_path = 'images/product_images/image_v3/large/';
        if(file_exists($small_image_path.$productImage->image_v3)){
           unlink($small_image_path.$productImage->image_v3);
        }
        if(file_exists($medium_image_path.$productImage->image_v3)){
        unlink($medium_image_path.$productImage->image_v3);
        }
        if(file_exists($large_image_path.$productImage->image_v3)){
        unlink($large_image_path.$productImage->image_v3);
        }
        Product::where('id',$id)->update(['image_v3'=>'']);
        $message = 'Hình ảnh đã được xóa thành công!';
        session::flash('success_message',$message);
        return redirect()->back();
    }*/

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
                    $data['hhose_spflex_embossed'][$key] = "No";
                }
        
                if(empty($data['hhose_spflex_smoothtexture'])){
                    $data['hhose_spflex_smoothtexture'][$key] = "No";
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
                    $attribute-> indiameter = $data['outdiameter'][$key];
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
}


