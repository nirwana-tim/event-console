<div class="page-heading">

    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h3>Data Pendaftaran Peserta</h3>
            <p class="page-subtitle">Pantau peserta berdasarkan event dan status pembayaran.</p>
        </div>
    </div>

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
            <h4 class="card-title mb-0">Filter Data</h4>
        </div>

        <div class="card-body">

            <form method="get" class="mb-4">

                <div class="row g-2 align-items-end">

                    <div class="col-md-5">

                        <label>Filter Event</label>

                        <select name="event_id" class="form-select">

                            <option value="">Semua Event</option>

<<<<<<< HEAD
                            <?php foreach ($events as $event) { ?>

                                <option value="<?= e($event->id) ?>"
                                    <?= (int) $selected_event_id === (int) $event->id ? 'selected' : '' ?>>
                                    <?= e($event->nama_event) ?>
=======
                            <?php foreach($events as $e){ ?>

                                <option value="<?= $e->id ?>"
                                    <?= $selected_event_id == $e->id ? 'selected' : '' ?>>
                                    <?= html_escape($e->nama_event) ?>
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f
                                </option>

                            <?php } ?>

                        </select>

                    </div>

                    <div class="col-md-5">

                        <div class="btn-group-wrap">

                            <button class="btn btn-primary">
                                <i class="bi bi-funnel me-1"></i>
                                Tampilkan
                            </button>

                            <?php if($selected_event_id){ ?>

                                <a href="<?= base_url('event/export_peserta/'.$selected_event_id) ?>"
                                    class="btn btn-success">
                                    <i class="bi bi-file-earmark-excel me-1"></i>
                                    Export Excel
                                </a>

                            <?php } ?>

                        </div>

                    </div>

                </div>

            </form>

            <div class="table-responsive">

                <table class="table table-hover align-middle" id="table-pendaftaran">

                    <thead>

                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Event</th>
                            <th>No HP</th>
                            <th>Instansi</th>
                            <th>Team</th>
                            <th>Status Daftar</th>
                            <th>Status Bayar</th>
                        </tr>

                    </thead>

                    <tbody>

<<<<<<< HEAD
                        <?php if (empty($registrations)) { ?>
=======
                        <?php if(empty($pendaftaran)){ ?>
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f

                        <tr>
                            <td colspan="8">
                                <div class="empty-state">
                                    <i class="bi bi-people d-block mb-2"></i>
                                    Belum ada pendaftaran
                                </div>
                            </td>
                        </tr>

                        <?php } ?>

<<<<<<< HEAD
                        <?php foreach ($registrations as $registration) { ?>

                        <tr>

                            <td><strong><?= e($registration->nama) ?></strong></td>
                            <td><?= e($registration->email) ?></td>
                            <td><?= e($registration->nama_event) ?></td>
                            <td><?= e($registration->no_hp) ?></td>
                            <td><?= e($registration->instansi) ?></td>
                            <td><?= e($registration->team) ?></td>
                            <td>
                                <span class="badge bg-<?= status_badge_class($registration->status) ?>">
                                    <?= e($registration->status) ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($registration->status_pembayaran === 'verified') { ?>
                                    <span class="badge bg-success">verified</span>
                                <?php } elseif ($registration->status_pembayaran === 'pending') { ?>
=======
                        <?php foreach($pendaftaran as $p){ ?>

                        <tr>

                            <td><strong><?= html_escape($p->nama) ?></strong></td>
                            <td><?= html_escape($p->email) ?></td>
                            <td><?= html_escape($p->nama_event) ?></td>
                            <td><?= html_escape($p->no_hp) ?></td>
                            <td><?= html_escape($p->instansi) ?></td>
                            <td><?= html_escape($p->team) ?></td>
                            <td>
                                <span class="badge bg-<?= $p->status == 'approved' ? 'success' : 'warning' ?>">
                                    <?= html_escape($p->status) ?>
                                </span>
                            </td>
                            <td>
                                <?php if($p->status_pembayaran == 'verified'){ ?>
                                    <span class="badge bg-success">verified</span>
                                <?php } elseif($p->status_pembayaran == 'pending'){ ?>
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f
                                    <span class="badge bg-warning">pending</span>
                                <?php } else { ?>
                                    <span class="badge bg-secondary">belum upload</span>
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
