@include('panel.auth.header')
{{--  --}}


<div class="container-xxl flex-grow-1 container-p-y">
    @include('panel.components.alert_toasts')
    <div class="card mb-4">
        <h5 class="card-header">Edycja kategorii</h5>
        <div class="card-body m-1">
                
            <!-- Basic Breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">

                    @if (count($parent_categories) == 0)
                        <li class="breadcrumb-item active">Wszystko</li>
                    @else
                        <li class="breadcrumb-item active">
                            <a href="{{ route('admin.categories') }}">Wszystko</a>
                        </li>
                    @endif

                    @foreach (array_reverse($parent_categories) as $p_category)
                        <li class="breadcrumb-item">
                            <a
                                href="{{ route('admin.categories', ['id' => $p_category->id]) }}">{{ $p_category->name }}</a>
                        </li>
                    @endforeach

                </ol>
            </nav>
            <!-- Basic Breadcrumb -->

        </div>
    </div>
    <div class="card mb-4">
        <div class="card-body m-1">
            <form action="{{ route('admin.categories.add') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nazwa kategorii</label>
                    <input type="text" class="form-control" id="name" name="name" required
                        value="{{ $category->name }}">
                    <input type="hidden" class="form-control" id="update_id" name="update_id"
                        value="{{ $category->id }}">
                    <input type="hidden" class="form-control" id="parent_category_id" name="parent_category_id"
                        value="{{ $category->parent_id }}">

                </div>
                <button type="submit" class="btn btn-primary">Zapisz</button>
                <a type="button" class="btn btn-secondary" href="{{ route('admin.categories', ['param' => $category->parent_id ]) }}">Powrót</a>
            </form>
        </div>
    </div>
</div>

@include('panel.auth.footer')
