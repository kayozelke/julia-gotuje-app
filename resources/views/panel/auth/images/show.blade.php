@include('panel.auth.header')

<div class="container-xxl flex-grow-1 container-p-y">
    {{-- TOASTS --}}
    @include('panel.components.alert_toasts')

    <div class="card mb-4">
        <h5 class="card-header">{{ $image->title }}</h5>

        <div class="card-body">
          <a href="{{ $image->file_location }}"><img src="{{ $image->file_location }}" alt="{{ $image->title }}" width="300"></a>
        </div>


    </div>


</div>

@include('panel.auth.footer')


