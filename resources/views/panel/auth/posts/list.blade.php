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

                    <a type="button" class="btn btn-primary me-auto mx-1"
                        href="{{ route('admin.posts.add', $p_category ? ['parent_category_id' => $p_category->id] : '') }}">
                        Dodaj post
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
            <div class="table-responsive text-nowrap mx-3 my-2" style="min-height: 200px;">
                <table class="table table-borderless table-hover" id="dataTableElement">
                    <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center">Nazwa</th>
                            <th class="text-center">Typ</th>
                            <th class="text-center">Miniatura</th>
                            <th class="text-center">Dodano</th>
                            <th class="text-center">Zmodyfikowano</th>
                            <th class="text-center">Podgląd</th>
                            {{-- <th>Akcje</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($posts as $post)
                            <tr>
                                <td class="text-center">
                                    {{ $post->id }}
                                </td>
                                <td>
                                    {{-- <a href="#" class="href"> --}}
                                    <a href="{{ route('admin.posts.show', ['id' => $post->id]) }}">
                                        <strong>{{ $post->title }}</strong>
                                    </a>
                                </td>
                                <td class="text-center">
                                    @if ($post->template_type == 'recipe')
                                        Przepis
                                    @elseif ($post->template_type == 'default')
                                        Zwykły wpis
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="p-1">
                                        {{-- <img class="card-img-top" src="{{ $post_image->image->file_location }}"> --}}
                                        @if ( $post->prioritized_image != null)
                                            <img class="rounded" src="{{ $post->prioritized_image->file_location }}"
                                                style="max-width: 100px; max-height: 100px;"
                                                >
                                        @else
                                            <small>Brak obrazów</small>
                                        @endif
                                    </div>
                                </td>
                                <td class="text-center">
                                    <small>
                                        {{ $post->created_at }} <br>
                                        przez {{ $post->createdByUser->first_name ?? 'N/A' }} {{ $post->createdByUser->last_name ?? '' }}
                                    </small>
                                </td>
                                <td class="text-center">
                                    <small>
                                        {{ $post->updated_at }} <br>
                                        przez {{ $post->updatedByUser->first_name ?? 'N/A' }} {{ $post->updatedByUser->last_name ?? '' }}
                                    </small>
                                </td>
                                <td class="text-center">
                                    <a href="/{{ $post->url }}" class="btn btn-sm btn-primary">
                                        <i class='bx bx-link-external'></i>
                                    </a>
                                </td>
                                {{-- <td>
                                    <div class="dropdown position-static">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                    data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('admin.post.update', ['id' => $post->id]) }}"><i
                                            class="bx bx-edit-alt me-1"></i> Edytuj</a>
                                    <a class="dropdown-item" href="{{ route('admin.post.delete', ['id' => $post->id]) }}"><i
                                            class="bx bx-trash me-1"></i> Usuń</a>
                                </div>
                                    </div>
                                </td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    {{-- @foreach ($posts as $post)
        {{ print_r($post) }}
        <hr><br>
    @endforeach --}}
    <!--/ Borderless Table -->

</div>


@include('panel.auth.footer')

@include('panel.components.datatable_handler')
