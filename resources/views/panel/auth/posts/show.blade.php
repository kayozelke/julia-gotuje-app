@include('panel.auth.header')

<link href="https://cdn.jsdelivr.net/npm/suneditor@latest/dist/css/suneditor.min.css" rel="stylesheet">

<div class="container-xxl flex-grow-1 container-p-y">
    {{--  --}}
    @include('panel.components.alert_toasts')

    <div class="card mb-4">
        <h5 class="card-header">Podgląd posta</h5>

        <div class="card-body m-1">

            <!-- Basic Breadcrumb -->
            <nav aria-label="breadcrumb">

                <ol class="breadcrumb">

                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.posts') }}">Wszystko</a>
                    </li>

                    @foreach (array_reverse($parent_categories) as $par_category)
                        <li class="breadcrumb-item">
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

            <hr>

            <div class="row text-center">
                {{-- <button type="button" class="btn btn-primary me-auto mx-1" data-bs-toggle="modal" data-bs-target="#editChild">
                    Dodaj kategorię poniżej
                </button> --}}

                {{-- <button type="button" class="btn btn-secondary me-auto mx-1" data-bs-toggle="modal"
                    data-bs-target="#editSelf">
                    Edytuj wpis
                </button> --}}

                <div class="col">
                    <a type="button" class="btn btn-secondary me-auto mx-1" href="{{ route('admin.posts.update', ['update_id' => $post->id]) }}">
                        Edytuj wpis
                    </a>
                </div>
                <div class="col">
                    <a type="button" class="btn btn-danger me-auto mx-1" href="{{ route('admin.posts.delete', ['id' => $post->id]) }}">
                        Usuń wpis
                    </a>
                </div>

            </div>


        </div>
    </div>
    <div class="card mb-4">
        <h5 class="card-header">Właściwości</h5>
        <table class="table table-borderless">
            <tbody>
                <tr>
                    <td><small class="text-light fw-semibold">Tytuł</small></td>
                    <td class="py-3"><h3 class="mb-0">{{ $post->title }}</h3></td>
                </tr>
                <tr>
                    <td><small class="text-light fw-semibold">Adres URL</small></td>
                    <td class="py-3">
                        <h5 class="mb-0">
                            <a href="{{ url('/') }}/{{ $post->url }}">
                                <small>{{ url('/') }}/</small>{{ $post->url }}
                            </a>
                        </h5>
                    </td>
                </tr>
                
                <tr>
                    <td><small class="text-light fw-semibold">ID</small></td>
                    <td class="py-3"><h6 class="mb-0"><small>{{ $post->id }}</small></h6></td>
                </tr>

                <tr>
                    <td><small class="text-light fw-semibold">Typ</small></td>
                    <td class="py-3">
                        <h6 class="mb-0">
                            <small>
                                {{ $post->template_type == 'recipe' ? 'Przepis' : '' }}
                                {{ $post->template_type == 'default' ? 'Zwykły wpis' : '' }}
                            </small>
                        </h6>
                    </td>
                </tr>
                
                <tr>
                    <td><small class="text-light fw-semibold">Post ukryty na stałe</small></td>
                    <td class="py-3"><h6 class="mb-0"><small>{{ $post->is_hidden ? 'Tak' : 'Nie' }}</small></h6></td>
                </tr>

                <tr>
                    <td><small class="text-light fw-semibold">Późniejsza publikacja postu</small></td>
                    <td class="py-3"><h6 class="mb-0"><small>{{ $post->hide_before_time ? $post->hide_before_time : 'Nie ustawiono' }}</small></h6></td>
                </tr>

                <tr>
                    <td><small class="text-light fw-semibold">Dodano</small></td>
                    <td class="py-3"><h6 class="mb-0"><small>{{ $post->created_at }} przez {{ $post->createdByUser->first_name }} {{ $post->createdByUser->last_name }}</small></h6></td>
                </tr>
                <tr>
                    <td><small class="text-light fw-semibold">Zmodyfikowano</small></td>
                    <td class="py-3"><h6 class="mb-0"><small>{{ $post->updated_at }} przez {{ $post->updatedByUser->first_name }} {{ $post->updatedByUser->last_name }}</small></h6></td>
                </tr>

            </tbody>
        </table>
    </div>


    <div class="card mb-4">
        <h5 class="card-header">Treść</h5>

        <div class="px-4 py-3">
            {!! $post->content !!}
        </div>
        
    </div>

    @if (count($post_images) > 0)

        <h5 class="pb-1 mt-1 mb-3">Galeria</h5>
        <div class="row mb-4">
            
            @foreach ($post_images as $post_image)
                <div class="col-md-6 col-lg-4">
                    <div class="card mb-4">
                        <img class="card-img-top" src="{{ $post_image->image->file_location }}">
                        <div class="card-body">
                            <p class="card-text">
                                {{ $post_image->image->title }}
                            </p>
                            <p class="card-text">
                                <small>
                                    {{ $post_image->image->label }}
                                </small>
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
    @endif

    {{-- DEBUG for Gallery --}}
    {{-- <div class="card mb-4">
        <h5 class="card-header">Galeria</h5>
        <div class="px-4 py-3">
        </div>
        @php
            print_r($post_images);
        @endphp
    </div> --}}

</div>

@include('panel.auth.footer')
