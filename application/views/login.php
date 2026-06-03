<!DOCTYPE html>
<<<<<<< HEAD
<html lang="id">
=======
<html lang="en">
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f

<head>

    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0">

<<<<<<< HEAD
    <title>Login - EventConsole</title>
=======
    <title>Login - EventKu</title>
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f

    <script src="<?= base_url('assets/static/js/initTheme.js') ?>"></script>

    <link rel="stylesheet"
        href="<?= base_url('assets/compiled/css/app.css') ?>">
    <link rel="stylesheet"
        href="<?= base_url('assets/compiled/css/auth.css') ?>">
    <link rel="stylesheet"
        href="<?= base_url('assets/extensions/bootstrap-icons/font/bootstrap-icons.css') ?>">
    <link rel="stylesheet"
<<<<<<< HEAD
        href="<?= base_url('assets/compiled/css/EventConsole.css') ?>">
=======
        href="<?= base_url('assets/compiled/css/eventku.css') ?>">
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f

</head>

<body>

<div id="auth">

    <div class="row h-100">

        <div class="col-lg-5 col-12">

            <div id="auth-left">

                <div class="auth-logo mb-5 d-flex align-items-center gap-3">

                    <span class="auth-logo-mark">
                        <i class="bi bi-calendar2-check"></i>
                    </span>

                    <div>
<<<<<<< HEAD
                        <h2 class="fw-bold text-primary mb-0">EventConsole</h2>
=======
                        <h2 class="fw-bold text-primary mb-0">EventKu</h2>
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f
                        <small class="text-muted">Event & Sertifikat Online</small>
                    </div>

                </div>

                <h1 class="auth-title">Login</h1>

                <p class="auth-subtitle mb-5">
                    Masuk ke dashboard untuk mengelola event, pembayaran, dan sertifikat.
                </p>

<<<<<<< HEAD
                <?= flash_alert('success') ?>
                <?= flash_alert('error') ?>
                <?= validation_errors('<div class="alert alert-danger">', '</div>') ?>

=======
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f
                <form method="post">

                    <div class="form-group position-relative has-icon-left mb-4">

                        <input type="email"
                            name="email"
                            class="form-control form-control-xl"
<<<<<<< HEAD
                            value="<?= e(set_value('email')) ?>"
                            autocomplete="email"
=======
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f
                            placeholder="Email">

                        <div class="form-control-icon">
                            <i class="bi bi-envelope"></i>
                        </div>

                    </div>

                    <div class="form-group position-relative has-icon-left mb-4">

                        <input type="password"
                            name="password"
                            class="form-control form-control-xl"
<<<<<<< HEAD
                            autocomplete="current-password"
=======
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f
                            placeholder="Password">

                        <div class="form-control-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>

                    </div>

<<<<<<< HEAD
                    <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-4">
=======
                    <button class="btn btn-primary btn-block btn-lg shadow-lg mt-4">
>>>>>>> c4a5b189743f0cede54ed2d76fa94f9b76cc300f
                        <i class="bi bi-box-arrow-in-right me-2"></i>
                        Login
                    </button>

                </form>

                <div class="text-center mt-5 text-lg fs-4">

                    <p class="text-gray-600">
                        Belum punya akun?
                        <a href="<?= base_url('auth/register') ?>"
                            class="font-bold">
                            Register
                        </a>
                    </p>

                </div>

            </div>

        </div>

        <div class="col-lg-7 d-none d-lg-block">

            <div class="auth-art">
                <div>
                    <span class="badge bg-light text-primary mb-3">
                        CodeIgniter 3
                    </span>
                    <h2>Kelola event lebih rapi dari pendaftaran sampai sertifikat.</h2>
                    <p class="mt-3">
                        Admin memantau peserta dan pembayaran, peserta mendaftar event dan mengambil sertifikat PDF dalam satu alur yang bersih.
                    </p>
                </div>
            </div>

        </div>

    </div>

</div>

</body>
</html>
