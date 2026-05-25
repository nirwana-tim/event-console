<div class="page-heading">

    <h3>Form Pendaftaran Event</h3>
    <p class="page-subtitle">Lengkapi data peserta sebelum upload pembayaran.</p>

</div>

<div class="page-content">

    <div class="row">

        <div class="col-lg-4">

            <div class="card event-card">
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
                        action="<?= base_url('peserta/daftar/'.$event->id) ?>">

                        <div class="row">

                            <div class="col-md-6">

                                <div class="mb-3">
                                    <label>No HP</label>
                                    <input type="text"
                                        name="no_hp"
                                        class="form-control"
                                        placeholder="08xxxxxxxxxx"
                                        required>
                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="mb-3">
                                    <label>Instansi</label>
                                    <input type="text"
                                        name="instansi"
                                        class="form-control"
                                        placeholder="Sekolah / Kampus / Komunitas"
                                        required>
                                </div>

                            </div>

                        </div>

                        <div class="mb-3">
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
