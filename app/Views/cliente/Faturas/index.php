<?= $this->extend('cliente/templates/default') ?>

<?= $this->section('title') ?><?= esc($title ?? 'Minhas Faturas') ?><?= $this->endSection() ?>

<?= $this->section('content') ?>

<h1 class="h3 mb-4">Minhas Faturas</h1>

<div class="card shadow">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#ID</th>
                        <th>Descrição</th>
                        <th class="text-end">Valor</th>
                        <th class="text-center">Vencimento</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($faturas)): ?>
                        <?php foreach ($faturas as $fatura): ?>
                            <tr>
                                <td><?= esc($fatura['id']) ?></td>
                                <td><?= esc($fatura['descricao']) ?></td>
                                <td class="text-end">R$ <?= number_format($fatura['valor'], 2, ',', '.') ?></td>
                                <td class="text-center"><?= date('d/m/Y', strtotime($fatura['data_vencimento'])) ?></td>
                                <td class="text-center">
                                    <?php
                                        $statusClass = ['Paga' => 'success', 'Pendente' => 'warning', 'Vencida' => 'danger', 'Cancelada' => 'secondary'];
                                        $badgeClass = $statusClass[$fatura['status']] ?? 'light';
                                    ?>
                                    <span class="badge text-bg-<?= $badgeClass ?>"><?= esc($fatura['status']) ?></span>
                                </td>
                                <td class="text-center">
                                    <a href="<?= base_url('cliente/faturas/visualizar/' . $fatura['id']) ?>" class="btn btn-primary btn-sm">Visualizar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-4">Nenhuma fatura encontrada.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>