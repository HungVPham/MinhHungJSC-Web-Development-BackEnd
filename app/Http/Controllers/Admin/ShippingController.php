<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ShippingCharge;
use Session;
use App\Country;
use App\Province;
use App\District;
use App\Ward;

class ShippingController extends Controller
{
    public function shippingCharges() {

        Session::put('page', 'shipping-charges');

        $shipping_charges = ShippingCharge::get()->toArray();

        return view('admin.shipping.shipping_charges')->with(compact('shipping_charges'));
    }

    public function addEditShippingCharges(Request $request,$id=null){
        if($id==""){
            // add shipping charge
            $shipping = new ShippingCharge;
            $title = "Thêm Phí Giao Hàng";
            $message = 'Phí giao hàng đã được thêm!';
        }else{
            // edit shipping charge
            $shipping = ShippingCharge::find($id);
            $title = "Sửa Phí Giao Hàng";
            $message = 'Phí giao hàng đã được sửa thành công!';
        }

        $countries = Country::where('status', 1)->get()->toArray();
        $provinces = Province::get()->toArray();
        $getWards = Ward::where('_district_id', $shipping['district_id'])->get();
        $getWards = json_decode(json_encode($getWards),true);
        $getDistricts = District::where('_province_id', $shipping['province_id'])->get();
        $getDistricts = json_decode(json_encode($getDistricts),true);

        if($request->isMethod('post')){

            $rules = [
                'shipping_charges' => 'required',
                'province' => 'required',
                'district' => 'required',
                'ward' => 'required',
            ];  
            $customMessages = [
                'shipping_charges.required' => 'Vui lòng thêm phí giao hàng.',
                'province.required' => 'Vui lòng chọn tỉnh/thành.',
                'district.required' => 'Vui lòng chọn quận/huyện.',
                'ward.required' => 'Vui lòng chọn phường/xã.',
            ];
            $this->validate($request, $rules, $customMessages);

            $data = $request->all();

            $getProvinces = Province::where('id', $data['province'])->get();
            $getProvinces = json_decode(json_encode($getProvinces),true);
            $getDistricts = District::where('id', $data['district'])->get();
            $getDistricts = json_decode(json_encode($getDistricts),true);
            $getWards = Ward::where('id', $data['ward'])->get();
            $getWards = json_decode(json_encode($getWards),true);

            $shipping->province = $getProvinces[0]['_prefix'].' '.$getProvinces[0]['_name'];
            $shipping->province_id = $data['province'];

            $shipping->district = $getDistricts[0]['_prefix'].' '.$getDistricts[0]['_name'];
            $shipping->district_id = $data['district'];

            $shipping->ward = $getWards[0]['_prefix'].' '.$getWards[0]['_name'];
            $shipping->ward_id = $data['ward'];

            $shipping->country = "Việt Nam";
            $shipping->shipping_charges = $data['shipping_charges'];
        
            $shipping->save();

            Session::flash('success_message', $message);

            return redirect('admin/shipping-charges');
        }
        return view('admin.shipping.add_edit_shipping_charges')->with(compact('title', 'shipping', 'countries', 'provinces', 'getDistricts', 'getWards'));
    }

    public function appendDistrictLevel(Request $request){
        if($request->ajax()){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            $getDistricts = District::where('_province_id', $data['province_id'])->get();
            $getDistricts = json_decode(json_encode($getDistricts),true);
            // echo "<pre>"; print_r($getDistricts); die;
            return view('front.users.append_districts_level')->with(compact('getDistricts'));
        }
    }

    public function appendWardLevel(Request $request){
        if($request->ajax()){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            $getWards = Ward::where('_district_id', $data['district_id'])->get();
            $getWards = json_decode(json_encode($getWards),true);
            // echo "<pre>"; print_r($getWards); die;
            return view('front.users.append_wards_level')->with(compact('getWards'));
        }
    }

    public function updateShippingChargeStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            if($data['status']=="đang hoạt động"){
                $status = 0;
            }else{
                $status = 1;
            }
            ShippingCharge::where('id',$data['shipping_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'shipping_id'=>$data['shipping_id']]);
        }
    }

    public function deleteShippingCharge($id){
        // Delete Product 
        ShippingCharge::where('id',$id)->delete();

        $message = 'Tài khoản khách hàng đã được xóa thành công!';
        session::flash('success_message',$message);
        return redirect()->back();
    }



}
