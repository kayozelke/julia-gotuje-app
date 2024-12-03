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

<div class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading">Panel heading</div>
  <div class="panel-body">
    <p>...</p>
  </div>

  <!-- List group -->
  <ul class="list-group">
    <li class="list-group-item">Cras justo odio</li>
    <li class="list-group-item">Dapibus ac facilisis in</li>
    <li class="list-group-item">Morbi leo risus</li>
    <li class="list-group-item">Porta ac consectetur ac</li>
    <li class="list-group-item">Vestibulum at eros</li>
  </ul>
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
