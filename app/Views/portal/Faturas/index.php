<?= $this->extend('portal/templates/default') ?>

<?= $this->section('title') ?><?= esc($title) ?><?= $this->endSection() ?>

<?= $this->section('content') ?>

<h1 class="h3 mb-4">Minhas Faturas</h1>

<div class="card">
    <div class="card-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#ID</th>
                    <th>Descrição</th>
                    <th>Valor</th>
                    <th>Vencimento</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($faturas)): ?>
                    <tr>
                        <td colspan="6" class="text-center">Nenhuma fatura encontrada.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($faturas as $fatura): ?>
                        <tr>
                            <td><?= esc($fatura['id']) ?></td>
                            <td><?= esc($fatura['descricao']) ?></td>
                            <td>R$ <?= number_format($fatura['valor'], 2, ',', '.') ?></td>
                            <td><?= date('d/m/Y', strtotime($fatura['data_vencimento'])) ?></td>
                            <td>
                                <span class="badge bg-<?= $fatura['status'] === 'paga' ? 'success' : 'warning' ?>"><?= ucfirst($fatura['status']) ?></span>
                            </td>
                            <td>
                                <a href="<?= base_url('portal/faturas/visualizar/' . $fatura['id']) ?>" class="btn btn-primary btn-sm">
                                    <i class="fas fa-eye"></i> Visualizar
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>