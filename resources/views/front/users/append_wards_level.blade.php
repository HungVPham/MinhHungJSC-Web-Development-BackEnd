<!-- /.form-group -->
<style>
    select {
      -webkit-appearance: none !important;
      width: 100% !important;
      font-size: 20px !important;
    }
    option {
      -webkit-appearance: none !important;
      height: 4.0rem !important;
      font-size: 20px !important;
    }
</style>
<label for="ward">Phường/Xã:</label>

<select id="ward" name="ward" style="width: 100%;" class="form-control select2">
  <option value="">chọn phường/xã</option>
    @if(!empty($getWards))
        @foreach($getWards as $ward)
            <option 

            @if(isset($userDetails['ward']) && $userDetails['ward'] == $ward['_prefix'].' '.$ward['_name']) selected="" 
            @elseif(isset($address['ward']) && $address['ward'] == $ward['_prefix'].' '.$ward['_name']) selected="" 
            @endif 

            @if(isset($shipping['ward']) && $shipping['ward'] == $ward['_prefix'].' '.$ward['_name']) selected="" 
            @endif 
            
            
            value="{{ $ward['id'] }}"

            >{{ $ward['_prefix'] }} {{ $ward['_name'] }}</option>
        @endforeach
    @endif
</select>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
<script>

    $('select').on('change', function (e) {

      var ward_id = $(this).val();
    
      $.ajax({

        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },

        type:'post',
        url:'/append-shipping-charges',
        data:{ward_id:ward_id},

        success:function(resp){
            $("#appendShippingCharges").html(resp);
            $.ajax({

              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },

              type:'post',
              url:'/append-grand-total',

              success:function(resp1){
                $("#appendGrandTotal").html(resp1);
              },error:function(){
                alert("Error");
              }


            });
        },error:function(){
            alert("Error");
        }

      });

    });

</script>