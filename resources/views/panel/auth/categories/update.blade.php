@include('panel.auth.header')
{{--  --}}


<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card mb-4">
        <form action="{{ route('admin.categories.add', ['param' => $category->id]) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Nazwa kategorii</label>
                <input type="text" class="form-control" id="name" name="name" required
                    value="{{ $category->name }}">
                <input type="hidden" class="form-control" id="update_id" name="update_id" value="{{ $category->id }}">
                <input type="hidden" class="form-control" id="parent_category_id" name="parent_category_id"
                    value="{{ $category->parent_id }}">

            </div>
            <button type="submit" class="btn btn-primary">Zapisz</button>
        </form>
    </div>
</div>

@include('panel.auth.footer')
