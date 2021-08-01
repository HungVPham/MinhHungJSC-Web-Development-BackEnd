<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\AboutPage;
use Session;
use Image;
use Validator;

class AboutController extends Controller
{
    public function AboutPages(){
        Session::put('page', 'aboutpages');
        $about_pages = AboutPage::get();
        return view('admin.pages.about_pages')->with(compact('about_pages'));
    }

    public function updateAboutPageStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            if($data['status']=="đang hoạt động"){
                $status = 0;
            }else{
                $status = 1;
            }
            AboutPage::where('id',$data['page_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'page_id'=>$data['page_id']]);
        }
    }

    public function deleteInfographicImage($id){
        // Get infographic Image
        $infographicImage = AboutPage::select('info_banner')->where('id', $id)->first();

        // Get infographic Image path
        $infographic_image_path = 'images/infographic_images/';

        // Delete small infographic Image from infographic folder if exists
        if(file_exists($infographic_image_path.$infographicImage->info_banner)){
           unlink($infographic_image_path.$infographicImage->info_banner);
        }

        // Delete infographic Images from about pages table
        AboutPage::where('id',$id)->update(['info_banner'=>'']);

        $message = 'Infographic đã được xóa thành công!';
        session::flash('success_message',$message);
        return redirect()->back();
    }

    public function deleteAboutPage($id){
        // delete about page
        AboutPage::where('id',$id)->delete();

        $message = 'Trang giới thiệu đã được xóa thành công!';
        session::flash('success_message',$message);
        return redirect()->back();
    }

    public function addEditAboutPage(Request $request, $id=null){
        Session::put('page', 'aboutpages');
        if($id==""){
            $title = "Thêm Trang Giới Thiệu";
            $aboutpage = new AboutPage;
            $message = "Trang giới thiệu đã được thêm thành công!";
        }else{
            $title = "Sửa Trang Giới Thiệu";
            $aboutpage = AboutPage::find($id);
            $message = "Trang giới thiệu đã được sừa thành công!";
        }

        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            // Brand Validations
            $rules = [
                'title' => 'required',
                'url' => 'required',
            ];  
            $customMessages = [
                'title.required' => 'Vui lòng nhập tựa đề của trang giới thiệu.',
                'url.required' => 'Vui lòng nhập URL của trang giới thiệu.',
            ];
            $this->validate($request, $rules, $customMessages);

            // Upload Infographic Images
            if($request->hasFile('info_banner')){
                $image_tmp = $request->file('info_banner');
                if($image_tmp->isValid()){
                    // get image original name
                    $image_name = $image_tmp->getClientOriginalName();
                    $imageName = rand(1,999999).'_'.$image_name;
                    $infographic_image_path = 'images/infographic_images/'.$imageName;
                    Image::make($image_tmp)->save($infographic_image_path);
                    $aboutpage->info_banner = $imageName;
                }
            }

            $aboutpage->title = $data['title'];
            $aboutpage->url = $data['url'];
            $aboutpage->description = $data['description'];
            $aboutpage->meta_title = $data['meta_title'];
            $aboutpage->meta_keywords = $data['meta_keywords'];
            $aboutpage->meta_description = $data['meta_description'];
            $aboutpage->status = 1;
            $aboutpage->save();

            session::flash('success_message',$message);
            return redirect('admin/about-pages');
        }

        return view('admin.pages.add_edit_about_page')->with(compact('title', 'aboutpage'));
    }
}
