<div class="page-heading">

    <h3>Sertifikat Saya</h3>
    <p class="page-subtitle">Unduh sertifikat setelah pembayaran diverifikasi admin.</p>

</div>

<div class="page-content">

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

                        <?php if(empty($sertifikat)){ ?>

                        <tr>
                            <td colspan="3">
                                <div class="empty-state">
                                    <i class="bi bi-award d-block mb-2"></i>
                                    Belum ada sertifikat
                                </div>
                            </td>
                        </tr>

                        <?php } ?>

                        <?php foreach($sertifikat as $s){ ?>

                        <tr>

                            <td><strong><?= html_escape($s->nomor_sertifikat) ?></strong></td>
                            <td><?= html_escape($s->nama_event) ?></td>
                            <td>
                                <a href="<?= base_url('peserta/download/'.$s->id) ?>"
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
