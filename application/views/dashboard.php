<div class="page-heading">

    <h3>Dashboard</h3>
    <p class="page-subtitle">
        Ringkasan sistem event dan sertifikat online.
    </p>

</div>

<div class="page-content">

    <section class="row">

        <div class="col-12 col-md-6 col-xl-3">

            <div class="card stat-card">

                <div class="card-body py-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon bg-primary">
                            <i class="bi bi-calendar-event"></i>
                        </div>
                        <div>
                            <h6>Total Event</h6>
                            <h2><?= $this->db->count_all('events') ?></h2>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <div class="col-12 col-md-6 col-xl-3">

            <div class="card stat-card">

                <div class="card-body py-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon bg-success">
                            <i class="bi bi-people"></i>
                        </div>
                        <div>
                            <h6>Total Peserta</h6>
                            <h2>
                                <?= $this->db
                                    ->where('role','peserta')
                                    ->count_all_results('users')
                                ?>
                            </h2>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <div class="col-12 col-md-6 col-xl-3">

            <div class="card stat-card">

                <div class="card-body py-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon bg-warning">
                            <i class="bi bi-clipboard-check"></i>
                        </div>
                        <div>
                            <h6>Total Pendaftaran</h6>
                            <h2><?= $this->db->count_all('pendaftaran') ?></h2>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <div class="col-12 col-md-6 col-xl-3">

            <div class="card stat-card">

                <div class="card-body py-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon bg-info">
                            <i class="bi bi-person-badge"></i>
                        </div>
                        <div>
                            <h6>Role Aktif</h6>
                            <h4><?= ucfirst($this->session->userdata('role')) ?></h4>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </section>

    <section class="row">

        <div class="col-12">

            <div class="card">

                <div class="card-header">
                    <h4 class="card-title mb-0">
                        Selamat Datang, <?= html_escape($this->session->userdata('nama')) ?>
                    </h4>
                </div>

                <div class="card-body">
                    <p class="mb-0 text-muted">
                        Gunakan menu di sidebar untuk mengelola event, pendaftaran, pembayaran, dan sertifikat.
                    </p>
                </div>

            </div>

        </div>

    </section>

</div>
