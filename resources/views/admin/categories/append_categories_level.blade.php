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
    <label>Cấp Thể Loại</label>
    <select name="parent_id" id="parent_id" class="form-control select2" style="width: 100%;">
        <option value="0">cấp gốc (0)</option>
        @if(!empty($getCategories))
            @foreach($getCategories as $category)
                <option value="{{ $category['id'] }}">{{ $category['category_name'] }}&nbsp;(cấp 1)</option>
                @if(!empty($category['subcategories']))
                    @foreach($category['subcategories'] as $subcategory)
                        <option value="{{ $subcategory['id'] }}">&#8627;&nbsp;{{ $subcategory['category_name'] }}&nbsp;(cấp 2)</option>
                    @endforeach
                @endif
            @endforeach
        @endif
    </select>
</div>