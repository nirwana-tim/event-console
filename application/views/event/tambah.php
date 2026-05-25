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

            <?php if($this->session->flashdata('error')){ ?>

            <div class="alert alert-danger">
                <i class="bi bi-exclamation-circle me-2"></i>
                <?= $this->session->flashdata('error') ?>
            </div>

            <?php } ?>

            <?= validation_errors('<div class="alert alert-danger">', '</div>') ?>

            <form method="post" enctype="multipart/form-data">

                <div class="row">

                    <div class="col-md-6">

                        <div class="mb-3">
                            <label>Nama Event</label>
                            <input type="text"
                                name="nama_event"
                                class="form-control"
                                placeholder="Contoh: Lomba Desain Poster">
                        </div>

                    </div>

                    <div class="col-md-3">

                        <div class="mb-3">
                            <label>Tanggal</label>
                            <input type="date"
                                name="tanggal"
                                class="form-control">
                        </div>

                    </div>

                    <div class="col-md-3">

                        <div class="mb-3">
                            <label>Lokasi</label>
                            <input type="text"
                                name="lokasi"
                                class="form-control"
                                placeholder="Kampus / Online">
                        </div>

                    </div>

                </div>

                <div class="mb-3">
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
