<!-- /.form-group -->
<div class="form-group">
    <label>Cấp Thể Loại</label>
    <select name="parent_id" id="parent_id" class="form-control select2" style="width: 100%;">
        <option value="0">cấp gốc (0)</option>
        @if(!empty($getCategories))
            @foreach($getCategories as $category)
                <option value="{{ $category['id'] }}">&nbsp;&nbsp;&nbsp;{{ $category['category_name'] }}&nbsp;(cấp 1)</option>
                @if(!empty($category['subcategories']))
                    @foreach($category['subcategories'] as $subcategory)
                        <option value="{{ $subcategory['id'] }}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&raquo;&nbsp;{{ $subcategory['category_name'] }}&nbsp;(cấp 2)</option>
                    @endforeach
                @endif
            @endforeach
        @endif
    </select>
</div>