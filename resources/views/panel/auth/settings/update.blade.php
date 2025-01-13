@include('panel.auth.header')

<div class="container-xxl flex-grow-1 container-p-y">
    {{-- Toasts --}}
    @include('panel.components.alert_toasts')

    <form action="{{ route('admin.settings.update', ['id' => $setting->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Ukryte pole na ID ustawienia -->
        <input type="hidden" name="id" value="{{ $setting->id }}">

        {{-- Nagłówek z nazwą ustawienia --}}
        <div class="card mb-4">
            <h5 class="card-header">Ustawienia dla: {{ $setting->key }}</h5>
            <div class="card-body">
                {{-- Wartość ustawienia --}}
                <div class="mb-3">
                    <label for="value" class="form-label">Wartość dla pola {{ $setting->key }}</label>
                    <input type="text" name="value" class="form-control" id="value"
                        placeholder="Wprowadź nową wartość" value="{{ old('value', $setting->value) }}"
                        aria-describedby="valueHelp" required>
                    <div id="valueHelp" class="form-text">
                        Wprowadź wartość, która zostanie przypisana do tego ustawienia.
                    </div>
                </div>
            </div>
        </div>

        {{-- Opis ustawienia --}}
        <div class="card mb-4">
            <div class="card-body">
                <label for="description" class="form-label">Opis ustawienia</label>
                <textarea name="description" class="form-control" id="description" rows="3" required>{{ old('description', $setting->description) }}</textarea>
            </div>
        </div>

        {{-- Przyciski akcji --}}
        {{-- <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-primary">Zapisz</button>
            <a class="btn btn-secondary" href="{{ route('admin.settings') }}">Powrót</a>
        </div> --}}
        <button type="submit" class="btn btn-primary">Zapisz</button>
        <a class="btn btn-secondary" href="{{ route('admin.settings') }}">Powrót</a>
    </form>
</div>

@include('panel.auth.footer')
