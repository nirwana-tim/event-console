<div id="sidebar">

    <div class="sidebar-wrapper active">

        <div class="sidebar-header position-relative">
            <div class="d-flex justify-content-between align-items-center">
                <div class="logo">
                    <a href="<?= base_url('dashboard') ?>" class="d-flex align-items-center gap-2 text-decoration-none">
                        <div class="brand-mark">
                            <i class="bi bi-calendar2-check"></i>
                        </div>
                        <h4 class="mb-0 text-primary">EventConsole</h4>
                    </a>
                </div>
                <div class="sidebar-toggler x">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>

        <div class="sidebar-menu">

            <ul class="menu">

                <li class="sidebar-title">

                    MENU

                </li>

                <li class="sidebar-item<?= active_sidebar_class('dashboard', $active_menu) ?>">

                    <a href="<?= base_url('dashboard') ?>"
                        class="sidebar-link">

                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>

                    </a>

                </li>

                <?php if ($current_user_role === 'admin') { ?>

                <li class="sidebar-item<?= active_sidebar_class('event', $active_menu) ?>">

                    <a href="<?= base_url('event') ?>"
                        class="sidebar-link">

                        <i class="bi bi-calendar2-event-fill"></i>
                        <span>Event Data</span>

                    </a>

                </li>

                <li class="sidebar-item<?= active_sidebar_class('registrations', $active_menu) ?>">

                    <a href="<?= base_url('event/registrations') ?>"
                        class="sidebar-link">

                        <i class="bi bi-person-lines-fill"></i>
                        <span>Registrations</span>

                    </a>

                </li>

                <li class="sidebar-item<?= active_sidebar_class('certificates_admin', $active_menu) ?>">

                    <a href="<?= base_url('event/certificates') ?>"
                        class="sidebar-link">

                        <i class="bi bi-award-fill"></i>
                        <span>Certificates</span>

                    </a>

                </li>

                <li class="sidebar-item<?= active_sidebar_class('users', $active_menu) ?>">

                    <a href="<?= base_url('users') ?>"
                        class="sidebar-link">

                        <i class="bi bi-person-gear"></i>
                        <span>User Management</span>

                    </a>

                </li>

                <?php } ?>

                <?php if ($current_user_role === 'participant') { ?>

                <li class="sidebar-item<?= active_sidebar_class('participant_events', $active_menu) ?>">

                    <a href="<?= base_url('participant/events') ?>"
                        class="sidebar-link">

                        <i class="bi bi-calendar2-event-fill"></i>
                        <span>Events</span>

                    </a>

                </li>

                <li class="sidebar-item<?= active_sidebar_class('my_participants', $active_menu) ?>">

                    <a href="<?= base_url('participant') ?>"
                        class="sidebar-link">

                        <i class="bi bi-clipboard-check-fill"></i>
                        <span>My Participants</span>

                    </a>

                </li>

                <li class="sidebar-item<?= active_sidebar_class('certificates', $active_menu) ?>">

                    <a href="<?= base_url('participant/certificates') ?>"
                        class="sidebar-link">

                        <i class="bi bi-award-fill"></i>
                        <span>My Certificates</span>

                    </a>

                </li>

                <?php } ?>



            </ul>

        </div>

    </div>

</div>

<div id="main" class="layout-navbar navbar-fixed">
    <header>
        <nav class="navbar navbar-expand navbar-light navbar-top">
            <div class="container-fluid">
                <a href="#" class="burger-btn d-block">
                    <i class="bi bi-justify fs-3"></i>
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <div class="dropdown ms-auto">
                        <a href="#" data-bs-toggle="dropdown" aria-expanded="false" class="text-decoration-none">
                            <div class="user-menu d-flex align-items-center">
                                <div class="user-name text-end me-3">
                                    <h6 class="mb-0 text-gray-600"><?= e($current_user_name) ?></h6>
                                    <p class="mb-0 text-sm text-gray-500 text-capitalize"><?= e($current_user_role) ?></p>
                                </div>
                                <div class="user-img d-flex align-items-center">
                                    <div class="avatar avatar-md">
                                        <span class="avatar-content bg-primary text-white">
                                            <?= e($current_user_initial) ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton" style="min-width: 11rem;">
                            <li>
                                <h6 class="dropdown-header">Hello, <?= e($current_user_name) ?>!</h6>
                            </li>
                            <li>
                                <a class="dropdown-item" href="<?= base_url('dashboard') ?>">
                                    <i class="icon-mid bi bi-grid me-2"></i> Dashboard
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="<?= base_url('settings') ?>">
                                    <i class="icon-mid bi bi-gear me-2"></i> Settings
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item text-danger" href="<?= base_url('auth/logout') ?>">
                                    <i class="icon-mid bi bi-box-arrow-left me-2"></i> Logout
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <div id="main-content">
