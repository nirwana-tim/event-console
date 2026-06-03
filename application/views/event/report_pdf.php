<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Event Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #444; padding: 8px; text-align: left; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>
<h2>Event Report</h2>

<table>

<tr>
    <th>No</th>
    <th>Event Name</th>
    <th>Date</th>
    <th>Location</th>
</tr>

<?php $number = 1; foreach ($events as $event) { ?>

<tr>
    <td><?= e($number++) ?></td>
    <td><?= e($event->nama_event) ?></td>
    <td><?= e(app_date($event->tanggal)) ?></td>
    <td><?= e($event->lokasi) ?></td>
</tr>

<?php } ?>

</table>
</body>
</html>
