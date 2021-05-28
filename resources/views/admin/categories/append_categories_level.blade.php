<!-- /.form-group -->
<style>
select {
  -webkit-appearance: none !important;
}
option {
  -webkit-appearance: none !important;
  height: 4.0rem !important;
}
</style>
<div class="form-group">
    <label>&nbsp;Cấp Thể Loại @if(empty($categorydata['id']))<span class="required" aria-hidden="true">*</span>@endif</label>
    <select name="parent_id" id="parent_id" class="form-control select2" style="width: 100%;">
        <option value="0" @if(isset($categorydata['parent_id']) && $categorydata['parent_id']==0) selected=""@endif>cấp gốc (0)</option>
        @if(!empty($getCategories))
            @foreach($getCategories as $category)
                <option value="{{ $category['id'] }}" @if(isset($categorydata['parent_id']) && $categorydata['parent_id']==$category['id']) selected=""@endif>{{ $category['category_name'] }}</option>
                @if(!empty($category['subcategories']))
                    @foreach($category['subcategories'] as $subcategory)
                        <option disabled value="{{ $subcategory['id'] }}">&#8627;&nbsp;{{ $subcategory['category_name'] }}&nbsp;(cấp 1)</option>
                    @endforeach
                @endif
            @endforeach
        @endif
    </select>
</div>