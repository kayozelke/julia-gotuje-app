@include('panel.auth.header')

<div class="container-xxl flex-grow-1 container-p-y">
    {{-- TOASTS --}}
    @include('panel.components.alert_toasts')
    <div class="card mb-4">
        <h5 class="card-header">Posty</h5>
        
        <div class="card-body m-1">
        </div>
    </div>


</div>

@include('panel.auth.footer')
