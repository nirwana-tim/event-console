<?php if($this->session->flashdata('success')){ ?>

<div class="alert alert-success">
    <i class="bi bi-check-circle me-2"></i>
    <?= $this->session->flashdata('success') ?>
</div>

<?php } ?>

<div class="page-heading">

    <h3>Daftar Event</h3>
    <p class="page-subtitle">Pilih event yang ingin kamu ikuti.</p>

</div>

<div class="page-content">

    <div class="row">

        <?php if(empty($event)){ ?>

        <div class="col-12">
            <div class="card">
                <div class="empty-state">
                    <i class="bi bi-calendar-x d-block mb-2"></i>
                    Belum ada event tersedia
                </div>
            </div>
        </div>

        <?php } ?>

        <?php foreach($event as $e){ ?>

        <div class="col-md-6 col-xl-4">

            <div class="card event-card h-100">

                <img src="<?= base_url('uploads/banner/'.$e->banner) ?>"
                    class="card-img-top"
                    alt="<?= html_escape($e->nama_event) ?>">

                <div class="card-body d-flex flex-column">

                    <h5 class="card-title"><?= html_escape($e->nama_event) ?></h5>

                    <div class="event-meta">
                        <i class="bi bi-geo-alt"></i>
                        <span><?= html_escape($e->lokasi) ?></span>
                    </div>

                    <div class="event-meta mb-3">
                        <i class="bi bi-calendar3"></i>
                        <span><?= html_escape($e->tanggal) ?></span>
                    </div>

                    <p class="text-muted flex-grow-1">
                        <?= html_escape(substr(strip_tags($e->deskripsi), 0, 120)) ?>
                    </p>

                    <a href="<?= base_url('peserta/form_daftar/'.$e->id) ?>"
                        class="btn btn-primary w-100">
                        <i class="bi bi-pencil-square me-1"></i>
                        Daftar Event
                    </a>

                </div>

            </div>

        </div>

        <?php } ?>

    </div>

</div>
