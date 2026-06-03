<!DOCTYPE html>
<<<<<<< HEAD
<html lang="id">
=======
<html lang="en">
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

<<<<<<< HEAD
    <title><?= e($page_title) ?></title>
=======
    <title>EventKu</title>
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f

    <script src="<?= base_url('assets/static/js/initTheme.js') ?>"></script>

    <link rel="stylesheet"
        href="<?= base_url('assets/compiled/css/app.css') ?>">

    <link rel="stylesheet"
        href="<?= base_url('assets/compiled/css/app-dark.css') ?>">

    <link rel="stylesheet"
        href="<?= base_url('assets/extensions/bootstrap-icons/font/bootstrap-icons.css') ?>">

    <link rel="stylesheet"
<<<<<<< HEAD
        href="<?= base_url('assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') ?>">

    <link rel="stylesheet"
        href="<?= base_url('assets/compiled/css/EventConsole.css') ?>">
=======
        href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <link rel="stylesheet"
        href="<?= base_url('assets/compiled/css/eventku.css') ?>">
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f
</head>

<body>

<div id="app">
    <header class="mb-3 app-topbar">

    <nav class="navbar navbar-expand navbar-light">

        <div class="container-fluid">

            <a href="#" class="burger-btn d-block d-xl-none text-primary">
                <i class="bi bi-list fs-3"></i>
            </a>

            <div class="d-flex align-items-center justify-content-end w-100">

                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">

                    <li class="nav-item me-3">

                        <div class="theme-toggle d-flex gap-2 align-items-center">
                            <i class="bi bi-sun-fill text-warning"></i>

                            <div class="form-check form-switch fs-6 mb-0">
                                <input class="form-check-input me-0"
                                    type="checkbox"
                                    id="toggle-dark">
                            </div>

                            <i class="bi bi-moon-stars-fill text-primary"></i>
                        </div>

                    </li>

                    <li class="nav-item me-3">

                        <span class="nav-link active d-flex align-items-center gap-2 user-chip">

                            <span class="avatar avatar-sm">
                                <span class="avatar-content bg-primary text-white">
<<<<<<< HEAD
                                    <?= e($current_user_initial) ?>
=======
                                    <?= strtoupper(substr($this->session->userdata('nama'), 0, 1)) ?>
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f
                                </span>
                            </span>

                            <span class="d-none d-md-inline">
<<<<<<< HEAD
                                <?= e($current_user_name) ?>
=======
                                <?= html_escape($this->session->userdata('nama')) ?>
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f
                            </span>

                        </span>

                    </li>

                </ul>

            </div>

        </div>

    </nav>

</header>
