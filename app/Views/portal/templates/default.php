<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <?= csrf_meta() ?>
    <title><?= $this->renderSection('title') ?> | Portal do Cliente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/dashboard/style.css') ?>">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* Seus estilos podem ser mantidos aqui */
        body { background-color: #1e293b; color: white; }
        .sidebar { background-color: #151c28; min-height: 100vh; width: 250px; position: fixed; top: 0; left: 0; padding: 20px; }
        .main-content { margin-left: 250px; padding: 20px; }
        .nav-link { color: #8b949e; }
        .nav-link.active, .nav-link:hover { color: #ffffff; }
        /* ... resto do seu CSS ... */
    </style>
</head>
<body>
    <div class="d-flex">
        <div class="sidebar">
            <h3 class="mb-4">Portal do Cliente</h3> 
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?= base_url('portal/faturas') ?>" class="nav-link"><i class="fas fa-file-invoice-dollar fa-fw me-2"></i>Minhas Faturas</a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('portal/perfil') ?>" class="nav-link"><i class="fas fa-user-circle fa-fw me-2"></i>Meu Perfil</a>
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
    </body>
</html>