<div class="table-responsive">
    <table class="table table-striped table-hover align-middle">
        <thead>
            <tr>
                <th>Zdjęcie</th>
                <th>Tytuł</th>
                <th>Opis</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($images as $image)
                <tr>
                    <td class="d-flex justify-content-center">
                        <a href="{{ route('admin.images.show', ['id' => $image->id]) }}">
                            <img src="{{ $image->file_location }}" alt="{{ $image->title }}" style="min-width: 100px; max-width: 150px; height: auto;">
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('admin.images.show', ['id' => $image->id]) }}">
                            <strong>{{ $image->title }}</strong>
                        </a>
                    </td>
                    <td>{{ $image->label }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $items->links() }}
</div>
