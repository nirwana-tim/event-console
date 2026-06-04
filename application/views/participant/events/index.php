<?= flash_alert('success') ?>
<?= flash_alert('error') ?>
<?= flash_alert('info') ?>

<div class="page-heading">

    <h3>Events</h3>
    <p class="page-subtitle">Choose the event you want to join.</p>

</div>

<div class="page-content">

    <div class="row">

        <?php if (empty($events)) { ?>

        <div class="col-12">
            <div class="card">
                <div class="empty-state">
                    <i class="bi bi-calendar-x d-block mb-2"></i>
                    No events available yet
                </div>
            </div>
        </div>

        <?php } ?>

        <?php foreach ($events as $event) { ?>

        <div class="col-md-6 col-xl-4">

            <div class="card event-card h-100">

                <img src="<?= e(base_url('uploads/banner/' . $event->banner)) ?>"
                    class="card-img-top"
                    alt="<?= e($event->name) ?>"
                    onerror="this.src='<?= base_url('mazer/dist/assets/static/images/samples/error-404.svg') ?>'">

                <div class="card-body d-flex flex-column">

                    <h5 class="card-title"><?= e($event->name) ?></h5>

                    <div class="mb-2">
                        <span class="badge bg-<?= status_badge_class($event->status) ?>">
                            <?= e($event->status) ?>
                        </span>
                        <?php if ($event->quota) { ?>
                            <span class="badge bg-light text-dark">
                                Quota <?= e($event->quota) ?>
                            </span>
                        <?php } ?>
                    </div>

                    <div class="event-meta">
                        <i class="bi bi-geo-alt"></i>
                        <span><?= e($event->location) ?></span>
                    </div>

                    <div class="event-meta mb-3">
                        <i class="bi bi-calendar3"></i>
                        <span><?= e(app_date($event->date)) ?></span>
                    </div>

                    <p class="text-muted flex-grow-1">
                        <?= e(substr(strip_tags($event->description), 0, 120)) ?>
                    </p>

                    <?php if ($event->status === 'dibuka') { ?>
                        <a href="<?= base_url('participant/create/' . $event->id) ?>"
                            class="btn btn-primary w-100">
                            <i class="bi bi-pencil-square me-1"></i>
                            Register for Event
                        </a>
                    <?php } else { ?>
                        <button type="button" class="btn btn-light w-100" disabled>
                            Registration Closed
                        </button>
                    <?php } ?>

                </div>

            </div>

        </div>

        <?php } ?>

    </div>

</div>
