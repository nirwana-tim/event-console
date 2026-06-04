<?= flash_alert('success') ?>
<?= flash_alert('error') ?>
<?= flash_alert('info') ?>

<div class="page-heading">

    <h3>Payment Data</h3>
    <p class="page-subtitle">Verify payments and generate participant certificates.</p>

</div>

<div class="page-content">

    <div class="card">

        <div class="card-header">
            <h4 class="card-title mb-0">Incoming Payments</h4>
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle" id="table-payments">

                    <thead>

                        <tr>
                            <th>Participant</th>
                            <th>Event</th>
                            <th>Proof</th>
                            <th>Status</th>
                            <th>Certificate</th>
                            <th>Actions</th>
                        </tr>

                    </thead>

                    <tbody>

                        <?php if (empty($payments)) { ?>

                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <i class="bi bi-credit-card d-block mb-2"></i>
                                    No payments yet
                                </div>
                            </td>
                        </tr>

                        <?php } ?>

                        <?php foreach ($payments as $payment) { ?>

                        <tr>

                            <td><strong><?= e($payment->user_name) ?></strong></td>
                            <td><?= e($payment->event_name) ?></td>

                            <td>
                                <a href="<?= e(base_url('uploads/payments/' . $payment->payment_proof)) ?>"
                                    target="_blank">
                                    <img class="table-img"
                                        src="<?= e(base_url('uploads/payments/' . $payment->payment_proof)) ?>"
                                        alt="Payment proof">
                                </a>
                            </td>

                            <td>
                                <?php if ($payment->status === 'pending') { ?>
                                    <span class="badge bg-warning">Pending</span>
                                <?php } else { ?>
                                    <span class="badge bg-success">Verified</span>
                                <?php } ?>
                            </td>

                            <td>
                                <?php if ($payment->certificate_id) { ?>
                                    <a href="<?= base_url('event/certificate/' . $payment->certificate_id) ?>"
                                        class="btn btn-primary btn-sm"
                                        target="_blank">
                                        <i class="bi bi-file-earmark-pdf me-1"></i>
                                        PDF
                                    </a>
                                <?php } else { ?>
                                    <span class="text-muted">Not available</span>
                                <?php } ?>
                            </td>

                            <td>
                                <?php if ($payment->status === 'pending') { ?>
                                    <a href="<?= base_url('event/approve/' . $payment->id) ?>"
                                        class="btn btn-success btn-sm"
                                        onclick="return confirm('Approve this payment?')">
                                        <i class="bi bi-check2-circle me-1"></i>
                                        Approve
                                    </a>
                                <?php } else { ?>
                                    <span class="badge bg-light-success text-success">Completed</span>
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
