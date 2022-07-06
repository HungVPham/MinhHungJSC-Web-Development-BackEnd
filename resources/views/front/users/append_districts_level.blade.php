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
<label for="district">Quận/Huyện:</label>
<select id="district" name="district" style="width: 100%;" class="form-control select2">
  <option value="">chọn quận/huyện</option>
    @if(!empty($getDistricts))
        @foreach($getDistricts as $district)
            <option 
            
            @if(isset($userDetails['district']) && $userDetails['district'] == $district['_prefix'].' '.$district['_name']) selected="" 
            @elseif(isset($address['district']) && $address['district'] == $district['_prefix'].' '.$district['_name']) selected="" 
            @endif value="{{ $district['id'] }}"

            @if(isset($shipping['district']) && $shipping['district'] == $district['_prefix'].' '.$district['_name']) selected=""
            @endif 
            
            value="{{ $district['id'] }}">{{ $district['_prefix'] }} {{ $district['_name'] }}</option>
        @endforeach
    @endif
</select>