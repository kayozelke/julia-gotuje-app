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

<div class="card border-light mb-3" style="max-width: 18rem;">
  <div class="card-header">Header</div>
  <div class="card-body">
    <h5 class="card-title">Light card title</h5>
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
  </div>
</div>

<div class="card border-light mb-3" style="max-width: 75%; margin: 0 auto;">
    <div class="card-header">Wasze ulubione kategorie przepisów</div>
    <div class="card-body">
        <div class="list-group list-group-flush">
            <a href="#" class="list-group-item list-group-item-action">Desery</a>
            <a href="#" class="list-group-item list-group-item-action">Dania wegetariańskie</a>
            <a href="#" class="list-group-item list-group-item-action">Dania wigilijne</a>
            <a href="#" class="list-group-item list-group-item-action">Zupy</a>
            <a href="#" class="list-group-item list-group-item-action">Pierogi</a>
        </div>
    </div>
</div>

{{-- <div class="card border-dark mb-3" style="max-width: 75%; margin: 0 auto;">
    <div class="card-header">Wasze ulubione kategorie przepisów</div>
    <div class="card-body text-dark">

    </div>
</div> --}}

@include('front.footer')
