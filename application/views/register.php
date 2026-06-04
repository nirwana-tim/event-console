<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Register - EventConsole</title>

    <script src="<?= base_url('mazer/dist/assets/static/js/initTheme.js') ?>"></script>

    <link rel="stylesheet"
        href="<?= base_url('mazer/dist/assets/compiled/css/app.css') ?>">
    <link rel="stylesheet"
        href="<?= base_url('mazer/dist/assets/compiled/css/auth.css') ?>">
    <link rel="stylesheet"
        href="<?= base_url('mazer/dist/assets/extensions/bootstrap-icons/font/bootstrap-icons.css') ?>">
    <link rel="stylesheet"
        href="<?= base_url('mazer/dist/assets/compiled/css/EventConsole.css?v=1.0.1') ?>">

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
                        <h2 class="fw-bold text-primary mb-0">EventConsole</h2>
                        <small class="text-muted">Create a participant account</small>
                    </div>

                </div>

                <h1 class="auth-title">Register</h1>

                <p class="auth-subtitle mb-4">
                    Register as a participant to join events and access certificates.
                </p>

                <?= validation_errors(
                    '<div class="alert alert-danger">',
                    '</div>'
                ) ?>
                <?= flash_alert('error') ?>

                <form method="post">

                    <div class="form-group position-relative has-icon-left mb-4">

                        <input type="text"
                            name="name"
                            class="form-control form-control-xl"
                            value="<?= e(set_value('name')) ?>"
                            autocomplete="name"
                            placeholder="Full Name">

                        <div class="form-control-icon">
                            <i class="bi bi-person"></i>
                        </div>

                    </div>

                    <div class="form-group position-relative has-icon-left mb-4">

                        <input type="email"
                            name="email"
                            class="form-control form-control-xl"
                            value="<?= e(set_value('email')) ?>"
                            autocomplete="email"
                            placeholder="Email">

                        <div class="form-control-icon">
                            <i class="bi bi-envelope"></i>
                        </div>

                    </div>

                    <div class="form-group position-relative has-icon-left mb-4">

                        <input type="password"
                            name="password"
                            class="form-control form-control-xl"
                            autocomplete="new-password"
                            placeholder="Password">

                        <div class="form-control-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>

                    </div>

                    <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-4">
                        <i class="bi bi-person-plus me-2"></i>
                        Register
                    </button>

                </form>

                <div class="text-center mt-5 text-lg fs-4">

                    <p class="text-gray-600">
                        Already have an account?
                        <a href="<?= base_url('auth/login') ?>"
                            class="font-bold">
                            Login
                        </a>
                    </p>

                </div>

            </div>

        </div>

        <div class="col-lg-7 d-none d-lg-block">

            <div class="auth-art">
                <div>
                    <span class="badge bg-light text-primary mb-3">
                        Event Participant
                    </span>
                    <h2>One account to register for events, upload payments, and download certificates.</h2>
                    <p class="mt-3">
                        Complete your participant details, choose an event, then track your certificate after the admin verifies your payment.
                    </p>
                </div>
            </div>

        </div>

    </div>

</div>

</body>
</html>
