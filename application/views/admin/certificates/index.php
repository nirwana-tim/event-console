<div class="page-content">

    <?= flash_alert('success') ?>
    <?= flash_alert('error') ?>
    <?= flash_alert('info') ?>

    <div class="card">

        <div class="card-header">
            <h4 class="card-title mb-0">Certificate List</h4>
        </div>

        <div class="card-body">

            <form method="get" action="<?= base_url('admin/certificate') ?>" class="mb-4">
                <div class="row g-2 align-items-end">

                    <div class="col-md-5">
                        <label class="form-label mb-1"><small>Search Certificate</small></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input type="text" name="keyword" class="form-control" value="<?= e(isset($keyword) ? $keyword : '') ?>" placeholder="Number, participant, event">
                        </div>
                    </div>

                    <div class="col-md-5">
                        <label class="form-label mb-1"><small>Event</small></label>
                        <select name="event_id" class="form-select">
                            <option value="">All Events</option>
                            <?php foreach ($events as $event) { ?>
                                <option value="<?= e($event->id) ?>" <?= (int) $selected_event_id === (int) $event->id ? 'selected' : '' ?>>
                                    <?= e($event->name) ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-md-1">
                        <button class="btn btn-primary w-100" title="Search">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>

                    <div class="col-md-1">
                        <a href="<?= base_url('admin/certificate') ?>" class="btn btn-light w-100" title="Reset filter">
                            <i class="bi bi-arrow-clockwise"></i>
                        </a>
                    </div>

                </div>
            </form>

            <div class="table-responsive">

                <table class="table table-hover align-middle" id="table-certificates">

                    <thead>
                        <tr>
                            <th>Number</th>
                            <th>Participant</th>
                            <th>Event</th>
                            <th>Verification Code</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php if (empty($certificates)) { ?>
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state">
                                        <i class="bi bi-award d-block mb-2"></i>
                                        No certificates found
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>

                        <?php foreach ($certificates as $certificate) { ?>
                            <tr>
                                <td><strong><?= e($certificate->certificate_number) ?></strong></td>
                                <td><?= e($certificate->user_name) ?></td>
                                <td><?= e($certificate->event_name) ?></td>
                                <td><?= e($certificate->verification_code ?: '-') ?></td>
                                <td><?= e(app_date($certificate->created_at)) ?></td>
                                <td>
                                    <a href="<?= base_url('admin/certificate/show/' . $certificate->id) ?>"
                                        class="btn btn-primary btn-sm"
                                        target="_blank">
                                        <i class="bi bi-file-earmark-pdf me-1"></i>
                                        PDF
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
