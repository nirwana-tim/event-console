<div class="page-content">

    <?= flash_alert('success') ?>
    <?= flash_alert('error') ?>
    <?= flash_alert('info') ?>

    <div class="card">

        <div class="card-header">
            <h4 class="card-title mb-0">Certificate List</h4>
        </div>

        <div class="card-body">

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
                                    No certificates generated yet
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
                                <a href="<?= base_url('event/certificate/' . $certificate->id) ?>"
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
