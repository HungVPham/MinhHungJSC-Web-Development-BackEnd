<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Section;
use Session;
use Image;

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
            $sectiondata = array(); 
        }else{
            // Edit Section Functionality
            $title = "Sửa Danh Mục SP";
            $sectiondata = Section::where('id',$id)->first();
            $sectiondata = json_decode(json_encode($sectiondata),true);
            // echo "<pre>"; print_r($sectiondata); die;
        }

        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            // Section Validations
            $rules = [
                'name' => 'required',
                'url' => 'required',
                'section_image' => 'required'
            ];  
            $customMessages = [
                'name.required' => 'Vui lòng nhập tên danh mục SP.',
                'url.required' => 'Vui lòng nhập đường dẫn của danh mục SP.',
                'section_image.required' => 'Danh mục SP phải có hình ảnh đại diện.',
            ];
            $this->validate($request, $rules, $customMessages);

            //upload Section Image
            if($request->hasFile('section_image')){
                $image_tmp = $request->file('section_image');
                if($image_tmp->isValid()){
                    // Get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    // Generate New Image Name
                    $imageName = rand(111,99999).'.'.$extension;
                    $imagePath = 'images/section_images/'.$imageName;
                    // Upload the Image
                    Image::make($image_tmp)->resize(128, 128)->save($imagePath);
                    // save Category Image
                    $section->section_image = $imageName;
                }
            }

            if(empty($data['section_description'])){
                $data['section_description']="";
            }

            if(empty($data['section_discount'])){
                $data['section_discount']="";
            }

            if(empty($data['meta_title'])){
                $data['meta_title']="";
            }

            if(empty($data['meta_keywords'])){
                $data['meta_keywords']="";
            }

            if(empty($data['meta_description'])){
                $data['meta_description']="";
            }
            
            $section->name = $data['name'];
            $section->section_discount = $data['section_discount'];
            $section->section_description = $data['section_description'];
            $section->url = $data['url'];
            $section->meta_title = $data['meta_title'];
            $section->meta_keywords = $data['meta_keywords'];
            $section->meta_description = $data['meta_description'];
            $section->status = 1;
            $section->save();

            session::flash('success_message', 'Danh mục SP đã được thêm thành công!');
            return redirect('admin/sections');
        }


        return view('admin.sections.add_edit_section')->with(compact('title','sectiondata'));
    }
}
