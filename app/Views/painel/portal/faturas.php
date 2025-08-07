<?= $this->extend('painel/templates/default') ?>

<?= $this->section('title') ?><?= esc($title ?? 'Minhas Faturas') ?><?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Minhas Faturas</h1>
</div>

<div class="card shadow">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Descrição</th>
                        <th>Valor</th>
                        <th>Vencimento</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($faturas)): ?>
                        <?php foreach ($faturas as $fatura): ?>
                            <tr>
                                <td><?= esc($fatura['id']) ?></td>
                                <td><?= esc($fatura['descricao']) ?></td>
                                <td>R$ <?= number_format(esc($fatura['valor']), 2, ',', '.') ?></td>
                                <td><?= date('d/m/Y', strtotime(esc($fatura['data_vencimento']))) ?></td>
                                <td>
                                    <?php 
                                        $statusClass = ['Paga' => 'success', 'Pendente' => 'warning', 'Vencida' => 'danger', 'Cancelada' => 'secondary'];
                                    ?>
                                    <span class="badge text-bg-<?= $statusClass[$fatura['status']] ?? 'light' ?>"><?= esc($fatura['status']) ?></span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">Nenhuma fatura encontrada.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            <?= $pager->links('default', 'bootstrap_pagination') ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>