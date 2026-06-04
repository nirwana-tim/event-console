<?= flash_alert('success') ?>
<?= flash_alert('error') ?>
<?= flash_alert('info') ?>



<div class="page-content">

    <div class="card">

        <?php
        $filter_params = array();

        if ($keyword !== '') {
            $filter_params['keyword'] = $keyword;
        }

        if (isset($status) && $status !== '') {
            $filter_params['status'] = $status;
        }

        if (isset($start_date) && $start_date !== '') {
            $filter_params['start_date'] = $start_date;
        }

        if (isset($end_date) && $end_date !== '') {
            $filter_params['end_date'] = $end_date;
        }

        $filter_query = $filter_params ? '?' . http_build_query($filter_params) : '';
        ?>

        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">Event List</h4>

            <div class="btn-group-wrap">
                <a href="<?= base_url('event/create') ?>" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-1"></i>
                    Create
                </a>

                <a href="<?= base_url('event/pdf') . $filter_query ?>" class="btn btn-light" target="_blank">
                    <i class="bi bi-file-earmark-pdf me-1"></i>
                    PDF
                </a>

                <a href="<?= base_url('event/excel') . $filter_query ?>" class="btn btn-light">
                    <i class="bi bi-file-earmark-excel me-1"></i>
                    Excel
                </a>
            </div>
        </div>

        <div class="card-body">

            <form method="get" action="<?= base_url('event') ?>" class="mb-4">

                <div class="row g-2 align-items-end">

                    <div class="col-md-3">
                        <label class="form-label mb-1"><small>Search Event</small></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input type="text" name="keyword" class="form-control" value="<?= e($keyword) ?>" placeholder="Event name or location">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label mb-1"><small>Status</small></label>
                        <select name="status" class="form-select">
                            <option value="">All Status</option>
                            <option value="dibuka" <?= isset($status) && $status === 'dibuka' ? 'selected' : '' ?>>Open</option>
                            <option value="ditutup" <?= isset($status) && $status === 'ditutup' ? 'selected' : '' ?>>Closed</option>
                            <option value="selesai" <?= isset($status) && $status === 'selesai' ? 'selected' : '' ?>>Completed</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label mb-1"><small>Start Date</small></label>
                        <input type="date" name="start_date" class="form-control" value="<?= e(isset($start_date) ? $start_date : '') ?>">
                    </div>

                    <div class="col-md-2">
                        <label class="form-label mb-1"><small>End Date</small></label>
                        <input type="date" name="end_date" class="form-control" value="<?= e(isset($end_date) ? $end_date : '') ?>">
                    </div>

                    <div class="col-md-2">
                        <button class="btn btn-primary w-100">
                            <i class="bi bi-search me-1"></i>
                            Search
                        </button>
                    </div>

                    <div class="col-md-1">
                        <a href="<?= base_url('event') ?>" class="btn btn-light w-100" title="Reset filter">
                            <i class="bi bi-arrow-clockwise"></i>
                        </a>
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
                            <td><?= e($event->total_registrations) ?>/<?= e($event->quota ?: 'Unlimited') ?></td>
                            <td>
                                <span class="badge bg-<?= status_badge_class($event->status) ?>">
                                    <?= e(status_label($event->status)) ?>
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
