<div class="page-heading">

    <h3>Edit Event</h3>
    <p class="page-subtitle">Perbarui informasi event yang sudah dibuat.</p>

</div>

<div class="page-content">

    <div class="card">

        <div class="card-header">
<<<<<<< HEAD
            <h4 class="card-title mb-0"><?= e($event->nama_event) ?></h4>
=======
            <h4 class="card-title mb-0"><?= html_escape($event->nama_event) ?></h4>
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f
        </div>

        <div class="card-body">

<<<<<<< HEAD
            <?= flash_alert('error') ?>
=======
            <?php if($this->session->flashdata('error')){ ?>

            <div class="alert alert-danger">
                <i class="bi bi-exclamation-circle me-2"></i>
                <?= $this->session->flashdata('error') ?>
            </div>

            <?php } ?>
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f

            <?= validation_errors('<div class="alert alert-danger">', '</div>') ?>

            <form method="post" enctype="multipart/form-data">

                <div class="row">

                    <div class="col-md-8">

                        <div class="mb-3">
<<<<<<< HEAD
                            <label for="nama_event" class="form-label">Nama Event</label>
                            <input type="text"
                                id="nama_event"
                                name="nama_event"
                                class="form-control"
                                value="<?= e(set_value('nama_event', $event->nama_event)) ?>">
=======
                            <label>Nama Event</label>
                            <input type="text"
                                name="nama_event"
                                class="form-control"
                                value="<?= html_escape($event->nama_event) ?>">
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f
                        </div>

                    </div>

                    <div class="col-md-4">

                        <div class="mb-3">
<<<<<<< HEAD
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date"
                                id="tanggal"
                                name="tanggal"
                                class="form-control"
                                value="<?= e(set_value('tanggal', $event->tanggal)) ?>">
=======
                            <label>Tanggal</label>
                            <input type="date"
                                name="tanggal"
                                class="form-control"
                                value="<?= html_escape($event->tanggal) ?>">
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f
                        </div>

                    </div>

                </div>

                <div class="mb-3">
<<<<<<< HEAD
                    <label for="lokasi" class="form-label">Lokasi</label>
                    <input type="text"
                        id="lokasi"
                        name="lokasi"
                        class="form-control"
                        value="<?= e(set_value('lokasi', $event->lokasi)) ?>">
                </div>

                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea name="deskripsi"
                        id="deskripsi"
                        rows="5"
                        class="form-control"><?= e(set_value('deskripsi', $event->deskripsi)) ?></textarea>
                </div>

                <div class="mb-4">
                    <label for="banner" class="form-label">Banner</label>

                    <?php if ($event->banner) { ?>

                    <div class="mb-3">
                        <img class="table-img"
                            src="<?= e(base_url('uploads/banner/' . $event->banner)) ?>"
                            alt="<?= e($event->nama_event) ?>">
=======
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
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f
                    </div>

                    <?php } ?>

                    <input type="file"
<<<<<<< HEAD
                        id="banner"
                        name="banner"
                        accept="image/png,image/jpeg"
=======
                        name="banner"
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f
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
