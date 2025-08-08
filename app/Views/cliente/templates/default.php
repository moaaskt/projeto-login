<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= csrf_meta() ?>
    <title><?= $this->renderSection('title') ?> | Portal do Cliente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    
    <style>
        body { background-color: #0d1117; color: #c9d1d9; }
        .wrapper { display: flex; }
        .sidebar { background-color: #161b22; min-height: 100vh; width: 250px; position: fixed; top: 0; left: 0; padding-top: 20px; border-right: 1px solid #30363d;}
        .main-panel { margin-left: 250px; width: calc(100% - 250px); } /* Ocupa o resto da tela */
        .main-content { padding: 20px; }
        .sidebar .nav-link { color: #8b949e; padding: 10px 15px; border-radius: 6px; margin-bottom: 5px; }
        .sidebar .nav-link:hover { color: #ffffff; background-color: #21262d; }
        .sidebar .nav-link.active { color: #ffffff; font-weight: bold; background-color: #8b949e3d; }
        
        /* Estilos para a nova Navbar */
        .topbar {
            background-color: #161b22;
            border-bottom: 1px solid #30363d;
            height: 70px;
        }
        .topbar .nav-link { color: #c9d1d9; }
        .topbar .dropdown-menu { border: 1px solid #30363d; }
    </style>
</head>
<body>
    <div class="wrapper">
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
            <!-- <div style="position: absolute; bottom: 20px; width: calc(100% - 40px); left:20px;">
                <a href="<?= base_url('logout') ?>" class="btn btn-danger w-100">Sair</a>
            </div> -->
        </div>

        <div class="main-panel">
            
            <nav class="navbar navbar-expand topbar px-4">
                <div class="container-fluid">
                    <div>
                        <h5 class="mb-0">Dashboard</h5>
                        <p class="mb-0 small text-muted">Resumo das suas faturas e pagamentos</p>
                    </div>

                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="me-2 d-none d-lg-inline"><?= esc(session()->get('usuario')['nome']) ?></span>
                                <img class="img-profile rounded-circle" width="32" height="32"
                                     src="https://ui-avatars.com/api/?name=<?= urlencode(session()->get('usuario')['nome']) ?>&background=405189&color=fff&size=32">
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow">
                                <li>
                                    <a class="dropdown-item" href="<?= base_url('cliente/perfil') ?>">
                                        <i class="fas fa-user fa-sm fa-fw me-2 text-muted"></i>
                                        Meu Perfil
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="<?= base_url('logout') ?>">
                                        <i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-muted"></i>
                                        Sair
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
            <div class="main-content">
                <?= $this->renderSection('content') ?>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <?= $this->renderSection('scripts') ?>
</body>
</html>