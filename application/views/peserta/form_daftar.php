<div class="page-heading">

    <h3>Form Pendaftaran Event</h3>
    <p class="page-subtitle">Lengkapi data peserta sebelum upload pembayaran.</p>

</div>

<div class="page-content">

<<<<<<< HEAD
    <?= validation_errors('<div class="alert alert-danger">', '</div>') ?>

=======
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f
    <div class="row">

        <div class="col-lg-4">

            <div class="card event-card">
<<<<<<< HEAD
                <img src="<?= e(base_url('uploads/banner/' . $event->banner)) ?>"
                    class="card-img-top"
                    alt="<?= e($event->nama_event) ?>">
                <div class="card-body">
                    <h5><?= e($event->nama_event) ?></h5>
                    <div class="event-meta">
                        <i class="bi bi-calendar3"></i>
                        <span><?= e(app_date($event->tanggal)) ?></span>
                    </div>
                    <div class="event-meta">
                        <i class="bi bi-geo-alt"></i>
                        <span><?= e($event->lokasi) ?></span>
=======
                <img src="<?= base_url('uploads/banner/'.$event->banner) ?>"
                    class="card-img-top"
                    alt="<?= html_escape($event->nama_event) ?>">
                <div class="card-body">
                    <h5><?= html_escape($event->nama_event) ?></h5>
                    <div class="event-meta">
                        <i class="bi bi-calendar3"></i>
                        <span><?= html_escape($event->tanggal) ?></span>
                    </div>
                    <div class="event-meta">
                        <i class="bi bi-geo-alt"></i>
                        <span><?= html_escape($event->lokasi) ?></span>
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f
                    </div>
                </div>
            </div>

        </div>

        <div class="col-lg-8">

            <div class="card">

                <div class="card-header">
                    <h4 class="card-title mb-0">Data Peserta</h4>
                </div>

                <div class="card-body">

                    <form method="post"
<<<<<<< HEAD
                        action="<?= base_url('peserta/daftar/' . $event->id) ?>">
=======
                        action="<?= base_url('peserta/daftar/'.$event->id) ?>">
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f

                        <div class="row">

                            <div class="col-md-6">

<<<<<<< HEAD
                            <div class="mb-3">
                                    <label for="no_hp" class="form-label">No HP</label>
                                    <input type="text"
                                        id="no_hp"
                                        name="no_hp"
                                        class="form-control"
                                        value="<?= e(set_value('no_hp')) ?>"
=======
                                <div class="mb-3">
                                    <label>No HP</label>
                                    <input type="text"
                                        name="no_hp"
                                        class="form-control"
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f
                                        placeholder="08xxxxxxxxxx"
                                        required>
                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="mb-3">
<<<<<<< HEAD
                                    <label for="instansi" class="form-label">Instansi</label>
                                    <input type="text"
                                        id="instansi"
                                        name="instansi"
                                        class="form-control"
                                        value="<?= e(set_value('instansi')) ?>"
=======
                                    <label>Instansi</label>
                                    <input type="text"
                                        name="instansi"
                                        class="form-control"
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f
                                        placeholder="Sekolah / Kampus / Komunitas"
                                        required>
                                </div>

                            </div>

                        </div>

                        <div class="mb-3">
<<<<<<< HEAD
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea name="alamat"
                                id="alamat"
                                rows="3"
                                class="form-control"
                                required><?= e(set_value('alamat')) ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="team" class="form-label">Team (Opsional)</label>
                            <input type="text"
                                id="team"
                                name="team"
                                class="form-control"
                                value="<?= e(set_value('team')) ?>">
                        </div>

                        <div class="mb-4">
                            <label for="catatan" class="form-label">Catatan</label>
                            <textarea name="catatan"
                                id="catatan"
                                rows="3"
                                class="form-control"><?= e(set_value('catatan')) ?></textarea>
=======
                            <label>Alamat</label>
                            <textarea name="alamat"
                                rows="3"
                                class="form-control"
                                required></textarea>
                        </div>

                        <div class="mb-3">
                            <label>Team (Opsional)</label>
                            <input type="text"
                                name="team"
                                class="form-control">
                        </div>

                        <div class="mb-4">
                            <label>Catatan</label>
                            <textarea name="catatan"
                                rows="3"
                                class="form-control"></textarea>
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f
                        </div>

                        <div class="btn-group-wrap">
                            <button class="btn btn-primary">
                                <i class="bi bi-send me-1"></i>
                                Daftar Sekarang
                            </button>

                            <a href="<?= base_url('peserta/event') ?>" class="btn btn-light">
                                Kembali
                            </a>
                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>
