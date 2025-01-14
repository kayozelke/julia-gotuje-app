@include('panel.auth.header')

<div class="container-xxl flex-grow-1 container-p-y">
    {{-- TOASTS --}}
    @include('panel.components.alert_toasts')
    <div class="card mb-4">
        <h5 class="card-header">Przesyłanie obrazów</h5>
        {{-- ADD POST --}}
        <form action="{{ route('admin.posts.add.post') }}" method="POST" class="card-body m-1">
            @csrf
        </form>
    </div>
</div>

@include('panel.auth.footer')
