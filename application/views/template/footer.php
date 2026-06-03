</div>

<script src="<?= base_url('assets/compiled/js/app.js') ?>"></script>
<script src="<?= base_url('assets/static/js/components/dark.js') ?>"></script>

<<<<<<< HEAD
<script src="<?= base_url('assets/extensions/jquery/jquery.min.js') ?>"></script>
<script src="<?= base_url('assets/extensions/datatables.net/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js') ?>"></script>
=======
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f

<script>

$(document).ready(function(){

<<<<<<< HEAD
    ['#table-pembayaran', '#table-pendaftaran'].forEach(function(selector){
        var table = $(selector);

        if(table.length && $.fn.DataTable && table.find('tbody td[colspan]').length === 0){
=======
    ['#table-event', '#table-pembayaran', '#table-pendaftaran'].forEach(function(selector){
        var table = $(selector);

        if(table.length && table.find('tbody td[colspan]').length === 0){
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f
            table.DataTable();
        }
    });

});

</script>
</body>
</html>
