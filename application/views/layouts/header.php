<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= e($page_title) ?> | EventConsole</title>

    <script src="<?= base_url('mazer/dist/assets/static/js/initTheme.js') ?>"></script>

    <link rel="stylesheet"
        href="<?= base_url('mazer/dist/assets/compiled/css/app.css') ?>">

    <link rel="stylesheet"
        href="<?= base_url('mazer/dist/assets/compiled/css/app-dark.css') ?>">

    <link rel="stylesheet"
        href="<?= base_url('mazer/dist/assets/extensions/bootstrap-icons/font/bootstrap-icons.css') ?>">

    <link rel="stylesheet"
        href="<?= base_url('mazer/dist/assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') ?>">

    <link rel="stylesheet"
        href="<?= base_url('mazer/dist/assets/compiled/css/EventConsole.css?v=1.0.1') ?>">

    <style>
        .x-small { font-size: 0.75rem !important; }
        .letter-spacing-1 { letter-spacing: 1px; }
        .fw-bold { font-weight: 700 !important; }
        .bg-light-success { background-color: #e8f5e9 !important; }
        .bg-light-primary { background-color: #f0f7ff !important; }
        .bg-light-info { background-color: #e6faff !important; }
        .bg-light-warning { background-color: #fffaf0 !important; }
        
        .event-card-modern {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .event-card-modern:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
        }
        
        .event-banner-container {
            position: relative;
            width: 100%;
        }
        .banner-overlay {
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: linear-gradient(0deg, rgba(0,0,0,0.85) 0%, rgba(0,0,0,0.3) 100%);
        }
        .text-shadow {
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }
        
        .stats-icon {
            width: 54px;
            height: 54px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>

<body>

    <div id="app">
