<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Banner;
use Session;
use Image;

class BannersController extends Controller
{
    public function banners(){
        Session::put('page', 'banners');
        $banners = Banner::get()->toArray();
        return view('admin.banners.banners')->with(compact('banners'));
    }

    public function addEditBanner(Request $request,$id=null){
        if($id==""){
            // add banner
            $banner = new Banner;
            $title = "Thêm Banner";
            $message = 'Banner đã được thêm thành công!';
        }else{
            // edit banner
            $banner = Banner::find($id);
            $title = "Sửa Banner";
            $message = 'Banner đã được sửa thành công!';

        }

        if($request->isMethod('post')){
            $data = $request->all();

            $banner->link = $data['link'];
            $banner->title = $data['title'];
            $banner->alt = $data['alt'];
            if(!empty($data['is_main'])){
                $banner->is_main = $data['is_main'];
            }else{
                $banner->is_main = "No";
            }
            
            // Upload Banner Images
            if($request->hasFile('image')){
                $image_tmp = $request->file('image');
                if($image_tmp->isValid()){
                    // get image original name
                    $image_name = $image_tmp->getClientOriginalName();
                    $imageName = rand(1,999999).'_'.$image_name;
                    $banner_image_path = 'images/banner_images/'.$imageName;
                    Image::make($image_tmp)->resize(1850,740)->save($banner_image_path);
                    $banner->image = $imageName;
                }
            }
            $banner->save();
            Session::flash('success_message', $message);
            return redirect('admin/banners');
        }
        return view('admin.banners.add_edit_banner')->with(compact('title', 'banner'));
    }

    public function updateBannerStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            if($data['status']=="đang hoạt động"){
                $status = 0;
            }else{
                $status = 1;
            }
            Banner::where('id',$data['banner_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'banner_id'=>$data['banner_id']]);
        }
    }

    public function deleteBanner($id){
        // get banner image 
        $bannerImage = Banner::where('id',$id)->first();

        // get banner image path
        $banner_image_path = 'images/banner_images/';


        // delete banner image from banner folder
        if(file_exists($banner_image_path.$bannerImage->image)){
            unlink($banner_image_path.$bannerImage->image);
        }
        
        // delete banner image from banner table
        Banner::where('id',$id)->delete();

        $message = 'Sản phẩm đã được xóa thành công!';
        session::flash('success_message',$message);
        return redirect()->back();
    }
}
