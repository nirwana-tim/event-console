</div>

<script src="<?= base_url('assets/compiled/js/app.js') ?>"></script>
<script src="<?= base_url('assets/static/js/components/dark.js') ?>"></script>

<script src="<?= base_url('assets/extensions/jquery/jquery.min.js') ?>"></script>
<script src="<?= base_url('assets/extensions/datatables.net/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js') ?>"></script>

<script>

$(document).ready(function(){

    ['#table-payments', '#table-registrations'].forEach(function(selector){
        var table = $(selector);

        if(table.length && $.fn.DataTable && table.find('tbody td[colspan]').length === 0){
            table.DataTable();
        }
    });

});

</script>
</body>
</html>
