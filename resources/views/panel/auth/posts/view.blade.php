@include('panel.auth.header')

<div class="container-xxl flex-grow-1 container-p-y">
    {{--  --}}
    @include('panel.components.alert_toasts')

    <div class="card mb-4">
        <h5 class="card-header">TODO</h5>

        <div class="card-body m-1">

            <!-- Basic Breadcrumb -->
            <nav aria-label="breadcrumb">

                <ol class="breadcrumb">

                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.categories') }}">Wszystko</a>
                        </li>

                        @foreach (array_reverse($parent_categories) as $par_category)
                            <li class="breadcrumb-item active">
                                <a
                                    href="{{ route('admin.categories', ['id' => $par_category->id]) }}">{{ $par_category->name }}</a>
                            </li>
                        @endforeach
                        
                        <li class="breadcrumb-item active">
                            <a
                                href="#">{{ $post->title }}</a>
                        </li>

                </ol>
            </nav>
            <!-- Basic Breadcrumb -->

            <hr>

            <div class="d-flex justify-content-between">
                {{-- <button type="button" class="btn btn-primary me-auto mx-1" data-bs-toggle="modal" data-bs-target="#editChild">
                    Dodaj kategorię poniżej
                </button> --}}

                <button type="button" class="btn btn-secondary me-auto mx-1" data-bs-toggle="modal"
                    data-bs-target="#editSelf">
                    Edytuj wpis
                </button>
                {{-- {{ route('admin.categories.delete', ['id' => $current_category_id]) }} --}}
                <a type="button" class="btn btn-danger mx-1" href="#">
                    Usuń wpis
                </a>
            </div>


        </div>
    </div>
    <div class="card mb-4">test </div>
</div>

@include('panel.auth.footer')
