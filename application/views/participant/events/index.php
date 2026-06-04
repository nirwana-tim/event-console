<?= flash_alert('success') ?>
<?= flash_alert('error') ?>
<?= flash_alert('info') ?>

<div class="page-content">

    <div class="card mb-4">
        <div class="card-header">
            <h4 class="card-title mb-0">Events</h4>
        </div>

        <div class="card-body">
            <form method="get" action="<?= base_url('participant/events') ?>">
                <div class="row g-2 align-items-end">

                    <div class="col-md-6">
                        <label class="form-label mb-1"><small>Search Event</small></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input type="text" name="keyword" class="form-control" value="<?= e(isset($keyword) ? $keyword : '') ?>" placeholder="Event name or location">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label mb-1"><small>Status</small></label>
                        <select name="status" class="form-select">
                            <option value="">All Status</option>
                            <option value="dibuka" <?= isset($selected_status) && $selected_status === 'dibuka' ? 'selected' : '' ?>>Open</option>
                            <option value="ditutup" <?= isset($selected_status) && $selected_status === 'ditutup' ? 'selected' : '' ?>>Closed</option>
                            <option value="selesai" <?= isset($selected_status) && $selected_status === 'selesai' ? 'selected' : '' ?>>Completed</option>
                        </select>
                    </div>

                    <div class="col-md-1">
                        <button class="btn btn-primary w-100" title="Search">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>

                    <div class="col-md-1">
                        <a href="<?= base_url('participant/events') ?>" class="btn btn-light w-100" title="Reset filter">
                            <i class="bi bi-arrow-clockwise"></i>
                        </a>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <div class="row g-4">
        <?php if (empty($events)) { ?>
            <div class="col-12">
                <div class="empty-state py-5">
                    <i class="bi bi-calendar-x d-block mb-2"></i>
                    No matching events found
                </div>
            </div>
        <?php } ?>

        <?php foreach ($events as $event) { ?>
            <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden event-card-modern position-relative">
                    <div class="position-relative">
                        <img src="<?= e(base_url('uploads/banner/' . $event->banner)) ?>"
                             class="card-img-top object-fit-cover"
                             alt="<?= e($event->name) ?>"
                             style="height: 160px;"
                             onerror="this.src='<?= base_url('mazer/dist/assets/static/images/samples/architecture.jpg') ?>'">
                        <div class="position-absolute top-0 end-0 p-2">
                            <span class="badge bg-<?= status_badge_class($event->status) ?> py-1 px-2 text-uppercase x-small shadow-sm">
                                <?= e(status_label($event->status)) ?>
                            </span>
                        </div>
                    </div>

                    <div class="card-body p-3 d-flex flex-column">
                        <div class="mb-1">
                            <small class="text-primary fw-bold text-uppercase x-small letter-spacing-1">
                                <i class="bi bi-calendar2-event me-1"></i>
                                <?= e(human_diff($event->date)) ?>
                            </small>
                        </div>

                        <h5 class="card-title fw-bold mb-2 fs-6">
                            <a href="<?= base_url('participant/event_show/' . $event->id) ?>" class="stretched-link text-gray-800 text-decoration-none">
                                <?= e($event->name) ?>
                            </a>
                        </h5>

                        <div class="d-flex align-items-center mb-1 text-muted x-small">
                            <i class="bi bi-geo-alt-fill me-1 text-danger"></i>
                            <span class="text-truncate"><?= e($event->location) ?></span>
                        </div>

                        <div class="d-flex align-items-center mb-3 text-muted x-small">
                            <i class="bi bi-people-fill me-1 text-info"></i>
                            <span><?= e($event->total_registrations) ?> / <?= e($event->quota ?: 'Unlimited') ?></span>
                        </div>

                        <div class="mt-auto">
                            <?php if ($event->user_registration_id) { ?>
                                <span class="badge bg-light-success text-success w-100 py-2 rounded-3 border-0">
                                    <i class="bi bi-check-circle-fill me-1"></i>
                                    Registered
                                </span>
                            <?php } elseif ($event->status === 'dibuka') { ?>
                                <span class="btn btn-primary btn-sm w-100 py-2 rounded-3 shadow-sm">
                                    <i class="bi bi-plus-circle me-1"></i>
                                    Join Event
                                </span>
                            <?php } else { ?>
                                <span class="btn btn-light btn-sm w-100 py-2 rounded-3 disabled">
                                    Closed
                                </span>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

    <?php if (isset($pagination)) { ?>
        <div class="d-flex justify-content-center mt-5 mb-4">
            <?= $pagination ?>
        </div>
    <?php } ?>

</div>
