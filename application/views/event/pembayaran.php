<?php if($this->session->flashdata('success')){ ?>

<div class="alert alert-success">
    <i class="bi bi-check-circle me-2"></i>
    <?= $this->session->flashdata('success') ?>
</div>

<?php } ?>

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

                        <?php if(empty($pembayaran)){ ?>

                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <i class="bi bi-credit-card d-block mb-2"></i>
                                    Belum ada pembayaran
                                </div>
                            </td>
                        </tr>

                        <?php } ?>

                        <?php foreach($pembayaran as $p){ ?>

                        <tr>

                            <td><strong><?= html_escape($p->nama) ?></strong></td>
                            <td><?= html_escape($p->nama_event) ?></td>

                            <td>
                                <a href="<?= base_url('uploads/pembayaran/'.$p->bukti_bayar) ?>"
                                    target="_blank">
                                    <img class="table-img"
                                        src="<?= base_url('uploads/pembayaran/'.$p->bukti_bayar) ?>"
                                        alt="Bukti pembayaran">
                                </a>
                            </td>

                            <td>
                                <?php if($p->status == 'pending'){ ?>
                                    <span class="badge bg-warning">Pending</span>
                                <?php } else { ?>
                                    <span class="badge bg-success">Verified</span>
                                <?php } ?>
                            </td>

                            <td>
                                <?php if($p->sertifikat_id){ ?>
                                    <a href="<?= base_url('event/sertifikat/'.$p->sertifikat_id) ?>"
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
                                <?php if($p->status == 'pending'){ ?>
                                    <a href="<?= base_url('event/approve/'.$p->id) ?>"
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
