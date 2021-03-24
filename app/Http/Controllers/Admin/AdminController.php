<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Auth;
use App\Admin; 
Use Hash;
Use Image;

class AdminController extends Controller
{
    public function dashboard(){
        Session::put('page', 'dashboard');
        return view('admin.admin_dashboard');
    }

    public function settings(){
        Session::put('page', 'settings');
        $adminDetails = Admin::where('email',Auth::guard('admin')->user()->email)->first();
        return view('admin.admin_settings')->with(compact('adminDetails'));
    }

    public function login(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            // echo "<pre>"; print_r(Auth::guard('admin')->user()); die;
            $validatedData = $request->validate([
                'email' => 'required|email|max:255',
                'password' => 'required',
            ],
            [
                'email.required'=> 'Xin vui lòng nhập Email.', // custom message
                'password.required'=> 'Xin vui lòng nhập Mật Khẩu.', // custom message
                'email'=>'Địa chỉ Email không hợp lệ.', // custom message
                'email.max'=>'Địa chỉ Email không được quá 255 kí tự.' // custom message
            ]
            );    

            if(Auth::guard('admin')->attempt(['email'=>$data['email'], 'password'=>$data['password']])){
                return redirect('admin/dashboard');
            }else{
                Session::flash('error_message', 'Sai Email hoặc Mật Khẩu.');
                return redirect()->back();
            }
        }
        return view('admin.admin_login');
    }

    public function logout(){
        Auth::guard('admin')->logout();
        return redirect('/admin');
    }

    public function checkCurrentPassword(Request $request){
        $data = $request->all();
        // echo "<pre>"; print_r($data); 
        if(Hash::check($data['current_pwd'],Auth::guard('admin')->user()->password)){
            echo "true";
        }else{
            echo "false";
        }
    }

    public function updateCurrentPassword(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            // Check if current password is correct
            if(Hash::check($data['current_pwd'],Auth::guard('admin')->user()->password)){
                // Check if new and confirm password is matching
                if($data['new_pwd']==$data['confirm_pwd']){
                    Admin::where('id', Auth::guard('admin')->user()->id)->update(['password'=>bcrypt($data['new_pwd'])]);
                    Session::flash('success_message', 'Mât khẩu đã được cập nhật thành công!');
                    
                }else{
                    Session::flash('error_message', 'Mật khẩu xác nhận không đúng.');
                }
            }else{
                Session::flash('error_message','Mật khẩu hiện tại sai.');
            }
            return redirect()->back();
        }
    }

    public function updateAdminDetails(Request $request){
        Session::put('page', 'update-admin-details');
        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            $rules = [
                'admin_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'admin_mobile' => 'required|numeric|regex:/(0)[0-9]{9}/',
                'admin_image' => 'image'
            ];  
            $customMessages = [
                'admin_name.required' => 'Vui lòng nhập tên.',
                'admin_name.regex' => 'Tên không hợp lệ.',
                'admin_mobile.required' => 'Vui lòng nhập số điện thoại.',
                'admin_mobile.numeric' => 'Số điện thoại không hợp lệ.',
                'admin_mobile.regex' => 'Số điện thoại phải có 10 hoặc 11 chữ số.',
                'admin_image.image' => 'Hình ảnh đại diện không hợp lệ.',
            ];
            $this->validate($request, $rules, $customMessages);

            //upload image
            if($request->hasFile('admin_image')){
                $image_tmp = $request->file('admin_image');
                if($image_tmp->isValid()){
                    // Get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    // Generate New Image Name
                    $imageName = rand(111,99999).'.'.$extension;
                    $imagePath = 'images/admin_images/admin_photos/'.$imageName;
                    // Upload the Image
                    Image::make($image_tmp)->resize(128, 128)->save($imagePath);
                }
            }else if(!empty($data['current_admin_image'])){
                $imageName = $data['current_admin_image'];
            }else{
                $imageName = "";
            }

            // update admin details
            Admin::where('email',Auth::guard('admin')->user()->email)
            ->update(['name'=>$data['admin_name'], 'mobile'=>$data['admin_mobile'], 'image'=>$imageName]);
            session::flash('success_message', 'Thông tin đã cập nhật thành công.');
            return redirect()->back();
        }
        return view('admin.update_admin_details');
    }
}