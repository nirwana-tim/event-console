<<<<<<< HEAD
<?= flash_alert('success') ?>
<?= flash_alert('error') ?>
<?= flash_alert('info') ?>
=======
<?php if($this->session->flashdata('success')){ ?>

<div class="alert alert-success">
    <i class="bi bi-check-circle me-2"></i>
    <?= $this->session->flashdata('success') ?>
</div>

<?php } ?>
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f

<div class="page-heading">

    <h3>Data Pembayaran</h3>
    <p class="page-subtitle">Verifikasi pembayaran dan generate sertifikat peserta.</p>

</div>

<div class="page-content">

    <div class="card">

        <div class="card-header">
            <h4 class="card-title mb-0">Pembayaran Masuk</h4>
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle" id="table-pembayaran">

                    <thead>

                        <tr>
                            <th>Peserta</th>
                            <th>Event</th>
                            <th>Bukti</th>
                            <th>Status</th>
                            <th>Sertifikat</th>
                            <th>Aksi</th>
                        </tr>

                    </thead>

                    <tbody>

<<<<<<< HEAD
                        <?php if (empty($payments)) { ?>
=======
                        <?php if(empty($pembayaran)){ ?>
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f

                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <i class="bi bi-credit-card d-block mb-2"></i>
                                    Belum ada pembayaran
                                </div>
                            </td>
                        </tr>

                        <?php } ?>

<<<<<<< HEAD
                        <?php foreach ($payments as $payment) { ?>

                        <tr>

                            <td><strong><?= e($payment->nama) ?></strong></td>
                            <td><?= e($payment->nama_event) ?></td>

                            <td>
                                <a href="<?= e(base_url('uploads/pembayaran/' . $payment->bukti_bayar)) ?>"
                                    target="_blank">
                                    <img class="table-img"
                                        src="<?= e(base_url('uploads/pembayaran/' . $payment->bukti_bayar)) ?>"
=======
                        <?php foreach($pembayaran as $p){ ?>

                        <tr>

                            <td><strong><?= html_escape($p->nama) ?></strong></td>
                            <td><?= html_escape($p->nama_event) ?></td>

                            <td>
                                <a href="<?= base_url('uploads/pembayaran/'.$p->bukti_bayar) ?>"
                                    target="_blank">
                                    <img class="table-img"
                                        src="<?= base_url('uploads/pembayaran/'.$p->bukti_bayar) ?>"
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f
                                        alt="Bukti pembayaran">
                                </a>
                            </td>

                            <td>
<<<<<<< HEAD
                                <?php if ($payment->status === 'pending') { ?>
=======
                                <?php if($p->status == 'pending'){ ?>
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f
                                    <span class="badge bg-warning">Pending</span>
                                <?php } else { ?>
                                    <span class="badge bg-success">Verified</span>
                                <?php } ?>
                            </td>

                            <td>
<<<<<<< HEAD
                                <?php if ($payment->sertifikat_id) { ?>
                                    <a href="<?= base_url('event/sertifikat/' . $payment->sertifikat_id) ?>"
=======
                                <?php if($p->sertifikat_id){ ?>
                                    <a href="<?= base_url('event/sertifikat/'.$p->sertifikat_id) ?>"
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f
                                        class="btn btn-primary btn-sm"
                                        target="_blank">
                                        <i class="bi bi-file-earmark-pdf me-1"></i>
                                        PDF
                                    </a>
                                <?php } else { ?>
                                    <span class="text-muted">Belum ada</span>
                                <?php } ?>
                            </td>

                            <td>
<<<<<<< HEAD
                                <?php if ($payment->status === 'pending') { ?>
                                    <a href="<?= base_url('event/approve/' . $payment->id) ?>"
=======
                                <?php if($p->status == 'pending'){ ?>
                                    <a href="<?= base_url('event/approve/'.$p->id) ?>"
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f
                                        class="btn btn-success btn-sm"
                                        onclick="return confirm('Approve pembayaran ini?')">
                                        <i class="bi bi-check2-circle me-1"></i>
                                        Approve
                                    </a>
                                <?php } else { ?>
                                    <span class="badge bg-light-success text-success">Selesai</span>
                                <?php } ?>
                            </td>

                        </tr>

                        <?php } ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>
