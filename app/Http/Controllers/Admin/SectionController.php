<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Section;
use Session;

class SectionController extends Controller
{
    public function sections(){
        Session::put('page', 'sections');
        $sections = Section::get();
        return view('admin.sections.sections')->with(compact('sections'));
    }

    public function updateSectionStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            if($data['status']=="đang hoạt động"){
                $status = 0;
            }else{
                $status = 1;
            }
            Section::where('id',$data['section_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'section_id'=>$data['section_id']]);
        }
    }

    public function addEditSection(Request $request, $id=null){
        if($id==""){
            $title = "Thêm Danh Mục SP";
            // Add Section Functionality
            $section = new Section;
        }else{
            $title = "Sửa Danh Mục SP";
            // Edit Section Functionality
        }

        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            $section->name = $data['name'];
            $section->section_discount = $data['section_discount'];
            $section->section_description = $data['section_description'];
            $section->url = $data['url'];
            $section->meta_title = $data['meta_title'];
            $section->meta_keywords = $data['meta_keywords'];
            $section->meta_description = $data['meta_description'];
            $section->status = 1;
            $section->save();
        }

        return view('admin.sections.add_edit_section')->with(compact('title'));
    }
}
