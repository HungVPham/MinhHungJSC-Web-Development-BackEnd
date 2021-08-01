<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\CataloguePage;
use Session;
use Validator;

class CatalogueController extends Controller
{
    public function CataloguePages(){
        Session::put('page', 'cataloguepages');
        $catalogue_pages = CataloguePage::get();
        return view('admin.pages.catalogue_pages')->with(compact('catalogue_pages'));
    }

    public function updateCataloguePageStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            if($data['status']=="đang hoạt động"){
                $status = 0;
            }else{
                $status = 1;
            }
            CataloguePage::where('id',$data['page_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'page_id'=>$data['page_id']]);
        }
    }

    public function deleteCataloguePage($id){
        // delete cms page
        CataloguePage::where('id',$id)->delete();

        $message = 'Booklet catalogue đã được xóa thành công!';
        session::flash('success_message',$message);
        return redirect()->back();
    }

    public function addEditCataloguePage(Request $request, $id=null){
        Session::put('page', 'cataloguepages');
        if($id==""){
            $title = "Thêm Booklet Catalogue";
            $cataloguepage = new CataloguePage;
            $message = "Booklet catalogue đã được thêm thành công!";
        }else{
            $title = "Sửa Booklet Catalogue";
            $cataloguepage = CataloguePage::find($id);
            $message = "Booklet catalogue đã được sừa thành công!";
        }

        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            // Brand Validations
            $rules = [
                'title' => 'required',
                'description' => 'required',
                'file_path' => 'required',
                'url' => 'required',
            ];  
            $customMessages = [
                'title.required' => 'Vui lòng nhập tựa đề của booklet catalogue.',
                'description.required' => 'Vui lòng cho miêu tả nội dung của booklet catalogue.',
                'file_path.required' => 'Vui lòng thêm file PDF cho booklet catalogue.',
                'url.required' => 'Vui lòng nhập URL của booklet catalogue.',
            ];
            $this->validate($request, $rules, $customMessages);

            $cataloguepage->title = $data['title'];
            $cataloguepage->url = $data['url'];
            $cataloguepage->description = $data['description'];
            $cataloguepage->meta_title = $data['meta_title'];
            $cataloguepage->meta_keywords = $data['meta_keywords'];
            $cataloguepage->meta_description = $data['meta_description'];
            $cataloguepage->status = 1;
            $cataloguepage->save();

            session::flash('success_message',$message);
            return redirect('admin/catalogue-pages');
        }

        return view('admin.pages.add_edit_catalogue_page')->with(compact('title', 'cataloguepage'));
    }
}
