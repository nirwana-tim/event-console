<<<<<<< HEAD
<?= flash_alert('success') ?>
<?= flash_alert('error') ?>
<?= flash_alert('info') ?>
=======
<?php if($this->session->flashdata('success')){ ?>

<div class="alert alert-success">
    <i class="bi bi-check-circle me-2"></i>
    <?= $this->session->flashdata('success') ?>
</div>

<?php } ?>
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f

<div class="page-heading">

    <h3>Daftar Event</h3>
    <p class="page-subtitle">Pilih event yang ingin kamu ikuti.</p>

</div>

<div class="page-content">

    <div class="row">

<<<<<<< HEAD
        <?php if (empty($events)) { ?>
=======
        <?php if(empty($event)){ ?>
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f

        <div class="col-12">
            <div class="card">
                <div class="empty-state">
                    <i class="bi bi-calendar-x d-block mb-2"></i>
                    Belum ada event tersedia
                </div>
            </div>
        </div>

        <?php } ?>

<<<<<<< HEAD
        <?php foreach ($events as $event) { ?>
=======
        <?php foreach($event as $e){ ?>
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f

        <div class="col-md-6 col-xl-4">

            <div class="card event-card h-100">

<<<<<<< HEAD
                <img src="<?= e(base_url('uploads/banner/' . $event->banner)) ?>"
                    class="card-img-top"
                    alt="<?= e($event->nama_event) ?>">

                <div class="card-body d-flex flex-column">

                    <h5 class="card-title"><?= e($event->nama_event) ?></h5>

                    <div class="event-meta">
                        <i class="bi bi-geo-alt"></i>
                        <span><?= e($event->lokasi) ?></span>
=======
                <img src="<?= base_url('uploads/banner/'.$e->banner) ?>"
                    class="card-img-top"
                    alt="<?= html_escape($e->nama_event) ?>">

                <div class="card-body d-flex flex-column">

                    <h5 class="card-title"><?= html_escape($e->nama_event) ?></h5>

                    <div class="event-meta">
                        <i class="bi bi-geo-alt"></i>
                        <span><?= html_escape($e->lokasi) ?></span>
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f
                    </div>

                    <div class="event-meta mb-3">
                        <i class="bi bi-calendar3"></i>
<<<<<<< HEAD
                        <span><?= e(app_date($event->tanggal)) ?></span>
                    </div>

                    <p class="text-muted flex-grow-1">
                        <?= e(substr(strip_tags($event->deskripsi), 0, 120)) ?>
                    </p>

                    <a href="<?= base_url('peserta/form_daftar/' . $event->id) ?>"
=======
                        <span><?= html_escape($e->tanggal) ?></span>
                    </div>

                    <p class="text-muted flex-grow-1">
                        <?= html_escape(substr(strip_tags($e->deskripsi), 0, 120)) ?>
                    </p>

                    <a href="<?= base_url('peserta/form_daftar/'.$e->id) ?>"
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f
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
