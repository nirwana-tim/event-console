<div class="page-heading">

    <h3>Sertifikat Saya</h3>
    <p class="page-subtitle">Unduh sertifikat setelah pembayaran diverifikasi admin.</p>

</div>

<div class="page-content">

<<<<<<< HEAD
    <?= flash_alert('success') ?>
    <?= flash_alert('error') ?>
    <?= flash_alert('info') ?>

=======
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f
    <div class="card">

        <div class="card-header">
            <h4 class="card-title mb-0">Daftar Sertifikat</h4>
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead>

                        <tr>
                            <th>Nomor</th>
                            <th>Event</th>
                            <th>Aksi</th>
                        </tr>

                    </thead>

                    <tbody>

<<<<<<< HEAD
                        <?php if (empty($certificates)) { ?>
=======
                        <?php if(empty($sertifikat)){ ?>
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f

                        <tr>
                            <td colspan="3">
                                <div class="empty-state">
                                    <i class="bi bi-award d-block mb-2"></i>
                                    Belum ada sertifikat
                                </div>
                            </td>
                        </tr>

                        <?php } ?>

<<<<<<< HEAD
                        <?php foreach ($certificates as $certificate) { ?>

                        <tr>

                            <td><strong><?= e($certificate->nomor_sertifikat) ?></strong></td>
                            <td><?= e($certificate->nama_event) ?></td>
                            <td>
                                <a href="<?= base_url('peserta/download/' . $certificate->id) ?>"
=======
                        <?php foreach($sertifikat as $s){ ?>

                        <tr>

                            <td><strong><?= html_escape($s->nomor_sertifikat) ?></strong></td>
                            <td><?= html_escape($s->nama_event) ?></td>
                            <td>
                                <a href="<?= base_url('peserta/download/'.$s->id) ?>"
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f
                                    class="btn btn-primary btn-sm">
                                    <i class="bi bi-download me-1"></i>
                                    Download
                                </a>
                            </td>

                        </tr>

                        <?php } ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>
