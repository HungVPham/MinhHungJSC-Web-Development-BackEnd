<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\BlogCategory; 
use Session;

class BlogCategoriesController extends Controller
{
    public function blogCategories(){
        Session::put('page', 'blog_categories');
        $categories = BlogCategory::with(['parentcategory'])->get();
        // $categories = json_decode(json_encode($categories));
        // echo "<pre>"; print_r($categories);  die; 
        return view('admin.blog_categories.blog_categories')->with(compact('categories'));
    }

    public function updateBlogCategoryStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            if($data['status']=="đang hoạt động"){
                $status = 0;
            }else{
                $status = 1;
            }
            BlogCategory::where('id',$data['category_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'category_id'=>$data['category_id']]);
        }
    }

    public function addEditBlogCategory(Request $request, $id=null){
        if($id==""){
            // Add BlogCategory Functionality
            $title = "Thêm Thể Loại Tin Tức";
            $category = new BlogCategory;
            $categorydata = array();
            $getCategories = BlogCategory::with('subcategories')->where('parent_id',0)->get();
            $getCategories = json_decode(json_encode($getCategories),true);
            $message = "Thể loại tin tức đã được thêm thành công!";
        }else{
            // Edit BlogCategory Functionality
            $title = "Sửa Thể Loại Tin Tức";
            $categorydata = BlogCategory::where('id',$id)->first();
            $categorydata = json_decode(json_encode($categorydata),true);
            $getCategories = BlogCategory::with('subcategories')->where('parent_id',0)->get();
            $getCategories = json_decode(json_encode($getCategories),true);
            // echo "<pre>"; print_r($sectiondata); die;
            $category = BlogCategory::find($id);
            $message = "Thể loại tin tức đã được cập nhật thành công!";
        }

        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            // BlogCategory Validations
            $rules = [
                'category_name' => 'required',
                'url' => 'required'
            ];  
            $customMessages = [
                'category_name.required' => 'Vui lòng nhập tên thể loại.',
                'url.required' => 'Vui lòng nhập đường dẫn của thể loại.',
            ];
            $this->validate($request, $rules, $customMessages);

            if(empty($data['category_description'])){
                $data['category_description']="";
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
            $category->category_name = $data['category_name'];
            $category->category_description = $data['category_description'];
            $category->url = $data['url'];
            $category->meta_title = $data['meta_title'];
            $category->meta_keywords = $data['meta_keywords'];
            $category->meta_description = $data['meta_description'];
            // $category->status = 1;
            $category->save();
            
            session::flash('success_message',$message);
            return redirect('admin/blog-categories');
        }

        return view('admin.blog_categories.add_edit_blog_category')->with(compact('title', 'categorydata', 'getCategories'));
    }

    public function appendBlogCategoryLevel(Request $request){
        if($request->ajax()){
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            $getCategories = BlogCategory::with('subcategories')->where(['parent_id'=>0,'status'=>1])->get();
            $getCategories = json_decode(json_encode($getCategories),true);
            // echo "<pre>"; print_r($data); die;
            return view('admin.blog_categories.append_blog_categories_level')->with(compact('getCategories'));
        }
    }

    public function deleteBlogCategory($id){
        // delete Category 
        BlogCategory::where('id',$id)->delete();

        $message = 'Thể loại tin tức đã được xóa thành công!';
        session::flash('success_message',$message);
        return redirect()->back();
    }

}
