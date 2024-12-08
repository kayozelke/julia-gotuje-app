@include('panel.auth.header')

<div class="container-xxl flex-grow-1 container-p-y">
    {{-- TOASTS --}}
    @include('panel.components.alert_toasts')

    <div class="card mb-4">
        <h5 class="card-header">Posty</h5>
        {{-- <div class="card-body mb-1">
        </div> --}}
        <div class="card-body m-1">

            <!-- Basic Breadcrumb -->
            <nav aria-label="breadcrumb">

                <ol class="breadcrumb">

                    @if (count($parent_categories) == 0)
                        <li class="breadcrumb-item active">Wszystko</li>
                    @else
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.posts') }}">Wszystko</a>
                        </li>


                        @foreach (array_reverse($parent_categories) as $par_category)
                            <li class="breadcrumb-item @if ($par_category->id == $p_category->id) active @endif">
                                <a
                                    href="{{ route('admin.posts', ['category_id' => $par_category->id]) }}">{{ $par_category->name }}</a>
                            </li>
                            {{-- <li class="breadcrumb-item ">
                                <a href="{{ route('admin.categories', ['id' => $p_category->id]) }}">{{ $par_category->name }}</a>
                            </li> --}}
                        @endforeach
                    @endif


                    {{-- <li class="breadcrumb-item">
                        <a href="javascript:void(0);">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="javascript:void(0);">Library</a>
                    </li>
                    <li class="breadcrumb-item active">Data</li> --}}
                </ol>
            </nav>

            <div class="btn-group">
                <button type="button" class="btn btn-primary dropdown-toggle show" data-bs-toggle="dropdown"
                    aria-expanded="true">
                    Primary
                </button>
                <ul class="dropdown-menu show" data-popper-placement="bottom-start"
                    style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(0px, 41px);">
                    <li><a class="dropdown-item" href="javascript:void(0);">Action</a></li>
                    <li><a class="dropdown-item" href="javascript:void(0);">Another action</a></li>
                    <li><a class="dropdown-item" href="javascript:void(0);">Something else here</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="javascript:void(0);">Separated link</a></li>
                </ul>
            </div>
            <!-- Basic Breadcrumb -->

            <hr>

            {{-- <div class="d-flex justify-content-between">
                <button type="button" class="btn btn-primary me-auto mx-1" data-bs-toggle="modal" data-bs-target="#editChild">
                    Dodaj post poniżej
                </button>
            </div> --}}

        </div>
    </div>



    <!-- Borderless Table -->
    <div class="card mb-4">
    </div>
    <!--/ Borderless Table -->

</div>

@include('panel.auth.footer')
