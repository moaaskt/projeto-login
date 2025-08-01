<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #1e293b;
            color: white;
            font-family: 'Inter', sans-serif;
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
            color: #8b949e !important;
        }
        .nav-link.active, .nav-link:hover {
            color: #ffffff !important;
        }
        .card {
            background-color: #2d3748;
            border: none;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <h3 class="mb-4">Dashboard</h3>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="<?= base_url('dashboard') ?>" class="nav-link active"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('dashboard/faturas') ?>" class="nav-link"><i class="fas fa-file-invoice-dollar"></i> Faturas</a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('dashboard/perfil') ?>" class="nav-link"><i class="fas fa-user-circle"></i> Perfil</a>
            </li>
        </ul>
    </div>

    <div class="main-content">
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Bem-vindo de volta!</h5>
                        <p class="card-text">Seu e-mail é: <?= esc($email ?? 'Não encontrado') ?></p>
                        <a href="<?= base_url('logout') ?>" class="btn btn-danger">Sair</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h5 class="card-title">Tickets Criados</h5>
                        <h1 class="display-4">120</h1>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5 class="card-title">Tickets Resolvidos</h5>
                        <h1 class="display-4">90</h1>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-dark">
                    <div class="card-body">
                        <h5 class="card-title">Tickets Pendentes</h5>
                        <h1 class="display-4">30</h1>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-danger text-white">
                    <div class="card-body">
                        <h5 class="card-title">Tickets Cancelados</h5>
                        <h1 class="display-4">5</h1>
                    </div>
                </div>
            </div>
        </div>
        </div>

</body>
</html>