@include('panel.auth.header')
{{--  --}}

<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modalCenterTitle">Edycja kategorii</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"
                aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('admin.categories.add', ['param' => $category->id]) }}"
                method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nazwa kategorii</label>
                    <input type="text" class="form-control" id="name" name="name" required value="{{ $category->name }}">
                    <input type="hidden" class="form-control" id="update_id" name="update_id" value="{{ $category->id }}">
                    <input type="hidden" class="form-control" id="parent_category_id"
                        name="parent_category_id" value="{{ $category->parent_id }}">

                </div>
                <button type="submit" class="btn btn-primary">Zapisz</button>
            </form>
        </div>
    </div>
</div>

@include('panel.auth.footer')