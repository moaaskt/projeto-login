<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Meu Perfil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body { background-color: #1e293b; color: white; }
        .sidebar { background-color: #151c28; color: white; min-height: 100vh; width: 250px; position: fixed; top: 0; left: 0; padding: 20px; }
        .main-content { margin-left: 250px; padding: 20px; }
        .nav-link { color: #8b949e; }
        .nav-link.active, .nav-link:hover { color: #ffffff; }
        .card { background-color: #2d3748; border: none; }
        .form-control { background-color: #4a5568; color: white; border-color: #4a5568; }
        .form-control:focus { background-color: #4a5568; color: white; border-color: #6366f1; box-shadow: 0 0 0 0.25rem rgba(99, 102, 241, 0.25); }
        .form-control::placeholder { color: #9ca3af; }
        .form-control:disabled, .form-control[readonly] { background-color: #3a475c; }
    </style>
</head>
<body>
    <div class="d-flex">
        <div class="sidebar">
            <h3 class="mb-4">Dashboard</h3>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?= base_url('dashboard') ?>" class="nav-link"><i class="fas fa-tachometer-alt fa-fw me-2"></i>Dashboard</a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('dashboard/faturas') ?>" class="nav-link"><i class="fas fa-file-invoice-dollar fa-fw me-2"></i>Faturas</a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('dashboard/perfil') ?>" class="nav-link active"><i class="fas fa-user-circle fa-fw me-2"></i>Perfil</a>
                </li>
            </ul>
            <div style="position: absolute; bottom: 20px; width: calc(100% - 40px);">
                 <a href="<?= base_url('logout') ?>" class="btn btn-danger w-100">Sair</a>
            </div>
        </div>

        <div class="main-content flex-grow-1">
            <h1 class="h3 mb-4">Meu Perfil</h1>
            <div class="row">
                <div class="col-lg-8">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3" style="background-color:#1e293b;">
                            <h6 class="m-0 font-weight-bold text-primary">Editar Informações</h6>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="mb-3">
                                    <label for="fullName" class="form-label">Nome Completo</label>
                                    <input type="text" class="form-control" id="fullName" value="Seu Chefe">
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Endereço de E-mail</label>
                                    <input type="email" class="form-control" id="email" value="chefe@empresa.com" readonly>
                                    <div class="form-text">O e-mail não pode ser alterado.</div>
                                </div>
                                <hr>
                                <h6 class="text-primary">Alterar Senha</h6>
                                <div class="mb-3">
                                    <label for="newPassword" class="form-label">Nova Senha</label>
                                    <input type="password" class="form-control" id="newPassword" placeholder="Deixe em branco para não alterar">
                                </div>
                                <div class="mb-3">
                                    <label for="confirmPassword" class="form-label">Confirmar Nova Senha</label>
                                    <input type="password" class="form-control" id="confirmPassword">
                                </div>
                                <button type="submit" class="btn btn-success">Salvar Alterações</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3" style="background-color:#1e293b;">
                            <h6 class="m-0 font-weight-bold text-primary">Foto do Perfil</h6>
                        </div>
                        <div class="card-body text-center">
                            <i class="fas fa-user-circle fa-7x text-secondary mb-3"></i>
                            <p>Em breve, você poderá adicionar sua foto aqui.</p>
                            <button class="btn btn-primary btn-sm" disabled>Alterar Foto</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>