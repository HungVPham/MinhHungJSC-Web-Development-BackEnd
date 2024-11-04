<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Blog;
use App\BlogsImage;
// use Image;
// use Session;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;
use App\BlogCategory;

class BlogController extends Controller
{
    public function blogs(){
        Session::put('page', 'blogs');
        $blogs = Blog::with(['category'=>function($query){
            $query->select('id', 'category_name');
        }])->get();
        $blogs = json_decode(json_encode($blogs));
        return view('admin.blogs.blogs')->with(compact('blogs'));
    }

    public function updateBlogStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            if($data['status']=="đang hoạt động"){
                $status = 0;
            }else{
                $status = 1;
            }
            Blog::where('id',$data['blog_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'blog_id'=>$data['blog_id']]);
        }
    }

    public function deleteBlog($id){
        // Delete Blog 
        Blog::where('id',$id)->delete();

        $message = 'Bài viết đã được xóa thành công!';
        session::flash('success_message',$message);
        return redirect()->back();
    }

    public function addEditBlog(Request $request,$id=null){
        if($id==""){
            $title = "Thêm Bài Viết";
            $blog = new Blog;
            $blogData = array();
            $message = "Bài viết đã được thêm thành công!";
        }else{
            $title = "Sửa Bài Viết";
            $blogData = Blog::find($id);
            $blogData = json_decode(json_encode($blogData),true);
            // echo "<pre>"; print_r($blogData); die;
            $blog = Blog::find($id);
            $message = "Bài viết đã được cập nhật thành công!";
        }

        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

             // Blog Validations
            $rules = [
                'title' => 'required',
                'category_id' => 'required',
                'author' => 'required',
                // 'main_image' => 'required',
            ];  
            $customMessages = [
                'title.required' => 'Vui lòng điền tiêu đề bài viết.',
                'category_id.required' => 'Vui lòng chọn thể loại tin tức.',
                'author.required' => 'Vui lòng điền tên tác giả.',
                //'main_image.required' => 'Vui lòng chọn hình ảnh đại diện SP.',
            ];
            $this->validate($request, $rules, $customMessages);

            // if(empty($data['is_featured'])){
            //     $is_featured = "No";
            // }else{
            //     $is_featured = "Yes";
            // }

            // Upload Blog Images
            if($request->hasFile('main_image')){
                $image_tmp = $request->file('main_image');
                if($image_tmp->isValid()){
                    // get image original name
                    $image_name = $image_tmp->getClientOriginalName();
                    $imageName = rand(1,999999).'_'.$image_name;
                    $large_image_path = 'images/blogs_images/main_image/large/'.$imageName;
                    $medium_image_path = 'images/blogs_images/main_image/medium/'.$imageName;
                    $small_image_path = 'images/blogs_images/main_image/small/'.$imageName;
                    Image::make($image_tmp)->resize(1280,720)->save($large_image_path);
                    Image::make($image_tmp)->resize(640,360)->save($medium_image_path);
                    Image::make($image_tmp)->resize(320,180)->save($small_image_path);
                    $blog->main_image = $imageName;
                }
            }

            // Upload Blog Video 
            // if($request->hasFile('product_video')){
            //     $video_tmp = $request->file('product_video');
            //     if($video_tmp->isValid()){
            //         $video_name = $video_tmp->getClientOriginalName();
            //         $extension = $video_tmp->getClientOriginalExtension();
            //         $videoName = $video_name.'-'.rand(1,999999).'.'.$extension;
            //         $video_path = 'videos/product_videos/';
            //         $video_tmp->move($video_path,$videoName);
            //         $blog->product_video = $videoName;
            //     }
            // }

            // Save New Products
            $blog->title = $data['title'];
            $blog->category_id = $data['category_id'];
            $blog->content = $data['content'];
            // $blog->parentCategory_id = $data['parentCategory_id'];
            // $blog->product_video = $data['product_video'];
            $blog->author = $data['author'];
            $blog->posted_on = $data['posted_on'];
            $blog->meta_title = $data['meta_title'];
            $blog->meta_description = $data['meta_description'];
            $blog->meta_keywords = $data['meta_keywords'];
            $blog->save();
            session::flash('success_message',$message);
            return redirect('admin/blogs');
        }
        
        // echo "<pre>"; print_r($categories); die;

        // Get all blog categories
        $categories = BlogCategory::with('subcategories')->where('status', 1)->get();
        $categories = json_decode(json_encode($categories), true);


        return view('admin.blogs.add_edit_blog')->with(compact('title', 'categories', 'blogData'));
    }   

    public function updateImageStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            if($data['status']=="đang hoạt động"){
                $status = 0;
            }else{
                $status = 1;
            }
            BlogsImage::where('id',$data['Image_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'Image_id'=>$data['Image_id']]);
        }
    }

    public function deleteImage($id){
        // delete product attribute 
        $blogImage = BlogsImage::select('image')->where('id',$id)->first();

        // Get Product Image path
        $small_image_path = 'images/blogs_images/main_image/small/';
        $medium_image_path = 'images/blogs_images/main_image/medium/';
        $large_image_path = 'images/blogs_images/main_image/large/';

        // Delete small Product Image from product folder if exists
        if(file_exists($small_image_path.$blogImage->image)){
           unlink($small_image_path.$blogImage->image);
        }

         // Delete medium Product Image from product folder if exists
        if(file_exists($medium_image_path.$blogImage->image)){
            unlink($medium_image_path.$blogImage->image);
        }

         // Delete large Product Image from product folder if exists
         if(file_exists($large_image_path.$blogImage->image)){
            unlink($large_image_path.$blogImage->image);
        }

        // Delete Product Images from product_images table
        BlogsImage::where('id',$id)->delete();

        $message = 'Hình ảnh sản phẩm cấp (1) đã được xóa thành công!';
        session::flash('success_message',$message);
        return redirect()->back();
    }

    public function deleteBlogImage($id){
        // Get Blog Image
        $blogImage = Blog::select('main_image')->where('id', $id)->first();

        // Get Blog Image path
        $small_image_path = 'images/blogs_images/main_image/small/';
        $medium_image_path = 'images/blogs_images/main_image/medium/';
        $large_image_path = 'images/blogs_images/main_image/large/';

        // Delete small Blog Image from blog folder if exists
        if(file_exists($small_image_path.$blogImage->main_image)){
           unlink($small_image_path.$blogImage->main_image);
        }

         // Delete medium Blog Image from blog folder if exists
        if(file_exists($medium_image_path.$blogImage->main_image)){
            unlink($medium_image_path.$blogImage->main_image);
        }

         // Delete large Blog Image from blog folder if exists
         if(file_exists($large_image_path.$blogImage->main_image)){
            unlink($large_image_path.$blogImage->main_image);
        }

        // Delete Blog Images from blog table
        Blog::where('id',$id)->update(['main_image'=>'']);

        $message = 'Hình ảnh đã được xóa thành công!';
        session::flash('success_message',$message);
        return redirect()->back();
    }

    public function addImages(Request $request, $id){
        if($request->isMethod('post')){
            if($request->hasFile('images')){
                $images = $request->file('images');
                // echo "<pre>"; print_r($images); die;
                foreach ($images as $key => $image) {
                    $blogImage = new BlogsImage;
                    $image_tmp = Image::make($image);
                    $originalName = $image->getClientOriginalName();
                    $imageName =  rand(1,999999).'_'.$originalName;
                    $large_image_path = 'images/blogs_images/main_image/large/'.$imageName;
                    $medium_image_path = 'images/blogs_images/main_image/medium/'.$imageName;
                    $small_image_path = 'images/blogs_images/main_image/small/'.$imageName;
                    Image::make($image_tmp)->resize(1280,720)->save($large_image_path);
                    Image::make($image_tmp)->resize(640,360)->save($medium_image_path);
                    Image::make($image_tmp)->resize(320,180)->save($small_image_path);
                    $blogImage->image = $imageName;
                    $blogImage->blog_id = $id;
                    $blogImage->save();
                }
                $message = 'Hình ảnh cấp (1) đã được thêm thành công!';
                session::flash('success_message',$message);
                return redirect()->back();
            }
        }
        $blogdata = Blog::with('images')->select('id', 'author', 'title', 'category_id', 'main_image', 'posted_on')->find($id);
        $blogdata = json_decode(json_encode($blogdata), true);
        // echo "<pre>"; print_r($blogdata); die;
        $title = "Thêm Hình Ảnh Cấp (1)";
        return view('admin.blogs.add_images')->with(compact('blogdata', 'title'));
    }



}
