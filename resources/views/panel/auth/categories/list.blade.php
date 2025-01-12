{{-- DATATABLES - TEST ONLY --}}
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />

@include('panel.auth.header')

<div class="container-xxl flex-grow-1 container-p-y">
    {{--  --}}
    @include('panel.components.alert_toasts')

    <div class="card mb-4">
        <h5 class="card-header">Kategorie</h5>
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
                            <a href="{{ route('admin.categories') }}">Wszystko</a>
                        </li>
                        

                        @foreach (array_reverse($parent_categories) as $par_category)
                            <li class="breadcrumb-item @if ($par_category->id == $current_category_id) active @endif">
                                <a href="{{ route('admin.categories', ['id' => $par_category->id]) }}">{{ $par_category->name }}</a>
                            </li>
                            {{-- <li class="breadcrumb-item ">
                                <a href="{{ route('admin.categories', ['id' => $current_category_id]) }}">{{ $par_category->name }}</a>
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
            <!-- Basic Breadcrumb -->
            
            <hr>

            <div class="d-flex justify-content-between">
                <button type="button" class="btn btn-primary me-auto mx-1" data-bs-toggle="modal" data-bs-target="#editChild">
                    Dodaj kategorię poniżej
                </button>

                @if ($p_category)
                    <button type="button" class="btn btn-secondary me-auto mx-1" data-bs-toggle="modal" data-bs-target="#editSelf">
                        Edytuj bieżącą kategorię
                    </button>
                    <a type="button" class="btn btn-danger mx-1" href="{{ route('admin.categories.delete', ['id' => $current_category_id]) }}">
                        Usuń bieżącą kategorię
                    </a>
                @endif
            </div>

            <!-- Modal -->
            <div class="modal fade" id="editChild" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalCenterTitle">Dodawanie nowej kategorii</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('admin.categories.add') }}"
                                method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nazwa kategorii</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                    {{-- <input type="hidden" class="form-control" id="update_id" name="update_id" value=""> --}}
                                    <input type="hidden" class="form-control" id="parent_category_id"
                                        name="parent_category_id" value="{{ $current_category_id }}">

                                </div>
                                <button type="submit" class="btn btn-primary">Zapisz</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal -->

            @if ($p_category)
                <!-- Modal -->
                <div class="modal fade" id="editSelf" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalCenterTitle">Edycja kategorii</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('admin.categories.add') }}"
                                    method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nazwa kategorii</label>
                                        <input type="text" class="form-control" id="name" name="name" required value="{{$p_category->name}}">
                                        <input type="hidden" class="form-control" id="update_id" name="update_id" value="{{$current_category_id}}">
                                        {{-- <input type="hidden" class="form-control" id="parent_category_id"
                                            name="parent_category_id" value="{{ $current_category_id }}"> --}}

                                    </div>
                                    <button type="submit" class="btn btn-primary">Zapisz</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal -->
            @endif

        </div>
    </div>



    <!-- Borderless Table -->
    <div class="card mb-4">
        @if (count($categories) == 0)
            <div class="alert alert-info m-3 text-center" role="alert">
                Brak danych
            </div>
        @else
            {{-- <h5 class="card-header">Kategorie</h5> --}}
            <div class="table-responsive text-nowrap" style="min-height: 200px;">
                <table class="table table-borderless table-hover" id="myTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nazwa</th>
                            <th>Utworzono</th>
                            <th>Zmodyfikowano</th>
                            <th>Zmodyfikowano przez</th>
                            <th>Akcje</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($categories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>
                                    <a href="{{ route('admin.categories', ['id' => $category->id]) }}"
                                        class="href">
                                        <strong>{{ $category->name }}</strong>
                                    </a>
                                </td>
                                <td>{{ $category->created_at }}</td>
                                <td>{{ $category->updated_at }}</td>
                                <td>{{ $category->updatedByUser->first_name ?? 'N/A' }} {{ $category->updatedByUser->last_name ?? '' }}</td>
                                <td>
                                    <div class="dropdown position-static">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ route('admin.categories.update', ['id' => $category->id]) }}"><i
                                                    class="bx bx-edit-alt me-1"></i> Edytuj</a>
                                            <a class="dropdown-item" href="{{ route('admin.categories.delete', ['id' => $category->id]) }}"><i
                                                    class="bx bx-trash me-1"></i>
                                                Usuń</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        
                    </tbody>
                </table>
            </div>
        @endif
    </div>
    <!--/ Borderless Table -->

</div>



@include('panel.auth.footer')


{{-- DATATABLES TEST --}}
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
<script>
    $(document).ready(function() {
        $('#myTable').DataTable({
            "paging": false, // Włącz paginację
            "ordering": true, // Włącz sortowanie
            "searching": false, // Włącz wyszukiwanie
            "order": [
                [0, "asc"]
            ], // Domyślne sortowanie po ID
            "info": false // Wyłącza informacje o paginacji
        });
    });
</script>
