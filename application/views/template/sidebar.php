<div id="sidebar">

    <div class="sidebar-wrapper active">

        <div class="sidebar-header">

            <div class="d-flex align-items-center gap-2">
                <div class="brand-mark">
                    <i class="bi bi-calendar2-check"></i>
                </div>
                <div>
                    <h3 class="mb-0">EventConsole</h3>
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
                        <span>Participant Registrations</span>

                    </a>

                </li>

                <li class="sidebar-item<?= active_sidebar_class('payments', $active_menu) ?>">

                    <a href="<?= base_url('event/payments') ?>"
                        class="sidebar-link">

                        <i class="bi bi-receipt-cutoff"></i>
                        <span>Payments</span>

                    </a>

                </li>

                <?php } ?>

                <?php if ($current_user_role === 'peserta') { ?>

                <li class="sidebar-item<?= active_sidebar_class('participant_events', $active_menu) ?>">

                    <a href="<?= base_url('participant/events') ?>"
                        class="sidebar-link">

                        <i class="bi bi-calendar2-event-fill"></i>
                        <span>Event</span>

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
