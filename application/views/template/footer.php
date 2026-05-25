</div>

<script src="<?= base_url('assets/compiled/js/app.js') ?>"></script>
<script src="<?= base_url('assets/static/js/components/dark.js') ?>"></script>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>

$(document).ready(function(){

    ['#table-event', '#table-pembayaran', '#table-pendaftaran'].forEach(function(selector){
        var table = $(selector);

        if(table.length && table.find('tbody td[colspan]').length === 0){
            table.DataTable();
        }
    });

});

</script>
</body>
</html>
