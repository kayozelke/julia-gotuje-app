@include('panel.auth.header')

<div class="container-xxl flex-grow-1 container-p-y">
    {{--  --}}
    @include('panel.components.alert_toasts')

    <div class="card mb-4">
        <h5 class="card-header">Podgląd wpisu - <strong>{{ $post->title }}</strong></h5>

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
    <div class="card mb-4">
        <h5 class="card-header">Headings</h5>
        <table class="table table-borderless">
            <tbody>
                <tr>
                    <td><small class="text-light fw-semibold">Tytuł</small></td>
                    <td class="py-3"><h3 class="mb-0">{{ $post->title }}</h3></td>
                </tr>
                <tr>
                    <td><small class="text-light fw-semibold">Adres URL</small></td>
                    <td class="py-3"><h5 class="mb-0">{{ $post->url }}</h5></td>
                </tr>
                <tr>
                    <td><small class="text-light fw-semibold">ID</small></td>
                    <td class="py-3"><h6 class="mb-0"><small>{{ $post->id }}</small></h6></td>
                </tr>
                <tr>
                    <td><small class="text-light fw-semibold">Dodano</small></td>
                    <td class="py-3"><h6 class="mb-0"><small>{{ $post->created_at }} przez {{ $post->createdByUser->first_name }} {{ $post->createdByUser->last_name }}</small></h6></td>
                </tr>
                <tr>
                    <td><small class="text-light fw-semibold">Zmodyfikowano</small></td>
                    <td class="py-3"><h6 class="mb-0"><small>{{ $post->updated_at }} przez {{ $post->updatedByUser->first_name }} {{ $post->updatedByUser->last_name }}</small></h6></td>
                </tr>











                {{-- <tr>
                    <td><small class="text-light fw-semibold">Heading 6</small></td>
                    <td class="py-3"><h6 class="mb-0">Bootstrap heading</h6></td>
                </tr> --}}









                {{-- <tr>
                    <td class="align-middle"><small class="text-light fw-semibold">Heading 1</small></td>
                    <td class="py-3">
                        <h1 class="mb-0">Bootstrap heading</h1>
                    </td>
                </tr>
                <tr>
                    <td class="align-middle"><small class="text-light fw-semibold">Heading 2</small></td>
                    <td class="py-3">
                        <h2 class="mb-0">Bootstrap heading</h2>
                    </td>
                </tr>
                <tr>
                    <td><small class="text-light fw-semibold">Heading 3</small></td>
                    <td class="py-3">
                        <h3 class="mb-0">Bootstrap heading</h3>
                    </td>
                </tr>
                <tr>
                    <td><small class="text-light fw-semibold">Heading 4</small></td>
                    <td class="py-3">
                        <h4 class="mb-0">Bootstrap heading</h4>
                    </td>
                </tr>
                <tr>
                    <td><small class="text-light fw-semibold">Heading 5</small></td>
                    <td class="py-3">
                        <h5 class="mb-0">Bootstrap heading</h5>
                    </td>
                </tr>
                <tr>
                    <td><small class="text-light fw-semibold">Heading 6</small></td>
                    <td class="py-3">
                        <h6 class="mb-0">Bootstrap heading</h6>
                    </td>
                </tr> --}}
            </tbody>
        </table>
    </div>
</div>

@include('panel.auth.footer')
