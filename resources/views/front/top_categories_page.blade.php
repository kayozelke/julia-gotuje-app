@include('front.header')

<!-- # site-content
        ================================================== -->
<div id="content" class="s-content s-content--page">

    <div class="row entry-wrap">
        <div class="column lg-12">

            <article class="entry">

                <header class="entry__header entry__header--narrower">

                    <h1 class="entry__title">
                        Style Guide.
                    </h1>

                </header>

                <div class="row u-add-bottom">

                    <div class="column lg-12">

                        <h3>Tables</h3>
                        <p>Be sure to use properly formed table markup with <code>&lt;thead&gt;</code> and
                            <code>&lt;tbody&gt;</code> when building a <code>table</code>.</p>

                        <div class="table-responsive">

                            <table>
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Age</th>
                                        <th>Sex</th>
                                        <th>Location</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>William J. Seymour</td>
                                        <td>34</td>
                                        <td>Male</td>
                                        <td>Azusa Street</td>
                                    </tr>
                                    <tr>
                                        <td>Jennie Evans Moore</td>
                                        <td>30</td>
                                        <td>Female</td>
                                        <td>Azusa Street</td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>

                    </div>

                </div> <!-- end row -->

            </article> <!-- end entry -->

        </div>
    </div> <!-- end entry-wrap -->

</div> <!-- end s-content -->

@include('front.footer')
