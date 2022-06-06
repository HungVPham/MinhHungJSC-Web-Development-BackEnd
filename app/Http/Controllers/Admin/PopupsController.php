<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Popup;
use Session;
use Image;

class PopupsController extends Controller
{
    public function popups(){
        Session::put('page', 'popups');
        $popups = Popup::get()->toArray();
        return view('admin.popups.popups')->with(compact('popups'));
    }

    public function addEditPopup(Request $request,$id=null){
        if($id==""){
            // add popup
            $popup = new Popup;
            $title = "Thêm Popup";
            $message = 'Popup đã được thêm!';
        }else{
            // edit popup
            $popup = Popup::find($id);
            $title = "Sửa Popup";
            $message = 'Popup đã được sửa thành công!';
        }

        if($request->isMethod('post')){
            $data = $request->all();

            $popup->link = $data['link'];
            // $popup->title = $data['title'];
            $popup->alt = $data['alt'];
            
            // Upload Popup Images
            if($request->hasFile('image')){
                $image_tmp = $request->file('image');
                if($image_tmp->isValid()){
                    // get image original name
                    $image_name = $image_tmp->getClientOriginalName();
                    $imageName = rand(1,999999).'_'.$image_name;
                    $popup_image_path = 'images/popup_images/'.$imageName;
                    Image::make($image_tmp)->resize(580,720)->save($popup_image_path);
                    $popup->image = $imageName;
                }
            }
            $popup->save();

            Session::flash('success_message', $message);

            return redirect('admin/popups');
        }
        return view('admin.popups.add_edit_popup')->with(compact('title', 'popup'));
    }

    public function updatePopupStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            if($data['status']=="đang hoạt động"){
                $status = 0;
            }else{
                $status = 1;
            }
            Popup::where('id',$data['popup_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'popup_id'=>$data['popup_id']]);
        }
    }

    public function deletePopup($id){
        // get popup image 
        $popupImage = Popup::where('id',$id)->first();

        // get popup image path
        $popup_image_path = 'images/popup_images/';

        // delete popup image from popup folder
        if(file_exists($popup_image_path.$popupImage->image)){
            unlink($popup_image_path.$popupImage->image);
        }
        
        // delete popup image from popup table
        Popup::where('id',$id)->delete();

        $message = 'Popup đã được xóa thành công!';
        session::flash('success_message',$message);
        return redirect()->back();
    }
}
