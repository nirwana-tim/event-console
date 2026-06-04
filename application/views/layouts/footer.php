</div>

<footer>
    <div class="footer clearfix mb-0 text-muted">
        <div class="float-start">
            <p><?= date('Y') ?> &copy; EventConsole</p>
        </div>
        <div class="float-end">
            <p>Crafted with <span class="text-danger"><i class="bi bi-heart-fill icon-mid"></i></span> by Antigravity</p>
        </div>
    </div>
</footer>

</div>
</div>

<script src="<?= base_url('mazer/dist/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') ?>"></script>
<script src="<?= base_url('mazer/dist/assets/compiled/js/app.js') ?>"></script>
<script src="<?= base_url('mazer/dist/assets/static/js/components/dark.js') ?>"></script>

<script src="<?= base_url('mazer/dist/assets/extensions/jquery/jquery.min.js') ?>"></script>
<script src="<?= base_url('mazer/dist/assets/extensions/datatables.net/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('mazer/dist/assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js') ?>"></script>

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
