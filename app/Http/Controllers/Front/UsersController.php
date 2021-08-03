<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;
use Session;

class UsersController extends Controller
{
    public function loginRegister(){
        return view('front.users.login_register');
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
                    echo "<pre>"; print_r(Auth::user()); die;
                }
            }
        }
    }
}
