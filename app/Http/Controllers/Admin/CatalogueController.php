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

    public function deleteCatalogueFile($id){
        // Get product video
        $catalogueFile = CataloguePage::select('file_path')->where('id', $id)->first();

        // Get product video path
        $file_path = 'files/catalogues/';

        // Delete product video from product video folder if exists
        if(file_exists($file_path.$catalogueFile->file_path)){
           unlink($file_path.$catalogueFile->file_path);
        }

        // Delete product video from product table
        CataloguePage::where('id',$id)->update(['file_path'=>'']);
        $message = 'Video đã được xóa thành công!';
        session::flash('success_message',$message);
        return redirect()->back();
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

            // Catalogue Validations
            $rules = [
                'title' => 'required',
                'url' => 'required',
            ];  
            $customMessages = [
                'title.required' => 'Vui lòng nhập tựa đề của booklet catalogue.',
                'url.required' => 'Vui lòng nhập URL của booklet catalogue.',
            ];
            $this->validate($request, $rules, $customMessages);

            // Upload Product Video 
            if($request->hasFile('file_path')){
                $file_tmp = $request->file('file_path');
                if($file_tmp->isValid()){
                    $file_name = $file_tmp->getClientOriginalName();
                    $fileName = rand(1,999999).'_'.$file_name;
                    $file_path = 'files/catalogues/';
                    $file_tmp->move($file_path,$fileName);
                    $cataloguepage->file_path = $fileName;
                }
            }
 

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
