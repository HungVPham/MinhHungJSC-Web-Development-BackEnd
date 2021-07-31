<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\CmsPage;
use Session;
use Validator;

class CmsController extends Controller
{
    public function CmsPages(){
        Session::put('page', 'cmspages');
        $cms_pages = CmsPage::get();
        return view('admin.pages.cms_pages')->with(compact('cms_pages'));
    }

    public function updateCmsPageStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            if($data['status']=="đang hoạt động"){
                $status = 0;
            }else{
                $status = 1;
            }
            CmsPage::where('id',$data['page_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'page_id'=>$data['page_id']]);
        }
    }

    public function deleteCmsPage($id){
        // delete cms page
        CmsPage::where('id',$id)->delete();

        $message = 'Trang chính sách đã được xóa thành công!';
        session::flash('success_message',$message);
        return redirect()->back();
    }

    public function addEditCmsPage(Request $request, $id=null){
        Session::put('page', 'cmspages');
        if($id==""){
            $title = "Thêm Trang Chính Sách";
            $cmspage = new CmsPage;
            $message = "Trang chính sách đã được thêm thành công!";
        }else{
            $title = "Sửa Trang Chính Sách";
            $cmspage = CmsPage::find($id);
            $message = "Trang chính sách đã được sừa thành công!";
        }

        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            // Brand Validations
            $rules = [
                'title' => 'required',
                'description' => 'required',
                'url' => 'required',
            ];  
            $customMessages = [
                'title.required' => 'Vui lòng nhập tựa đề của trang chính sách.',
                'description.required' => 'Vui lòng cho miêu tả nội dung của trang chính sách.',
                'url.required' => 'Vui lòng nhập URL của trang chính sách.',
            ];
            $this->validate($request, $rules, $customMessages);

            $cmspage->title = $data['title'];
            $cmspage->url = $data['url'];
            $cmspage->description = $data['description'];
            $cmspage->meta_title = $data['meta_title'];
            $cmspage->meta_keywords = $data['meta_keywords'];
            $cmspage->meta_description = $data['meta_description'];
            $cmspage->status = 1;
            $cmspage->save();

            session::flash('success_message',$message);
            return redirect('admin/cms-pages');
        }

        return view('admin.pages.add_edit_cms_page')->with(compact('title', 'cmspage'));
    }
}
