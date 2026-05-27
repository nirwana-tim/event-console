<?= flash_alert('success') ?>
<?= flash_alert('error') ?>
<?= flash_alert('info') ?>

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

                        <?php if (empty($payments)) { ?>

                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <i class="bi bi-credit-card d-block mb-2"></i>
                                    Belum ada pembayaran
                                </div>
                            </td>
                        </tr>

                        <?php } ?>

                        <?php foreach ($payments as $payment) { ?>

                        <tr>

                            <td><strong><?= e($payment->nama) ?></strong></td>
                            <td><?= e($payment->nama_event) ?></td>

                            <td>
                                <a href="<?= e(base_url('uploads/pembayaran/' . $payment->bukti_bayar)) ?>"
                                    target="_blank">
                                    <img class="table-img"
                                        src="<?= e(base_url('uploads/pembayaran/' . $payment->bukti_bayar)) ?>"
                                        alt="Bukti pembayaran">
                                </a>
                            </td>

                            <td>
                                <?php if ($payment->status === 'pending') { ?>
                                    <span class="badge bg-warning">Pending</span>
                                <?php } else { ?>
                                    <span class="badge bg-success">Verified</span>
                                <?php } ?>
                            </td>

                            <td>
                                <?php if ($payment->sertifikat_id) { ?>
                                    <a href="<?= base_url('event/sertifikat/' . $payment->sertifikat_id) ?>"
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
                                <?php if ($payment->status === 'pending') { ?>
                                    <a href="<?= base_url('event/approve/' . $payment->id) ?>"
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
