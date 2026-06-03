<?= flash_alert('success') ?>
<?= flash_alert('error') ?>
<?= flash_alert('info') ?>

<div class="page-heading">

    <div class="d-flex justify-content-between align-items-center">

        <div>
            <h3>Data Event</h3>
            <p class="page-subtitle">Kelola event, peserta, dan laporan.</p>
        </div>

        <div class="btn-group-wrap">

            <a href="<?= base_url('event/pdf') ?>"
                class="btn btn-outline-danger">
                <i class="bi bi-file-earmark-pdf me-1"></i>
                PDF Event
            </a>

            <a href="<?= base_url('event/excel') ?>"
                class="btn btn-outline-success">
                <i class="bi bi-file-earmark-excel me-1"></i>
                Excel Event
            </a>

            <a href="<?= base_url('event/tambah') ?>"
                class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i>
                Tambah
            </a>

        </div>

    </div>

</div>

<div class="page-content">

    <div class="card">

        <div class="card-header">
            <h4 class="card-title mb-0">Daftar Event</h4>
        </div>

        <div class="card-body">

            <form method="get" class="mb-4">

                <div class="row g-2">

                    <div class="col-md-5">

                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text"
                                name="keyword"
                                class="form-control"
                                value="<?= e($keyword) ?>"
                                placeholder="Cari event...">
                        </div>

                    </div>

                    <div class="col-md-2">

                        <button class="btn btn-primary w-100">
                            Cari
                        </button>

                    </div>

                </div>

            </form>

            <div class="table-responsive">

                <table id="table-event" class="table table-hover align-middle">

                    <thead>

                        <tr>
                            <th>No</th>
                            <th>Banner</th>
                            <th>Nama Event</th>
                            <th>Tanggal</th>
                            <th>Lokasi</th>
                            <th>Aksi</th>
                        </tr>

                    </thead>

                    <tbody>

                        <?php if (empty($events)) { ?>

                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <i class="bi bi-calendar-x d-block mb-2"></i>
                                    Tidak ada data event
                                </div>
                            </td>
                        </tr>

                        <?php } ?>

                        <?php $number = isset($offset) ? $offset + 1 : 1; ?>

                        <?php foreach ($events as $event) { ?>

                        <tr>

                            <td><?= e($number++) ?></td>

                            <td>
                                <img class="table-img"
                                    src="<?= e(base_url('uploads/banner/' . $event->banner)) ?>"
                                    alt="<?= e($event->nama_event) ?>"
                                    onerror="this.src='<?= base_url('assets/static/images/samples/error-404.svg') ?>'">
                            </td>

                            <td>
                                <strong><?= e($event->nama_event) ?></strong>
                            </td>
                            <td><?= e(app_date($event->tanggal)) ?></td>
                            <td><?= e($event->lokasi) ?></td>
                            <td>

                                <div class="btn-group-wrap">

                                    <a href="<?= base_url('event/pendaftaran/' . $event->id) ?>"
                                        class="btn btn-info btn-sm">
                                        <i class="bi bi-people me-1"></i>
                                        Peserta
                                    </a>

                                    <a href="<?= base_url('event/edit/' . $event->id) ?>"
                                        class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil-square me-1"></i>
                                        Edit
                                    </a>

                                    <a href="<?= base_url('event/hapus/' . $event->id) ?>"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Hapus event ini?')">
                                        <i class="bi bi-trash me-1"></i>
                                        Hapus
                                    </a>

                                </div>

                            </td>

                        </tr>

                        <?php } ?>

                    </tbody>

                </table>

            </div>

            <?= $this->pagination->create_links(); ?>

        </div>

    </div>

</div>
