<?php

namespace App\Http\Controllers\Front;

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
                $user->status = 1;
                $user->save();

                if(Auth::attempt(['email'=>$data['email'], 'password'=>$data['password']])){
                    // echo "<pre>"; print_r(Auth::user()); die;

                    if(!empty(Session::get('session_id'))){
                        $user_id = Auth::user()->id;
                        $session_id = Session::get('session_id');
                        Cart::where('session_id', $session_id)->update(['user_id'=>$user_id]);
                    }

                    return redirect('/');
                }
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

    public function loginUser(Request $request){
        if($request->isMethod('post')){

            $data = $request->all();

            if(is_numeric($data['id'])){
                if(Auth::attempt(['mobile' => $data['id'], 'password' => $data['password']])){
                    // echo "<pre>"; print_r(Auth::user()); die;

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

    public function logoutUser(){
        Auth::logout();
        return redirect('/tai-khoan');
    }
}
