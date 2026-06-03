<div class="page-heading">

    <h3>Tambah Event</h3>
    <p class="page-subtitle">Buat event baru untuk dibuka ke peserta.</p>

</div>

<div class="page-content">

    <div class="card">

        <div class="card-header">
            <h4 class="card-title mb-0">Informasi Event</h4>
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

                    <div class="col-md-6">

                        <div class="mb-3">
<<<<<<< HEAD
                            <label for="nama_event" class="form-label">Nama Event</label>
                            <input type="text"
                                id="nama_event"
                                name="nama_event"
                                class="form-control"
                                value="<?= e(set_value('nama_event')) ?>"
=======
                            <label>Nama Event</label>
                            <input type="text"
                                name="nama_event"
                                class="form-control"
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f
                                placeholder="Contoh: Lomba Desain Poster">
                        </div>

                    </div>

                    <div class="col-md-3">

                        <div class="mb-3">
<<<<<<< HEAD
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date"
                                id="tanggal"
                                name="tanggal"
                                value="<?= e(set_value('tanggal')) ?>"
=======
                            <label>Tanggal</label>
                            <input type="date"
                                name="tanggal"
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f
                                class="form-control">
                        </div>

                    </div>

                    <div class="col-md-3">

                        <div class="mb-3">
<<<<<<< HEAD
                            <label for="lokasi" class="form-label">Lokasi</label>
                            <input type="text"
                                id="lokasi"
                                name="lokasi"
                                class="form-control"
                                value="<?= e(set_value('lokasi')) ?>"
=======
                            <label>Lokasi</label>
                            <input type="text"
                                name="lokasi"
                                class="form-control"
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f
                                placeholder="Kampus / Online">
                        </div>

                    </div>

                </div>

                <div class="mb-3">
<<<<<<< HEAD
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea name="deskripsi"
                        id="deskripsi"
                        rows="5"
                        class="form-control"
                        placeholder="Detail singkat event"><?= e(set_value('deskripsi')) ?></textarea>
                </div>

                <div class="mb-4">
                    <label for="banner" class="form-label">Banner</label>
                    <input type="file"
                        id="banner"
                        name="banner"
                        accept="image/png,image/jpeg"
=======
                    <label>Deskripsi</label>
                    <textarea name="deskripsi"
                        rows="5"
                        class="form-control"
                        placeholder="Detail singkat event"></textarea>
                </div>

                <div class="mb-4">
                    <label>Banner</label>
                    <input type="file"
                        name="banner"
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f
                        class="form-control">
                </div>

                <div class="btn-group-wrap">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save me-1"></i>
                        Simpan Event
                    </button>

                    <a href="<?= base_url('event') ?>" class="btn btn-light">
                        Kembali
                    </a>
                </div>

            </form>

        </div>

    </div>

</div>
