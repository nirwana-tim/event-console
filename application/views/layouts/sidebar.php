        <div id="sidebar">
            <div class="sidebar-wrapper active d-flex flex-column">
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

                <div class="sidebar-menu flex-grow-1" style="overflow-y: auto;">
                    <ul class="menu">
                        <li class="sidebar-title">MENU</li>

                        <li class="sidebar-item<?= active_sidebar_class('dashboard', $active_menu) ?>">
                            <a href="<?= base_url('dashboard') ?>" class="sidebar-link">
                                <i class="bi bi-grid-fill"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>

                        <?php if ($current_user_role === 'admin') { ?>
                            <li class="sidebar-item<?= active_sidebar_class('event', $active_menu) ?>">
                                <a href="<?= base_url('event') ?>" class="sidebar-link">
                                    <i class="bi bi-calendar2-event-fill"></i>
                                    <span>Event Data</span>
                                </a>
                            </li>

                            <li class="sidebar-item<?= active_sidebar_class('registrations', $active_menu) ?>">
                                <a href="<?= base_url('event/registrations') ?>" class="sidebar-link">
                                    <i class="bi bi-person-lines-fill"></i>
                                    <span>Registrations</span>
                                </a>
                            </li>

                            <li class="sidebar-item<?= active_sidebar_class('certificates_admin', $active_menu) ?>">
                                <a href="<?= base_url('event/certificates') ?>" class="sidebar-link">
                                    <i class="bi bi-award-fill"></i>
                                    <span>Certificates</span>
                                </a>
                            </li>

                            <li class="sidebar-item<?= active_sidebar_class('users', $active_menu) ?>">
                                <a href="<?= base_url('users') ?>" class="sidebar-link">
                                    <i class="bi bi-person-gear"></i>
                                    <span>User Management</span>
                                </a>
                            </li>
                        <?php } ?>

                        <?php if ($current_user_role === 'participant') { ?>
                            <li class="sidebar-item<?= active_sidebar_class('participant_events', $active_menu) ?>">
                                <a href="<?= base_url('participant/events') ?>" class="sidebar-link">
                                    <i class="bi bi-calendar2-event-fill"></i>
                                    <span>Events</span>
                                </a>
                            </li>

                            <li class="sidebar-item<?= active_sidebar_class('my_participants', $active_menu) ?>">
                                <a href="<?= base_url('participant') ?>" class="sidebar-link">
                                    <i class="bi bi-clipboard-check-fill"></i>
                                    <span>My Participants</span>
                                </a>
                            </li>

                            <li class="sidebar-item<?= active_sidebar_class('certificates', $active_menu) ?>">
                                <a href="<?= base_url('participant/certificates') ?>" class="sidebar-link">
                                    <i class="bi bi-award-fill"></i>
                                    <span>My Certificates</span>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
                
                <!-- Sidebar Profile -->
                <div class="sidebar-profile mt-auto p-4" style="border-top: 1px solid var(--bs-border-color); background-color: transparent;">
                    <div class="d-flex align-items-center">
                        <div class="d-flex justify-content-center align-items-center me-3" style="width: 45px; height: 45px; background-color: #9b1c1c; border-radius: 12px;">
                            <span class="fw-bold fs-5 text-white"><?= e($current_user_initial) ?></span>
                        </div>
                        <div class="flex-grow-1 overflow-hidden">
                            <h6 class="mb-0 text-truncate text-gray-800" style="font-size: 0.95rem; font-weight: 600;"><?= e($current_user_name) ?></h6>
                            <small class="text-muted text-capitalize text-truncate d-block" style="font-size: 0.8rem;"><?= e($current_user_role) ?></small>
                        </div>
                        <div class="d-flex gap-2 ms-2">
                            <a href="<?= base_url('settings') ?>" class="text-secondary" title="Settings" onmouseover="this.className='text-primary'" onmouseout="this.className='text-secondary'">
                                <i class="bi bi-gear fs-5"></i>
                            </a>
                            <a href="<?= base_url('auth/logout') ?>" class="text-secondary" title="Logout" onmouseover="this.className='text-danger'" onmouseout="this.className='text-secondary'">
                                <i class="bi bi-box-arrow-right fs-5"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- End Sidebar Profile -->
            </div>
        </div>

        <div id="main" class="layout-navbar navbar-fixed">
            <header class="bg-white shadow-sm">
                <nav class="navbar navbar-expand navbar-light navbar-top">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center">
                            <a href="#" class="burger-btn d-block d-xl-none me-3">
                                <i class="bi bi-justify fs-3 text-gray-800"></i>
                            </a>
                            <h5 class="mb-0 fw-bold text-gray-800"><?= isset($page_title) ? e($page_title) : 'Dashboard' ?></h5>
                        </div>

                        <div class="ms-auto d-none d-md-block">
                            <h6 class="mb-0 text-gray-600">Halo, <?= e($current_user_name) ?></h6>
                        </div>
                    </div>
                </nav>
            </header>

            <div id="main-content">
