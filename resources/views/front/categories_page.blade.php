@include('front.header')
{{-- <div class="container-lg">
    <table class="table">
        <caption>List of users</caption>
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">First</th>
                <th scope="col">Last</th>
                <th scope="col">Handle</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row">1</th>
                <td>Mark</td>
                <td>Otto</td>
                <td>@mdo</td>
            </tr>
            <tr>
                <th scope="row">2</th>
                <td>Jacob</td>
                <td>Thornton</td>
                <td>@fat</td>
            </tr>
            <tr>
                <th scope="row">3</th>
                <td>Larry</td>
                <td>the Bird</td>
                <td>@twitter</td>
            </tr>
        </tbody>
    </table>
</div> --}}

<div class="card border-dark mb-3" style="max-width: 75%; margin: 0 auto;">
    <div class="card-header">Wasze ulubione kategorie przepisów</div>
    <div class="card-body text-dark">
        {{-- <h5 class="card-title">Dark card title</h5> --}}
        {{-- <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p> --}}
        {{-- <ul class="list-group list-group-flush">
            <li class="list-group-item d-flex align-items-center">
                <span class="badge badge-light mr-2">&#11088;</span>
                Desery
            </li>
            <li class="list-group-item d-flex align-items-center">
                <span class="badge badge-light mr-2">&#11088;</span>
                Dania wegetariańskie
            </li>
            <li class="list-group-item d-flex align-items-center">
                <span class="badge badge-light mr-2">&#11088;</span>
                Potrawy wigilijne
            </li>
        </ul> --}}

        <div class="list-group list-group-flush">
            <a href="#" class="list-group-item list-group-item-action">A second link item</a>
            <a href="#" class="list-group-item list-group-item-action">A third link item</a>
            <a href="#" class="list-group-item list-group-item-action">A fourth link item</a>
            <a class="list-group-item list-group-item-action disabled" aria-disabled="true">A disabled link item</a>
        </div>
    </div>
</div>

@include('front.footer')
