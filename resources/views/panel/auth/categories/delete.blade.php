@include('panel.auth.header')
{{--  --}}


<div class="container-xxl flex-grow-1 container-p-y">
    @include('panel.components.alert_toasts')
    <div class="card mb-4">
        <h5 class="card-header">Usuwanie kategorii</h5>
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
                                href="{{ route('admin.categories', ['param' => $p_category->id]) }}">{{ $p_category->name }}</a>
                        </li>
                    @endforeach

                </ol>
            </nav>
            <!-- Basic Breadcrumb -->

        </div>
    </div>
    <div class="card mb-4">
        <div class="card-body m-1">
            <div class="alert alert-danger m-3 text-center" role="alert">
                <h6 class="mb-0">Czy na pewno chcesz usunąć kategorię "{{$category->name}}"?</h6>
            </div>
            <div class="d-flex justify-content-center">
                <form action="{{ route('admin.categories.delete.post', ['delete_id' => $category->id]) }}" method="POST">
                    @csrf
                    <input type="password" id="password" class="form-control" name="password">
                    <button type="submit" class="btn btn-danger mx-2" role="button">Usuń</button>
                </form>
                <a href="{{$backPage}}" class="btn btn-secondary mx-2" role="button">Anuluj</a>
            </div>            
        </div>
    </div>
</div>

@include('panel.auth.footer')
