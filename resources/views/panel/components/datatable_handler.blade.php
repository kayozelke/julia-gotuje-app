{{-- table to use datatable at is called 'dataTableElement' --}}

<link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
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
                url: '//cdn.datatables.net/plug-ins/2.2.1/i18n/pl.json'
            }
        });
    });
</script>