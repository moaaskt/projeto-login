<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title><?= $this->renderSection('title') ?> | CRM Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/dashboard/style.css') ?>">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <style>
        body {
            background-color: #1e293b;
            color: white;
        }

        .sidebar {
            background-color: #151c28;
            color: white;
            min-height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            padding: 20px;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
        }

        .nav-link {
            color: #8b949e;
        }

        .nav-link.active,
        .nav-link:hover {
            color: #ffffff;
        }

        .card {
            background-color: #2d3748;
            border: none;
        }

        .table {
            --bs-table-bg: #2d3748;
            --bs-table-color: #ffffff;
            --bs-table-hover-color: #f8f9fa;
            --bs-table-hover-bg: #3a475c;
            border-color: #4a5568;
        }

        .form-control {
            background-color: #4a5568;
            color: white;
            border-color: #4a5568;
        }

        .form-control:focus {
            background-color: #4a5568;
            color: white;
            border-color: #6366f1;
            box-shadow: 0 0 0 0.25rem rgba(99, 102, 241, 0.25);
        }

        .form-control::placeholder {
            color: #9ca3af;
        }

        .form-control:disabled,
        .form-control[readonly] {
            background-color: #3a475c;
        }
    </style>
</head>

<body>
    <div class="d-flex">
        <div class="sidebar">
            <h3 class="mb-4">Dashboard CRM</h3>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?= base_url('dashboard') ?>" class="nav-link"><i class="fas fa-tachometer-alt fa-fw me-2"></i>Dashboard</a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('dashboard/faturas') ?>" class="nav-link"><i class="fas fa-file-invoice-dollar fa-fw me-2"></i>Faturas</a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('dashboard/clientes') ?>" class="nav-link"><i class="fas fa-users fa-fw me-2"></i>Clientes</a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('dashboard/perfil') ?>" class="nav-link"><i class="fas fa-user-circle fa-fw me-2"></i>Perfil</a>
                </li>
            </ul>
            <div style="position: absolute; bottom: 20px; width: calc(100% - 40px);">
                <a href="<?= base_url('logout') ?>" class="btn btn-danger w-100">Sair</a>
            </div>
        </div>

        <div class="main-content flex-grow-1">

            <?= $this->renderSection('content') ?>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script src="<?= base_url('js/dashboard.js') ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <?= $this->renderSection('scripts') ?>
    <?= $this->section('pageScripts') ?>
<?= $this->endSection() ?>
</body>

</html>