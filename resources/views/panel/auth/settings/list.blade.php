@include('panel.auth.header')

<!-- Hoverable Table rows -->
<div class="card">
    <h5 class="card-header">Hoverable rows</h5>
    <div class="table-responsive text-nowrap">
        <table class="table table-hover">
            <thead>
                <tr>
                    {{-- Key --}}
                    <th>Ustawienie</th>
                    {{-- Value --}}
                    <th>Wartość</th>
                    {{-- Description --}}
                    <th>Opis</th>
                    {{-- Update at --}}
                    <th>Ostatnio zmodyfikowany</th>
                    {{-- Updated by --}}
                    <th>Zmodyfikowany przez</th>
                    {{-- Akcje --}}
                    <th>Akcje</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @foreach ($settings as $setting)
                    <tr>
                        {{-- Key --}}
                        <td><strong>{{ $setting->key }}</strong></td>
                        {{-- Value --}}
                        <td>{{ $setting->value }}</td>
                        {{-- Description --}}
                        <td>{{ $setting->description }}</td>
                        {{-- Update at --}}
                        <td>{{ $setting->updated_at ? $setting->updated_at->format('Y-m-d H:i:s') : 'N/A' }}</td>
                        {{-- Updated by --}}
                        <td>
                            {{-- @if ($setting->updated_by)
                                {{ \App\Models\User::find($setting->updated_by)->first_name ?? 'Nieznany' }}
                            @else
                                N/A
                            @endif --}}
                            {{ $setting->updatedByUser->first_name ?? 'N/A' }} {{ $setting->updatedByUser->last_name ?? '' }}
                        </td>
                        {{-- Akcje --}}
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('admin.settings.update', ['id' => $setting->id]) }}">
                                        <i class="bx bx-edit-alt me-1"></i> Edytuj
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!--/ Hoverable Table rows -->


@include('panel.auth.footer')
