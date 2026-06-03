<div class="page-heading">

    <h3>Upload Bukti Pembayaran</h3>
    <p class="page-subtitle">Upload bukti agar admin bisa memverifikasi pendaftaranmu.</p>

</div>

<div class="page-content">

<<<<<<< HEAD
    <?= flash_alert('error') ?>
    <?= flash_alert('info') ?>

=======
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f
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
<<<<<<< HEAD
                            <label for="bukti" class="form-label">Bukti Pembayaran</label>
                            <input type="file"
                                id="bukti"
                                name="bukti"
                                accept="image/png,image/jpeg"
=======
                            <label>Bukti Pembayaran</label>
                            <input type="file"
                                name="bukti"
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f
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
