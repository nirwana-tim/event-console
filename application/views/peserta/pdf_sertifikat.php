<<<<<<< HEAD
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Sertifikat</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #25396f; }
        .certificate { border: 8px solid #435ebe; height: 500px; padding: 48px; text-align: center; }
        h1 { font-size: 42px; margin: 0 0 24px; }
        h2 { font-size: 28px; margin: 18px 0; }
        h3 { font-size: 18px; font-weight: normal; margin: 0; }
        p { font-size: 16px; margin: 16px 0; }
        .number { margin-top: 56px; }
    </style>
</head>
<body>
<div class="certificate">
=======
<div style="text-align:center; margin-top:150px;">
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f

    <h1>SERTIFIKAT</h1>

    <h3>Diberikan Kepada</h3>

    <h1>
<<<<<<< HEAD
        <?= e($certificate->nama) ?>
    </h1>

    <p>Telah mengikuti event</p>

    <h2>
        <?= e($certificate->nama_event) ?>
    </h2>

    <p class="number">
        Nomor Sertifikat:
        <?= e($certificate->nomor_sertifikat) ?>
    </p>

</div>
</body>
</html>
=======
        <?= $sertifikat->nama ?>
    </h1>

    <p>

        Telah mengikuti event

    </p>

    <h2>
        <?= $sertifikat->nama_event ?>
    </h2>

    <br><br>

    <p>
        Nomor Sertifikat:
        <?= $sertifikat->nomor_sertifikat ?>
    </p>

</div>
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f
