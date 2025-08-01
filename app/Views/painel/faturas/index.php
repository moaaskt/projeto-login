<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Minhas Faturas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body { background-color: #1e293b; color: white; }
        .sidebar { background-color: #151c28; color: white; min-height: 100vh; width: 250px; position: fixed; top: 0; left: 0; padding: 20px; }
        .main-content { margin-left: 250px; padding: 20px; }
        .nav-link { color: #8b949e; }
        .nav-link.active, .nav-link:hover { color: #ffffff; }
        .card { background-color: #2d3748; border: none; }
        .table { --bs-table-bg: #2d3748; --bs-table-color: #ffffff; --bs-table-hover-color: #f8f9fa; --bs-table-hover-bg: #3a475c; border-color: #4a5568;}
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
                    <a href="<?= base_url('dashboard/faturas') ?>" class="nav-link active"><i class="fas fa-file-invoice-dollar fa-fw me-2"></i>Faturas</a>
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
            <h1 class="h3 mb-4">Minhas Faturas</h1>
            <div class="card shadow">
                <div class="card-header py-3" style="background-color:#1e293b;">
                    <h6 class="m-0 font-weight-bold text-primary">Listagem de Faturas</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID da Fatura</th>
                                    <th>Cliente</th>
                                    <th>Data de Vencimento</th>
                                    <th>Valor</th>
                                    <th>Status</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>INV-00123</td>
                                    <td>Empresa Exemplo A</td>
                                    <td>2025-08-15</td>
                                    <td>R$ 1.500,00</td>
                                    <td><span class="badge bg-success">Paga</span></td>
                                    <td>
                                        <a href="#" class="btn btn-info btn-sm" title="Visualizar"><i class="fas fa-eye"></i></a>
                                        <a href="#" class="btn btn-secondary btn-sm" title="Baixar PDF"><i class="fas fa-file-pdf"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>INV-00124</td>
                                    <td>Cliente B</td>