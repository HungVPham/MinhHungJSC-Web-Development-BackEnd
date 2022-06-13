@extends('layouts.front_layout.front_layout')
@section('content')
<link href="https://fonts.googleapis.com/css?family=Kaushan+Script|Source+Sans+Pro" rel="stylesheet">
<style>
    .number-input {
        border: 2px solid #888;
        display: inline-flex;
        height: 28px;
        margin: 0px;
        margin-bottom: 8px;
    }
    .empty-cart .btn{
        border: 2px solid black;
        color: #00000030;
        background: #ffffff;
    }
    .empty-cart .btn:hover{
        border-color: var(--MinhHung-Red) !important;
        color: #000000 !important;   
    }
    .voucher-containter{
        margin-top: 0px;
        width: 100%
    }
    .voucher-containter .btn:first-child{
        border: 2px solid black;
        color: #00000030;
        background: #ffffff;
        margin-right: 10px;
    }
    .voucher-containter .btn:first-child:hover{
        border-color: var(--MinhHung-Red) !important;
        color: #000000 !important;
    }
    h5 a:nth-child(2){
        color: #444;
    }
    h5 a:nth-child(2):hover{
        color: var(--MinhHung-Red) !important;
    }
    form .btn{
        width: inherit;
    }
    #address, #order-note{
        margin: 5px;
        margin-left: 0px;
        margin-right: 10px;
    }
    .cart-table tr td:nth-child(3), .cart-table tr td:nth-child(4), .cart-table tr th:nth-child(3), .cart-table tr th:nth-child(4) {
        display: revert;
    }
    #full_name-error, #mobile-error, #email-error, #address-error, #payment_method-error{
        display: block;
        font-size: 16px;
        font-weight: 700;
        width: 100%;
        text-align: left;
        color: var(--MinhHung-Red);
        margin-left: 5px;
    }
    p {
        margin-bottom: 0;
    }
</style>
<style>

.wrapper-1{
  width:100%;
  height:100vh;
  display: flex;
  flex-direction: column;
}
.wrapper-2{
  padding :30px;
  text-align:center;
}
h1{
    font-family: 'Kaushan Script', cursive;
  font-size:4em;
  letter-spacing:3px;
  color: var(--MinhHung-Red) ;
  margin:0;
  margin-bottom:20px;
}
.wrapper-2 p{
  margin:0;
  font-size:1.3em;
}

@media (min-width:360px){
  h1{
    font-size:4.5em;
  }
  .go-home{
    margin-bottom:20px;
  }
}

@media (min-width:600px){
  .content{
  max-width:1000px;
  margin:0 auto;
}
  .wrapper-1{
  height: initial;
  max-width:620px;
  margin:0 auto;
  margin-top:50px;
}
}

.btn{
        border: 2px solid black !important;
        color: #00000030 !important;
        background: #ffffff !important;
    }
    .btn:hover{
        border-color: var(--MinhHung-Red) !important;
        color: #000000 !important;   
    }

    canvas {
      width: 100%;
      height: 100vh;
      position: absolute;
      z-index: 1;
    }

    .small-container{
        position: relative;
        z-index: 2;
    }

    .footer{
        position: relative;
        z-index: 2;
    }
    
</style>
<!--Cart Items Details-->
<canvas id="confetti"></canvas>
<div class="small-container cart-page">
    <div class="row listing head first cart">
        <h5><a href="{{ url('/') }}">Trang Chủ</a> / <a href="{{ url('/cart') }}">Giỏ Hàng</a> / Cám ơn quý khách!</h5>
    </div>
<div class=content>
    <div class="wrapper-1">
      <div class="wrapper-2">
        <h1>thank you !</h1>
        <p>Đơn hàng của quý khách đã được đặt thành công! </p>
        <p>Mã Đơn hàng: {{ Session::get('order_id') }} </p>
        @if(Auth::check())
        <p>Tổng trị giá: <?php 
            $grand_total = Session::get('grand_total');
            $format = number_format($grand_total,0,",",".");
             echo $format;
            ?> ₫ 
            </p>
        @else
            <p>Tổng trị giá: <?php 
                $grand_total = Session::get('total_price');
                $format = number_format($grand_total,0,",",".");
                 echo $format;
                ?> ₫ 
                </p>
        @endif
        <p>
            <a href="{{ url('/') }}" class="btn">&larr; Quay Trở Lại</a>
        </p>
      </div>
  </div>
  </div>

</div>

<script>
   // global variables
const confetti = document.getElementById('confetti');
const confettiCtx = confetti.getContext('2d');
let container, confettiElements = [], clickPosition;

// helper
rand = (min, max) => Math.random() * (max - min) + min;

// params to play with
const confettiParams = {
    // number of confetti per "explosion"
    number: 100,
    // min and max size for each rectangle
    size: { x: [5, 20], y: [10, 18] },
    // power of explosion
    initSpeed: 25,
    // defines how fast particles go down after blast-off
    gravity: 0.70,
    // how wide is explosion
    drag: 0.08,
    // how slow particles are falling
    terminalVelocity: 6,
    // how fast particles are rotating around themselves
    flipSpeed: 0.017,
};
const colors = [
    { front : '#cb1c22', back: 'rgb(165, 24, 29)' },
    { front : '#db850e', back: '#be750d' },
    { front : '#00a0a8', back: '#007980' },
    { front : '#efe649', back: '#c9c243' },
    { front : '#56a6a5', back: '#4a9190' },
];

setupCanvas();
updateConfetti();

// Confetti constructor
function Conf() {
    this.randomModifier = rand(-1, 1);
    this.colorPair = colors[Math.floor(rand(0, colors.length))];
    this.dimensions = {
        x: rand(confettiParams.size.x[0], confettiParams.size.x[1]),
        y: rand(confettiParams.size.y[0], confettiParams.size.y[1]),
    };
    this.position = {
        x: clickPosition[0],
        y: clickPosition[1]
    };
    this.rotation = rand(0, 2 * Math.PI);
    this.scale = { x: 1, y: 1 };
    this.velocity = {
        x: rand(-confettiParams.initSpeed, confettiParams.initSpeed) * 0.4,
        y: rand(-confettiParams.initSpeed, confettiParams.initSpeed)
    };
    this.flipSpeed = rand(0.2, 1.5) * confettiParams.flipSpeed;

    if (this.position.y <= container.h) {
        this.velocity.y = -Math.abs(this.velocity.y);
    }

    this.terminalVelocity = rand(1, 1.5) * confettiParams.terminalVelocity;

    this.update = function () {
        this.velocity.x *= 0.98;
        this.position.x += this.velocity.x;

        this.velocity.y += (this.randomModifier * confettiParams.drag);
        this.velocity.y += confettiParams.gravity;
        this.velocity.y = Math.min(this.velocity.y, this.terminalVelocity);
        this.position.y += this.velocity.y;

        this.scale.y = Math.cos((this.position.y + this.randomModifier) * this.flipSpeed);
        this.color = this.scale.y > 0 ? this.colorPair.front : this.colorPair.back;
    }
}

function updateConfetti () {
    confettiCtx.clearRect(0, 0, container.w, container.h);

    confettiElements.forEach((c) => {
        c.update();
        confettiCtx.translate(c.position.x, c.position.y);
        confettiCtx.rotate(c.rotation);
        const width = (c.dimensions.x * c.scale.x);
        const height = (c.dimensions.y * c.scale.y);
        confettiCtx.fillStyle = c.color;
        confettiCtx.fillRect(-0.5 * width, -0.5 * height, width, height);
        confettiCtx.setTransform(1, 0, 0, 1, 0, 0)
    });

    confettiElements.forEach((c, idx) => {
        if (c.position.y > container.h ||
            c.position.x < -0.5 * container.x ||
            c.position.x > 1.5 * container.x) {
            confettiElements.splice(idx, 1)
        }
    });
    window.requestAnimationFrame(updateConfetti);
}

function setupCanvas() {
    container = {
        w: confetti.clientWidth,
        h: confetti.clientHeight
    };
    confetti.width = container.w;
    confetti.height = container.h;
}

function addConfetti(e) {
    const canvasBox = confetti.getBoundingClientRect();
    if (e) {
        clickPosition = [
            e.clientX - canvasBox.left,
            e.clientY - canvasBox.top
        ];
    } else {
        clickPosition = [
            canvasBox.width * Math.random(),
            canvasBox.height * Math.random()
        ];
    }
    for (let i = 0; i < confettiParams.number; i++) {
        confettiElements.push(new Conf())
    }
}

function hideConfetti() {
    confettiElements = [];
    window.cancelAnimationFrame(updateConfetti)
}

confettiLoop();
function confettiLoop() {
    addConfetti();
    setTimeout(confettiLoop, 700 + Math.random() * 1700);
}
</script>


@endsection

<?php
Session::forget('grand_total'); 
Session::forget('total_price'); 
Session::forget('order_id'); 
Session::forget('couponAmount');
Session::forget('couponCode');
?>