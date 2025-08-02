<?= $this->extend('painel/templates/default') ?>

<?= $this->section('title') ?>Minhas Faturas<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <h1 class="h3 mb-4">Minhas Faturas</h1>
    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID da Fatura</th> <th>Cliente</th> <th>Vencimento</th> <th>Valor</th> <th>Status</th> <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>INV-00123</td> <td>Empresa A</td> <td>2025-08-15</td> <td>R$ 1.500,00</td> <td><span class="badge bg-success">Paga</span></td>
                            <td><a href="#" class="btn btn-info btn-sm" title="Visualizar"><i class="fas fa-eye"></i></a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>