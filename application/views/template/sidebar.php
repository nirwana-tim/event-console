<div id="sidebar">

    <div class="sidebar-wrapper active">

        <div class="sidebar-header">

            <div class="d-flex align-items-center gap-2">
                <div class="brand-mark">
                    <i class="bi bi-calendar2-check"></i>
                </div>
                <div>
<<<<<<< HEAD
                    <h3 class="mb-0">EventConsole</h3>
=======
                    <h3 class="mb-0">EventKu</h3>
                    <small class="text-muted">Event & Sertifikat</small>
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f
                </div>
            </div>

        </div>

        <div class="sidebar-menu">

            <ul class="menu">

                <li class="sidebar-title">

                    MENU

                </li>

<<<<<<< HEAD
                <li class="sidebar-item<?= active_sidebar_class('dashboard', $active_menu) ?>">
=======
                <li class="sidebar-item">
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f

                    <a href="<?= base_url('dashboard') ?>"
                        class="sidebar-link">

                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>

                    </a>

                </li>

<<<<<<< HEAD
                <?php if ($current_user_role === 'admin') { ?>

                <li class="sidebar-item<?= active_sidebar_class('event', $active_menu) ?>">
=======
                <?php if(
                    $this->session->userdata('role')
                    == 'admin'
                ){ ?>

                <li class="sidebar-item">
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f

                    <a href="<?= base_url('event') ?>"
                        class="sidebar-link">

                        <i class="bi bi-calendar2-event-fill"></i>
                        <span>Data Event</span>

                    </a>

                </li>

<<<<<<< HEAD
                <li class="sidebar-item<?= active_sidebar_class('pendaftaran', $active_menu) ?>">
=======
                <li class="sidebar-item">
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f

                    <a href="<?= base_url('event/pendaftaran') ?>"
                        class="sidebar-link">

                        <i class="bi bi-person-lines-fill"></i>
                        <span>Pendaftaran Peserta</span>

                    </a>

                </li>

<<<<<<< HEAD
                <li class="sidebar-item<?= active_sidebar_class('pembayaran', $active_menu) ?>">
=======
                <li class="sidebar-item">
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f

                    <a href="<?= base_url('event/pembayaran') ?>"
                        class="sidebar-link">

                        <i class="bi bi-receipt-cutoff"></i>
                        <span>Pembayaran</span>

                    </a>

                </li>

                <?php } ?>

<<<<<<< HEAD
                <?php if ($current_user_role === 'peserta') { ?>

                <li class="sidebar-item<?= active_sidebar_class('peserta_event', $active_menu) ?>">
=======
                <?php if(
                    $this->session->userdata('role')
                    == 'peserta'
                ){ ?>

                <li class="sidebar-item">
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f

                    <a href="<?= base_url('peserta/event') ?>"
                        class="sidebar-link">

                        <i class="bi bi-calendar2-event-fill"></i>
                        <span>Event</span>

                    </a>

                </li>

<<<<<<< HEAD
                <li class="sidebar-item<?= active_sidebar_class('sertifikat', $active_menu) ?>">
=======
                <li class="sidebar-item">
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f

                    <a href="<?= base_url('peserta/sertifikat') ?>"
                        class="sidebar-link">

                        <i class="bi bi-award-fill"></i>
                        <span>Sertifikat Saya</span>

                    </a>

                </li>

                <?php } ?>

                <li class="sidebar-item">

                    <a href="<?= base_url('auth/logout') ?>"
                        class="sidebar-link">

                        <i class="bi bi-box-arrow-right"></i>
                        <span>Logout</span>

                    </a>

                </li>

            </ul>

        </div>

    </div>

</div>

<div id="main">
