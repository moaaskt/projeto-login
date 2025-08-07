<?= $this->extend('painel/templates/default') ?>

<?= $this->section('title') ?><?= esc($title ?? 'Meu Portal') ?><?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Meu Portal</h1>
    </div>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card border-left-primary shadow h-100 py-2" style="border-left: 5px solid #6366f1;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total de Faturas</div>
                            <div class="h5 mb-0 font-weight-bold"><?= $stats['total']['count'] ?></div>
                        </div>
                        <div class="col-auto"><i class="fas fa-file-invoice-dollar fa-2x text-secondary"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card border-left-warning shadow h-100 py-2" style="border-left: 5px solid #f59e0b;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Faturas Pendentes</div>
                            <div class="h5 mb-0 font-weight-bold"><?= $stats['Pendente']['count'] ?></div>
                        </div>
                        <div class="col-auto"><i class="fas fa-clock fa-2x text-secondary"></i></div>
                    </div>
                </div>
            </div>
        </div>
         <div class="col-md-4 mb-4">
            <div class="card border-left-danger shadow h-100 py-2" style="border-left: 5px solid #ef4444;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Faturas Vencidas</div>
                            <div class="h5 mb-0 font-weight-bold"><?= $stats['Vencida']['count'] ?></div>
                        </div>
                        <div class="col-auto"><i class="fas fa-exclamation-triangle fa-2x text-secondary"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Bem-vindo(a) ao seu portal!</h6>
                </div>
                <div class="card-body">
                    <p>Aqui você pode gerenciar suas faturas e informações de perfil.</p>
                </div>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>