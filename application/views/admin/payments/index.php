<?= flash_alert('success') ?>
<?= flash_alert('error') ?>
<?= flash_alert('info') ?>

<div class="page-heading">

    <h3>Payments</h3>
    <p class="page-subtitle">Verify payment proofs before marking participant attendance.</p>

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
                            <th>Payment</th>
                            <th>Attendance</th>
                            <th>Certificate</th>
                            <th>Actions</th>
                        </tr>

                    </thead>

                    <tbody>

                        <?php if (empty($payments)) { ?>

                        <tr>
                            <td colspan="7">
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
                                    <span class="badge bg-warning">pending</span>
                                <?php } elseif ($payment->status === 'rejected') { ?>
                                    <span class="badge bg-danger">rejected</span>
                                <?php } else { ?>
                                    <span class="badge bg-success">verified</span>
                                <?php } ?>
                            </td>

                            <td>
                                <span class="badge bg-<?= attendance_badge_class($payment->attendance) ?>">
                                    <?= e($payment->attendance) ?>
                                </span>
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
                                    <span class="text-muted">Not ready</span>
                                <?php } ?>
                            </td>

                            <td>
                                <div class="btn-group-wrap">
                                    <?php if ($payment->status !== 'verified') { ?>
                                        <a href="<?= base_url('event/approve/' . $payment->id) ?>"
                                            class="btn btn-success btn-sm"
                                            onclick="return confirm('Approve this payment?')">
                                            <i class="bi bi-check2-circle me-1"></i>
                                            Approve
                                        </a>
                                    <?php } ?>

                                    <?php if ($payment->status !== 'rejected') { ?>
                                        <a href="<?= base_url('event/reject_payment/' . $payment->id) ?>"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Reject this payment?')">
                                            <i class="bi bi-x-circle me-1"></i>
                                            Reject
                                        </a>
                                    <?php } ?>

                                    <?php if ($payment->status === 'verified' && $payment->attendance !== 'present') { ?>
                                        <a href="<?= base_url('event/attendance/' . $payment->registration_id . '/present') ?>"
                                            class="btn btn-primary btn-sm">
                                            Mark Present
                                        </a>
                                    <?php } ?>
                                </div>
                            </td>

                        </tr>

                        <?php } ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>
