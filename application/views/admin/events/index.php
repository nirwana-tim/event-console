<?= flash_alert('success') ?>
<?= flash_alert('error') ?>
<?= flash_alert('info') ?>



<div class="page-content">

    <div class="card">

        <div class="card-header">
            <h4 class="card-title mb-0">Event List</h4>
        </div>

        <div class="card-body">

            <form method="get" class="mb-4">

                <div class="row g-2 align-items-end">

                    <div class="col-md-3">
                        <label class="form-label mb-1"><small>Start Date</small></label>
                        <input type="date" name="start_date" class="form-control" value="<?= e(isset($start_date) ? $start_date : '') ?>">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label mb-1"><small>End Date</small></label>
                        <input type="date" name="end_date" class="form-control" value="<?= e(isset($end_date) ? $end_date : '') ?>">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label mb-1"><small>Search Event</small></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input type="text" name="keyword" class="form-control" value="<?= e($keyword) ?>" placeholder="Search events...">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <button class="btn btn-primary w-100">
                            Search
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
                            <th>Event Name</th>
                            <th>Date</th>
                            <th>Quota</th>
                            <th>Status</th>
                            <th>Location</th>
                            <th>Actions</th>
                        </tr>

                    </thead>

                    <tbody>

                        <?php if (empty($events)) { ?>

                        <tr>
                            <td colspan="8">
                                <div class="empty-state">
                                    <i class="bi bi-calendar-x d-block mb-2"></i>
                                    No event data found
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
                                    alt="<?= e($event->name) ?>"
                                    onerror="this.src='<?= base_url('mazer/dist/assets/static/images/samples/error-404.svg') ?>'">
                            </td>

                            <td>
                                <strong><?= e($event->name) ?></strong>
                            </td>
                            <td><?= e(app_date($event->date)) ?></td>
                            <td><?= e($event->total_registrations) ?>/<?= e($event->quota ?: '∞') ?></td>
                            <td>
                                <span class="badge bg-<?= status_badge_class($event->status) ?>">
                                    <?= e($event->status) ?>
                                </span>
                            </td>
                            <td><?= e($event->location) ?></td>
                            <td>

                                <div class="btn-group-wrap">

                                    <a href="<?= base_url('event/show/' . $event->id) ?>"
                                        class="btn btn-primary btn-sm">
                                        <i class="bi bi-eye me-1"></i>
                                        Show
                                    </a>

                                    <a href="<?= base_url('event/update/' . $event->id) ?>"
                                        class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil-square me-1"></i>
                                        Edit
                                    </a>

                                    <a href="<?= base_url('event/delete/' . $event->id) ?>"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Delete this event?')">
                                        <i class="bi bi-trash me-1"></i>
                                        Delete
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
