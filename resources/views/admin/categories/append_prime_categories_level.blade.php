<div class="form-group">
    @if(!empty($getCategories))
        @foreach($getCategories as $category)
            <input type="hidden" name="parentCategory_id" value="{{ $category['parent_id'] }}">
        @endforeach
    @endif
</div>