<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Cart;
use Session;

class UsersController extends Controller
{
    public function loginRegister(){
        if(Auth::check()){
            abort(404);
        }else{
            return view('front.users.login_register');
        }
    }   

    public function registerUser(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            // check if user already exists
            $userEmailCount = User::where('email', $data['email'])->count();
            $userMobileCount = User::where('mobile', $data['mobile'])->count();
            if($userEmailCount>0 or $userMobileCount>0){
                $message = "Email hoặc số điện thoại đã được đăng ký!";
                session::flash('error_message', $message);
                return redirect()->back();
            }else{
                // register the user 
                $user = new User;
                $user->name = $data['name'];
                $user->last_name = $data['last_name'];
                $user->email = $data['email'];
                $user->mobile = $data['mobile'];
                $user->password = bcrypt($data['password']);
                $user->status = 0;
                $user->save();

                // send confirmation email to user
                $email = $data['email'];
                $messageData = [
                    'name'=>$data['name'],  
                    'code'=>base64_encode($data['email'])
                ];

                Mail::send('emails.confirmation', $messageData, function($message) use($email){
                    $message->to($email)->subject('Kích hoạt tài khoản Minh Hưng JSC của Quý Khách.');
                });

                // Redirect back with success message

                $message = "Vui lòng kiểm tra email của bạn để kích hoạt tài khoản.";
                session::flash('success_message', $message);
                return redirect()->back();
            }
        }
    }

    public function checkEmail(Request $request){
        // check if email already exists
        $data = $request->all();
        $emailCount = User::where('email', $data['email'])->count();
        if($emailCount > 0){
            return "false";
        }else{
            return "true";
        }
    }

    public function checkMobile(Request $request){
        // check if mobile already exists
        $data = $request->all();
        $mobileCount = User::where('mobile',$data['mobile'])->count();
        if($mobileCount > 0){
            return "false";
        }else{
            return "true";
        }
    }

    public function confirmUser($email){
        // decode user email
        $email = base64_decode($email);

        //check user email exists
        $userCount = User::where('email', $email)->count();
        if($userCount>0){
            // user status is already active
            $userDetails = User::where('email', $email)->first();
            if($userDetails->status == 1){
                $message = "Tài khoản đã được kích hoạt. Vui lòng đăng nhập.";
                session::flash('pending_message', $message);
                return redirect('tai-khoan');
            }else{
                // update user status to 1 to activate account
                User::where('email', $email)->update(['status'=>1]);
                
                // send register email 
                $messageData = ['name'=>$userDetails['name'], 'last_name'=>$userDetails['last_name'],  'mobile'=>$userDetails['mobile'], 'email'=>$userDetails['email']];

                Mail::send('emails.register', $messageData, function($message) use($email){
                    $message->to($email)->subject('Chào Mừng Quý Khách Từ MinhHưngJSC.');
                });

                // Redirect to login/register page with success message.
                $message = "Tài khoản đã được kích hoạt thành công.";
                session::flash('success_message', $message);
                return redirect('tai-khoan');
            }
        }else{
            abort(404);
        }
    }

    public function loginUser(Request $request){
        if($request->isMethod('post')){

            $data = $request->all();

            if(is_numeric($data['id'])){
                if(Auth::attempt(['mobile' => $data['id'], 'password' => $data['password']])){
                    // echo "<pre>"; print_r(Auth::user()); die;
                       
                    // check if email is activated or not
                    $userStatus = User::where('mobile', $data['id'])->first();
                    if($userStatus->status == 0){
                        Auth::logout();
                        $message = "Tài khoản của quý khách chưa được kích hoạt.";
                        session::flash('pending_message', $message);
                        return redirect()->back();
                    }
                      
                    // update user cart with user id
                    if(!empty(Session::get('session_id'))){
                        $user_id = Auth::user()->id;
                        $session_id = Session::get('session_id');
                        Cart::where('session_id', $session_id)->update(['user_id'=>$user_id]);
                    }

                    return redirect('/');
                }else{
                    $message = "Số điện thoại hoặc mật khẩu sai";
                    session::flash('error_message', $message);
                    return redirect()->back();
                }
            }else{
                if(Auth::attempt(['email' => $data['id'], 'password' => $data['password']])){
                    // echo "<pre>"; print_r(Auth::user()); die;

                     // check if email is activated or not
                     $userStatus = User::where('email', $data['id'])->first();
                     if($userStatus->status == 0){
                         Auth::logout();
                         $message = "Tài khoản của quý khách chưa được kích hoạt.";
                         session::flash('pending_message', $message);
                         return redirect()->back();
                     }

                    if(!empty(Session::get('session_id'))){
                        $user_id = Auth::user()->id;
                        $session_id = Session::get('session_id');
                        Cart::where('session_id', $session_id)->update(['user_id'=>$user_id]);
                    }

                    return redirect('/');
                }else{
                    $message = "Email hoặc mật khẩu sai";
                    session::flash('error_message', $message);
                    return redirect()->back();
                }
            }
        }
    }

    public function forgotPwd(){
        return view('front.users.forgot_pwd');
    }

    public function logoutUser(){
        Auth::logout();
        return redirect('/tai-khoan');
    }
}
