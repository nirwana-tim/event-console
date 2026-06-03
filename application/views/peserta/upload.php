<div class="page-heading">

    <h3>Upload Bukti Pembayaran</h3>
    <p class="page-subtitle">Upload bukti agar admin bisa memverifikasi pendaftaranmu.</p>

</div>

<div class="page-content">

    <?= flash_alert('error') ?>
    <?= flash_alert('info') ?>

    <div class="row justify-content-center">

        <div class="col-lg-7">

            <div class="card">

                <div class="card-header">
                    <h4 class="card-title mb-0">Bukti Pembayaran</h4>
                </div>

                <div class="card-body">

                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        Silakan upload bukti pembayaran untuk menyelesaikan pendaftaran event.
                    </div>

                    <form method="POST" enctype="multipart/form-data">

                        <div class="mb-4">
                            <label for="bukti" class="form-label">Bukti Pembayaran</label>
                            <input type="file"
                                id="bukti"
                                name="bukti"
                                accept="image/png,image/jpeg"
                                class="form-control"
                                required>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-cloud-arrow-up me-1"></i>
                            Upload Sekarang
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>
