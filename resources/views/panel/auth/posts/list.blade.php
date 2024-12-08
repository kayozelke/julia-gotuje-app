@include('panel.auth.header')

<div class="container-xxl flex-grow-1 container-p-y">
    {{-- TOASTS --}}
    @include('panel.components.alert_toasts')

    <div class="card mb-4">
        <h5 class="card-header">Posty</h5>

        <div class="card-body">
            <div class="d-flex justify-content-between">



                <div class="btn-group">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Kategoria: {{ $p_category ? $p_category->name : 'Wszystko' }}
                    </button>
                    <ul class="dropdown-menu" style="">
                        @foreach ($all_categories as $c)
                            <li>
                                {{-- {{ print_r($c) }} --}}
                                <a class="dropdown-item" href="{{ route('admin.posts', ['category_id' => $c['id']]) }}">
                                    {{-- @foreach (array_reverse($c->parent_categories) as $element)
                                {{ $element->name }}
                                @endforeach --}}
                                    {{ $c['parent_categories_str'] }}
                                    {{-- Action --}}
                                </a>
                            </li>
                        @endforeach
                        {{-- <li><a class="dropdown-item" href="javascript:void(0);">Another action</a></li>
                    <li><a class="dropdown-item" href="javascript:void(0);">Something else here</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="javascript:void(0);">Separated link</a></li> --}}
                    </ul>
                </div>
                
                <div>

                    <a type="button" class="btn btn-primary me-auto mx-1" href="{{ route('admin.posts.add', ['parent_category_id' => $p_category->id ]) }}">
                        Dodaj post poniżej
                    </a>
                </div>

                {{-- <hr> --}}

                {{-- <div class="d-flex justify-content-between">
                <button type="button" class="btn btn-primary me-auto mx-1" data-bs-toggle="modal" data-bs-target="#editChild">
                    Dodaj post poniżej
                </button>
            </div> --}}
            </div>
        </div>

    </div>




    <!-- Borderless Table -->
    <div class="card mb-4">
        @if (count($posts) == 0)
            <div class="alert alert-info m-3 text-center" role="alert">
                Brak danych
            </div>
        @else
            {{-- <h5 class="card-header">Kategorie</h5> --}}
            <div class="table-responsive text-nowrap" style="min-height: 200px;">
                @foreach ($posts as $post)
                    {{ print_r($post) }}
                    <hr><br>
                @endforeach
            </div>
        @endif
    </div>
    <!--/ Borderless Table -->

</div>

@include('panel.auth.footer')
