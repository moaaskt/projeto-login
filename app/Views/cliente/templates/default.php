<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="dark"> <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <?= csrf_meta() ?>
    <title><?= $this->renderSection('title') ?> | Portal do Cliente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    
    <style>
        body { background-color: #0d1117; color: #c9d1d9; }
        .sidebar { background-color: #161b22; min-height: 100vh; width: 250px; position: fixed; top: 0; left: 0; padding-top: 20px; border-right: 1px solid #30363d;}
        .main-content { margin-left: 250px; padding: 20px; }
        .sidebar .nav-link { color: #8b949e; padding: 10px 15px; border-radius: 6px; margin-bottom: 5px; }
        .sidebar .nav-link:hover { color: #ffffff; background-color: #21262d; }
        .sidebar .nav-link.active { color: #ffffff; font-weight: bold; background-color: #8b949e3d; }
    </style>
</head>
<body>
    <div class="d-flex">
        <div class="sidebar">
            <h5 class="px-3 mb-4">Portal do Cliente</h5> 
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?= base_url('cliente/dashboard') ?>" class="nav-link <?= url_is('cliente/dashboard*') ? 'active' : '' ?>">
                        <i class="fas fa-tachometer-alt fa-fw me-2"></i>Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('cliente/faturas') ?>" class="nav-link <?= url_is('cliente/faturas*') ? 'active' : '' ?>">
                        <i class="fas fa-file-invoice-dollar fa-fw me-2"></i>Minhas Faturas
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('cliente/perfil') ?>" class="nav-link <?= url_is('cliente/perfil*') ? 'active' : '' ?>">
                        <i class="fas fa-user-circle fa-fw me-2"></i>Meu Perfil
                    </a>
                </li>
            </ul>
            <div style="position: absolute; bottom: 20px; width: calc(100% - 40px); left:20px;">
                <a href="<?= base_url('logout') ?>" class="btn btn-danger w-100">Sair</a>
            </div>
        </div>

        <div class="main-content flex-grow-1">
            <?= $this->renderSection('content') ?>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <?= $this->renderSection('scripts') ?>
</body>
</html>