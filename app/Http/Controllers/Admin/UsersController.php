<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Mail;
// use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Cart;
use App\Country;
use App\Province;
use App\District;
use App\Ward;
use Session;


class UsersController extends Controller
{
   public function users(){
    Session::put('page', 'users');
    $users = user::get()->toArray();
    // dd($users); die;
    return view('admin.users.users')->with(compact('users'));
   }

   public function updateUserStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            if($data['status']=="đang hoạt động"){
                $status = 0;
            }else{
                $status = 1;
            }
            User::where('id',$data['user_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'user_id'=>$data['user_id']]);
        }
    }

    public function deleteUser($id){
        // Delete Product 
        User::where('id',$id)->delete();

        $message = 'Tài khoản khách hàng đã được xóa thành công!';
        session::flash('success_message',$message);
        return redirect()->back();
    }
}
