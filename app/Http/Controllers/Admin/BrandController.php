<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Brand;
use Session;

class BrandController extends Controller
{
    public function brands(){
        Session::put('page', 'brands');
        $brands = Brand::get();
        return view('admin.brands.brands')->with(compact('brands'));
    }

    public function updateBrandStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            if($data['status']=="đang hoạt động"){
                $status = 0;
            }else{
                $status = 1;
            }
            Brand::where('id',$data['brand_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'brand_id'=>$data['brand_id']]);
        }
    }

    public function addEditBrand(Request $request, $id=null){
        Session::put('page', 'brands');
        if($id==""){
            $title = "Thêm Thương hiệu SP";
            // Add Brand Functionality
            $brand = new Brand;
            $branddata = array(); 
            $message = "Thương hiệu SP đã được thêm thành công!";
        }else{
            // Edit Brand Functionality
            $title = "Sửa Thương hiệu SP";
            $branddata = Brand::where('id',$id)->first();
            $branddata = json_decode(json_encode($branddata),true);
            // echo "<pre>"; print_r($branddata); die;
            $brand = Brand::find($id);
            $message = "Thương hiệu SP đã được cập nhật thành công!";
        }

        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            // Brand Validations
            $rules = [
                'name' => 'required',
            ];  
            $customMessages = [
                'name.required' => 'Vui lòng nhập tên thương hiệu SP.',
            ];
            $this->validate($request, $rules, $customMessages);
            
            $brand->name = $data['name'];
            $brand->status = 1;
            $brand->save();

            session::flash('success_message',$message);
            return redirect('admin/brands');
        }


        return view('admin.brands.add_edit_brand')->with(compact('title','branddata'));
    }

    public function deleteBrand($id){
        // delete Brand 
        Brand::where('id',$id)->delete();

        $message = 'Thương hiệu SP đã được xóa thành công!';
        session::flash('success_message',$message);
        return redirect()->back();
    }
}
