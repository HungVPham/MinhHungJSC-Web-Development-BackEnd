<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\CmsPage;
use Session;

class CmsController extends Controller
{
    public function cmspages(){
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

        $message = 'Trang thông tin đã được xóa thành công!';
        session::flash('success_message',$message);
        return redirect()->back();
    }

    public function addEditCmsPage(Request $request, $id=null){
        Session::put('page', 'cmspages');
        if($id==""){
            $title = "Thêm Trang Thông Tin";
            $cmspage = new CmsPage;
            $message = "Trang thông tin đã được thêm thành công!";
        }else{
            $title = "Sửa Trang Thông Tin";
            $cmspage = CmsPage::find($id);
            $message = "Trang thông tin đã được sừa thành công!";
        }

        if($request->isMethod('post')){
            $data = $request->all();
            echo "<pre>"; print_r($data); die;
        }
        return view('admin.pages.add_edit_cms_page')->with(compact('title', 'cmspage'));
    }
}
