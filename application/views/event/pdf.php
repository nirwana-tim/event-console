<<<<<<< HEAD
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Event</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #444; padding: 8px; text-align: left; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>
<h2>Laporan Event</h2>

<table>
=======
<h2>Laporan Event</h2>

<table border="1" width="100%" cellspacing="0" cellpadding="5">
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f

<tr>
    <th>No</th>
    <th>Nama Event</th>
    <th>Tanggal</th>
<<<<<<< HEAD
    <th>Lokasi</th>
</tr>

<?php $number = 1; foreach ($events as $event) { ?>

<tr>
    <td><?= e($number++) ?></td>
    <td><?= e($event->nama_event) ?></td>
    <td><?= e(app_date($event->tanggal)) ?></td>
    <td><?= e($event->lokasi) ?></td>
=======
</tr>

<?php $no=1; foreach($event as $e){ ?>

<tr>
    <td><?= $no++ ?></td>
    <td><?= $e->nama_event ?></td>
    <td><?= $e->tanggal ?></td>
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f
</tr>

<?php } ?>

<<<<<<< HEAD
</table>
</body>
</html>
=======
</table>
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f
