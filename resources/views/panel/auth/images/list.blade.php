
@include('panel.auth.header')

<div class="container-xxl flex-grow-1 container-p-y">
    {{--  --}}
    @include('panel.components.alert_toasts')

    <div class="card mb-4">
        <h5 class="card-header">Obrazy</h5>
        <div class="card-body m-1">
            <div class="d-flex justify-content-between">
                <a type="button" class="btn btn-primary me-auto mx-1" href="{{ route('admin.images.add') }}">
                    Prześlij obrazy
                </a>
            </div>
        </div>
    </div>


</div>

@include('panel.auth.footer')

