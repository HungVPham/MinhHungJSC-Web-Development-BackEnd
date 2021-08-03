<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\CmsPage;
use Session;


class CmsController extends Controller
{
    public function CmsPage(){
        $currentRoute = url()->current();
        $currentRoute = str_replace("http://127.0.0.1:8000/chinh-sach/", "",$currentRoute);
        $cmsRoutes = CmsPage::where('status', 1)->get()->pluck('url')->toArray();
        // dd($cmsRoutes); die;
        if(in_array($currentRoute, $cmsRoutes)){
            $cmsPageDetails = CmsPage::where('url',$currentRoute)->first()->toArray();
            return view('front.pages.cms_page')->with(compact('cmsPageDetails'));
        }else{
            abort(404);
        }
    }

    public function contact(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            // send user email to admin
            $email = "hung.v.pham002@gmail.com";
            $messageData = [
                'email' => $data['email'],
                'name' => $data['name'],
                'subject' => $data['subject'],
                'comment' => $data['message'],
            ];
            Mail::send('emails.enquiry',$messageData,function($message) use($email){ 
                $message->to($email)->subject('Hỏi/Đáp Từ Khách Hàng');
            });

            $message = "Cám ơn bạn đã gửi câu hỏi tới Minh Hưng JSC. Hãy kiểm tra hộp mail của bạn trong thời gian tới nhé!";
            session::flash('success_message', $message);
            return redirect()->back();
        }
        return view('front.pages.contact_page');
    }
}
