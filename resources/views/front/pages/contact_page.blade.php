@extends('layouts.front_layout.front_layout')
@section('content')
<style>
    .fab.fa-youtube {
    padding: inherit;
    float: inherit;
    font-size: inherit;
    cursor: inherit;
    margin-left: inherit;
    color: inherit;
    }
    #name-error, #message-error, #sender-error, #subject-error{
    font-size: 16px;
    font-weight: 700;
    width: 100%;
    text-align: left;
    color: var(--MinhHung-Red);
    margin-left: 5px;
    }
    input[name=email]{ /* bait input */
        /* do not use display:none or visibility:hidden
            that will not fool the bot */
        position:absolute;
        left:-2000px;
    }
</style>
<div class="contact-page">
    @if(Session::has('success_message'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="color: #228B22; background-color: #ffffff; border: 1px solid #228B22; text-align: center;">
        {{ Session::get('success_message') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    @endif
    @if(Session::has('error_message'))
        <div class="alert alert-danger" role="alert" style="color: #ffffff; background-color: #cb1c22; border: 1px solid #cb1c22; text-align: center;">
        {{ Session::get('error_message') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
    @endif
    <section id="contact">
        <div class="social">
        <a href="tel: 028 62 666 333" target="_blank"><i class="fas fa-phone"></i></a>
        <a href="mailto:salesminhhung@gmail.com?subject= Hỏi/Đáp: Minh Hưng JSC" target="_blank"><i class="fas fa-envelope"></i></a>
        <a href="https://www.facebook.com/pages/C%C3%B4ng%20ty%20CP%20%C4%90%E1%BA%A7u%20T%C6%B0%20v%C3%A0%20Ph%C3%A1t%20Tri%E1%BB%83n%20Minh%20H%C6%B0ng/1966408697008473/" target="_blank"><i class="fab fa-facebook-f"></i></a>
        <a href="https://www.youtube.com/channel/UCG5dwZKUAWetHU3BAkSl8Og" target="_blank"><i class="fab fa-youtube"></i></a>
        <a href="https://www.instagram.com/nemgalaxy.vn/" target="_blank"><i class="fab fa-instagram"></i></a>
        <a href="https://nemgalaxy.vn/" target="_blank"><i><img src="{{ asset('/images/front_images/logo(galaxy).png') }}" width="25px"></i></a>
        </div>
        <form id="ContactForm" action="{{ url('/contact-us') }}" method="post">@csrf
        <div class="contact-box">
            <div class="c-heading">
                <h1>Hãy Liên Hệ Với Minh Hưng JSC!</h1>
                <p>Gọi hoặc email chúng tôi để giải đáp những thắc mắc hoặc vấn đề.</p>
            </div>
            <div class="c-inputs">
                <input type="email" name="email" id="email" placeholder="Your email" autocomplete="nope" tabindex="-1">
                <input type="text" name="name" id="name" placeholder="Họ và Tên"/>
                <input type="email" name="sender" id="sender" placeholder="Email"/> 
                <input type="subject" name="subject" id="subject" placeholder="Chủ Đề"/> 
                <textarea type="text" name="message" id="message" placeholder="lời nhắn hoặc câu hỏi của quý khách..."></textarea>
                <button class="btn">Gửi Đi</button>
            </div>
        </div>
        </form>
        <div class="map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.5719751328215!2d106.61115554397742!3d10.767433561344752!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752d7114fca8dd%3A0x637c2ff3b399eb8d!2zQ8O0bmcgdHkgQ-G7lSBwaOG6p24gxJDhuqd1IHTGsCBWw6AgUGjDoXQgdHJp4buDbiBNaW5oIEjGsG5n!5e0!3m2!1sen!2s!4v1613809582829!5m2!1sen!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
    </section>
</div>
@endsection