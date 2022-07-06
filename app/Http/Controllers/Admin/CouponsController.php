<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Coupon;
use App\User;
use App\Section;
use Session;

class CouponsController extends Controller
{
    public function coupons(){
        Session::put('page', 'coupons');
        $coupons = Coupon::get()->toArray();
        return view('admin.coupons.coupons')->with(compact('coupons'));
    }

    public function updateCouponStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            if($data['status']=="đang hoạt động"){
                $status = 0;
            }else{
                $status = 1;
            }
            Coupon::where('id',$data['coupon_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'coupon_id'=>$data['coupon_id']]);
        }
    }

    public function addEditCoupon(Request $request, $id=null){
        Session::put('page', 'coupons');
        if($id==""){
            $title = "Thêm Coupon Khuyến Mãi";
            // Add Coupon Functionality
            $coupon = new Coupon;
            $selCats = array();
            $selUsers = array();
            $message = "Coupon khuyến mãi đã được thêm thành công!";
        }else{
            // Edit Coupon Functionality
            $title = "Sửa Coupon Khuyến Mãi";  
            $coupon = Coupon::find($id);
            $selCats = explode(',',$coupon['categories']);
            $selUsers = explode(',',$coupon['users']);
            $message = "Coupon khuyến mãi đã được cập nhật thành công!";
        }

        // Section with Categories
        $categories = Section::where('id', '!=', 2)->where('id', '!=', 4)->where('status', 1)->with('categories')->get();
        $categories = json_decode(json_encode($categories), true);

        $users = User::select('email')->where('status', 1)->get()->toArray();

        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            
            // Brand Validations
            $rules = [
                'coupon_type' => 'required',
                'amount_type' => 'required',
                'amount' => 'required',
                'expiry_date' => 'required',
            ];  
            $customMessages = [
                'coupon_type.required' => 'Vui lòng chọn thể lệ coupon (dùng một/nhiều lần).',
                'amount_type.required' => 'Vui lòng chọn loại coupon (phần trăm/cố định).',
                'amount.required' => 'Vui lòng nhập giá trị của coupon.',
                'expiry_date.required' => 'Vui lòng gia hạn sử dụng của coupon.',
            ];
            $this->validate($request, $rules, $customMessages);


            if(isset($data['users'])){
                $users = implode(',',$data['users']);
            }else{  
                $users = "";
            }
            if(isset($data['categories'])){
                $categories = implode(',',$data['categories']);
            }else{  
                $categories = "";
            }
            if($data['coupon_option']=="Automatic" && empty($data['coupon_code'])){
                $coupon_code = str_random(8);
            }else{
                $coupon_code = $data['coupon_code'];
            }

            $coupon->coupon_option = $data['coupon_option'];
            $coupon->coupon_code = $coupon_code;
            $coupon->categories = $categories;
            $coupon->users = $users;
            $coupon->coupon_type = $data['coupon_type'];
            $coupon->amount_type = $data['amount_type'];
            $coupon->amount = $data['amount'];
            $coupon->expiry_date = $data['expiry_date'];
            $coupon->save();

            session::flash('success_message',$message);
            return redirect('admin/coupons');
        }
        return view('admin.coupons.add_edit_coupon')->with(compact('title','coupon', 'categories', 'users', 'selCats', 'selUsers'));
    }

    public function deleteCoupon($id){
        // delete Coupon 
        Coupon::where('id',$id)->delete();

        $message = 'Coupon khuyến mãi đã được xóa thành công!';
        session::flash('success_message',$message);
        return redirect()->back();
    }
}
