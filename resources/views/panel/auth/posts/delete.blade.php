@include('panel.auth.header')
{{--  --}}


<div class="container-xxl flex-grow-1 container-p-y">
    @include('panel.components.alert_toasts')
    <div class="card mb-4">
        <h5 class="card-header">Usuwanie wpisu</h5>
        <div class="card-body m-1">
                
            <!-- Basic Breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">

                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.posts') }}">Wszystko</a>
                    </li>

                    @foreach (array_reverse($parent_categories) as $par_category)
                        <li class="breadcrumb-item active">
                            <a
                                href="{{ route('admin.posts', ['category_id' => $par_category->id]) }}">{{ $par_category->name }}</a>
                        </li>
                    @endforeach

                    <li class="breadcrumb-item active">
                        <a href="#">{{ $post->title }}</a>
                    </li>

                </ol>
            </nav>
            <!-- Basic Breadcrumb -->

        </div>
    </div>
    <div class="card mb-4">
        <div class="card-body m-1">
            <div class="alert alert-danger m-3 text-center" role="alert">
                <h6 class="mb-0">Czy na pewno chcesz usunąć wpis "{{$post->title}}"?</h6>
            </div>
            <div class="d-flex justify-content-center">
                <form action="{{ route('admin.posts.delete.post') }}" method="POST">
                    @csrf
                    <input type="hidden" name="delete_id" value="{{ $post->id }}" id="delete_id">
                    <button type="submit" class="btn btn-danger mx-2" role="button">Usuń</button>
                </form>
                <a href="{{$backPage}}" class="btn btn-secondary mx-2" role="button">Anuluj</a>
            </div>            
        </div>
    </div>
</div>

@include('panel.auth.footer')
