<div class="page-heading">

    <h3>Edit Event</h3>
    <p class="page-subtitle">Perbarui informasi event yang sudah dibuat.</p>

</div>

<div class="page-content">

    <div class="card">

        <div class="card-header">
            <h4 class="card-title mb-0"><?= html_escape($event->nama_event) ?></h4>
        </div>

        <div class="card-body">

            <?php if($this->session->flashdata('error')){ ?>

            <div class="alert alert-danger">
                <i class="bi bi-exclamation-circle me-2"></i>
                <?= $this->session->flashdata('error') ?>
            </div>

            <?php } ?>

            <?= validation_errors('<div class="alert alert-danger">', '</div>') ?>

            <form method="post" enctype="multipart/form-data">

                <div class="row">

                    <div class="col-md-8">

                        <div class="mb-3">
                            <label>Nama Event</label>
                            <input type="text"
                                name="nama_event"
                                class="form-control"
                                value="<?= html_escape($event->nama_event) ?>">
                        </div>

                    </div>

                    <div class="col-md-4">

                        <div class="mb-3">
                            <label>Tanggal</label>
                            <input type="date"
                                name="tanggal"
                                class="form-control"
                                value="<?= html_escape($event->tanggal) ?>">
                        </div>

                    </div>

                </div>

                <div class="mb-3">
                    <label>Lokasi</label>
                    <input type="text"
                        name="lokasi"
                        class="form-control"
                        value="<?= html_escape($event->lokasi) ?>">
                </div>

                <div class="mb-3">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi"
                        rows="5"
                        class="form-control"><?= html_escape($event->deskripsi) ?></textarea>
                </div>

                <div class="mb-4">
                    <label>Banner</label>

                    <?php if($event->banner){ ?>

                    <div class="mb-3">
                        <img class="table-img"
                            src="<?= base_url('uploads/banner/'.$event->banner) ?>"
                            alt="<?= html_escape($event->nama_event) ?>">
                    </div>

                    <?php } ?>

                    <input type="file"
                        name="banner"
                        class="form-control">
                </div>

                <div class="btn-group-wrap">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save me-1"></i>
                        Update Event
                    </button>

                    <a href="<?= base_url('event') ?>" class="btn btn-light">
                        Kembali
                    </a>
                </div>

            </form>

        </div>

    </div>

</div>
