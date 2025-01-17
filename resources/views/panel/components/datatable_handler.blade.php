{{-- table to use datatable at is called 'dataTableElement' --}}

{{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css"> --}}
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.1/css/dataTables.bootstrap5.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.2.1/js/dataTables.js"></script>
{{-- <script src="https://cdn.datatables.net/2.2.1/js/dataTables.bootstrap5.js"></script> --}}

<script>
    $(document).ready(function() {
        $('#dataTableElement').DataTable({
            "paging": true, 
            "ordering": true, 
            "searching": true,
            "order": [
                [0, "asc"]
            ], // default order by ID
            "info": true, // pagination info
            language: {
                url: '//cdn.datatables.net/plug-ins/2.2.1/i18n/pl.json',
                paginate: {
                    first: "↶",    
                    previous: "←",
                    next: "→",         
                    last: "↷",   
                }
            }
        });
    });
</script>