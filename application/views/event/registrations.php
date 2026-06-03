<div class="page-heading">

    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h3>Participant Registration Data</h3>
            <p class="page-subtitle">Monitor participants by event and payment status.</p>
        </div>
    </div>

</div>

<div class="page-content">

    <?= flash_alert('success') ?>
    <?= flash_alert('error') ?>
    <?= flash_alert('info') ?>

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

                            <option value="">All Events</option>

                            <?php foreach ($events as $event) { ?>

                                <option value="<?= e($event->id) ?>"
                                    <?= (int) $selected_event_id === (int) $event->id ? 'selected' : '' ?>>
                                    <?= e($event->nama_event) ?>
                                </option>

                            <?php } ?>

                        </select>

                    </div>

                    <div class="col-md-5">

                        <div class="btn-group-wrap">

                            <button class="btn btn-primary">
                                <i class="bi bi-funnel me-1"></i>
                                Show
                            </button>

                            <?php if($selected_event_id){ ?>

                                <a href="<?= base_url('event/export_participants/'.$selected_event_id) ?>"
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

                <table class="table table-hover align-middle" id="table-registrations">

                    <thead>

                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Event</th>
                            <th>Phone</th>
                            <th>Institution</th>
                            <th>Team</th>
                            <th>Registration Status</th>
                            <th>Payment Status</th>
                        </tr>

                    </thead>

                    <tbody>

                        <?php if (empty($registrations)) { ?>

                        <tr>
                            <td colspan="8">
                                <div class="empty-state">
                                    <i class="bi bi-people d-block mb-2"></i>
                                    No registrations yet
                                </div>
                            </td>
                        </tr>

                        <?php } ?>

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
                                    <span class="badge bg-warning">pending</span>
                                <?php } else { ?>
                                    <span class="badge bg-secondary">not uploaded</span>
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
