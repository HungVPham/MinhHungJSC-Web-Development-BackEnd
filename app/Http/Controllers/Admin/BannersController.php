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
            $messageSub = 'Banner [phụ] đã được thêm thành công!';
            $messageMain = 'Banner [chính] đã được thêm, vui lòng kiểm tra thông điệp trong điều khiển [sửa]!';
        }else{
            // edit banner
            $banner = Banner::find($id);
            $title = "Sửa Banner";
            $messageMain = 'Banner [chính] đã được sửa thành công, kiểm tra thông điệp trong điều khiển [sửa]!';
            $messageSub = 'Banner [phụ] đã được sửa thành công!';
        }

        if($request->isMethod('post')){
            $data = $request->all();

            $banner->link = $data['link'];
            $banner->title = $data['title'];
            $banner->alt = $data['alt'];
            if(!empty($data['bRed_1'])){
                $banner->bRed_1 = $data['bRed_1'];
            }else{
                $banner->bRed_1 = NULL;
            }
            if(!empty($data['nBlack_1'])){
                $banner->nBlack_1 = $data['nBlack_1'];
            }else{
                $banner->nBlack_1 = NULL;
            }
            if(!empty($data['bRed_2'])){
                $banner->bRed_2 = $data['bRed_2'];
            }else{
                $banner->bRed_2 = NULL;
            }
            if(!empty($data['bRed_3'])){
                $banner->bRed_3 = $data['bRed_3'];
            }else{
                $banner->bRed_3 = NULL;
            }
            if(!empty($data['bRed_1'])){
                $banner->nBlack_2 = $data['nBlack_2'];
            }else{
                $banner->nBlack_2 = NULL;
            }
            if(!empty($data['bRed_4'])){
                $banner->bRed_4 = $data['bRed_4'];
            }else{
                $banner->bRed_4 = NULL;
            }
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
            if($banner->is_main == 'Yes'){
            Session::flash('success_message', $messageMain);
            }else{
            Session::flash('success_message', $messageSub);
            }
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

        $message = 'Banner đã được xóa thành công!';
        session::flash('success_message',$message);
        return redirect()->back();
    }
}
