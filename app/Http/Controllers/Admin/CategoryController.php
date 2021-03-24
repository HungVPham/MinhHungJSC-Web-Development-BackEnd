<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
Use App\Section;
use App\Category; 
use Session;


class CategoryController extends Controller
{
    public function categories(){
        Session::put('page', 'categories');
        $categories = Category::get();
        /* $categories = json_decode(json_encode($categories));
        echo "<pre>"; print_r($categories);  die; */
        return view('admin.categories.categories')->with(compact('categories'));
    }

    public function updateCategoryStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            if($data['status']=="đang hoạt động"){
                $status = 0;
            }else{
                $status = 1;
            }
            Category::where('id',$data['category_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'category_id'=>$data['category_id']]);
        }
    }

    public function addEditCategory(Request $request, $id=null){
        if($id==""){
            $title = "Thêm Thể Loại SP";
            // Add Category Functionality
            $category = new Category;
        }else{
            $title = "Sửa Thể Loại SP";
            // Edit Category Functionality
        }

        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            // Category Validations
            $rules = [
                'category_name' => 'required',
                'section_id' => 'required',
                'url' => 'required'
            ];  
            $customMessages = [
                'category_name.required' => 'Vui lòng nhập tên thể loại SP.',
                'section_id.required' => 'Vui lòng chọn danh mục của thể loại SP.',
                'url.required' => 'Vui lòng nhập đường dẫn của thể loại SP.',
            ];
            $this->validate($request, $rules, $customMessages);

            if(empty($data['category_description'])){
                $data['category_description']="";
            }

            if(empty($data['category_discount'])){
                $data['category_discount']="";
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

            $category->parent_id = $data['parent_id'];
            $category->section_id = $data['section_id'];
            $category->category_name = $data['category_name'];
            $category->category_discount = $data['category_discount'];
            $category->category_description = $data['category_description'];
            $category->url = $data['url'];
            $category->meta_title = $data['meta_title'];
            $category->meta_keywords = $data['meta_keywords'];
            $category->meta_description = $data['meta_description'];
            $category->status = 1;
            $category->save();
            
            session::flash('success_message', 'Thể loại SP đã được thêm thành công!');
            return redirect('admin/categories');
        }

        // Get All Sections 
        $getSections = Section::get();

        return view('admin.categories.add_edit_category')->with(compact('title', 'getSections'));
    }
}
