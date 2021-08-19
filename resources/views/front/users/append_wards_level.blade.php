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
<label for="ward">Phường Xã:</label>
<select id="ward" name="ward" style="width: 100%;" class="form-control select2">
  <option value="">chọn phường/xã</option>
    @if(!empty($getWards))
        @foreach($getWards as $ward)
            <option @if(isset($userDetails['ward']) && $userDetails['ward']==$ward['_prefix'].' '.$ward['_name']) selected="" @elseif(isset($address['ward']) && $address['ward']==$ward['_prefix'].' '.$ward['_name']) selected="" @endif value="{{ $ward['id'] }}">{{ $ward['_prefix'] }} {{ $ward['_name'] }}</option>
        @endforeach
    @endif
</select>