<h2>Laporan Event</h2>

<table border="1" width="100%" cellspacing="0" cellpadding="5">

<tr>
    <th>No</th>
    <th>Nama Event</th>
    <th>Tanggal</th>
</tr>

<?php $no=1; foreach($event as $e){ ?>

<tr>
    <td><?= $no++ ?></td>
    <td><?= $e->nama_event ?></td>
    <td><?= $e->tanggal ?></td>
</tr>

<?php } ?>

</table>