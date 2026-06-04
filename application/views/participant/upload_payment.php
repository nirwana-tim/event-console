<div class="page-heading">

    <h3>Upload Payment Proof</h3>
    <p class="page-subtitle">Upload your proof so the admin can verify your registration.</p>

</div>

<div class="page-content">

    <?= flash_alert('error') ?>
    <?= flash_alert('info') ?>

    <div class="row justify-content-center">

        <div class="col-lg-7">

            <div class="card">

                <div class="card-header">
                    <h4 class="card-title mb-0">Payment Proof</h4>
                </div>

                <div class="card-body">

                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        Please upload your payment proof to complete the event registration.
                    </div>

                    <form method="POST" enctype="multipart/form-data">

                        <div class="mb-4">
                            <label for="payment_proof" class="form-label">Payment Proof</label>
                            <input type="file"
                                id="payment_proof"
                                name="payment_proof"
                                accept="image/png,image/jpeg"
                                class="form-control"
                                required>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-cloud-arrow-up me-1"></i>
                            Upload Now
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>
