<?= $this->extend('painel/templates/default') ?>

<?= $this->section('title') ?>Minhas Faturas<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Minhas Faturas</h1>
    <a href="<?= base_url('dashboard/faturas/nova') ?>" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Nova Fatura</a>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<div class="card shadow">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Valor</th>
                        <th>Vencimento</th>
                        <th>Status</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($faturas)): ?>
                        <?php foreach ($faturas as $fatura): ?>
                            <tr>
                                <td><?= esc($fatura['id']) ?></td>
                                <td><?= esc($fatura['nome_cliente']) ?></td>
                                <td>R$ <?= number_format(esc($fatura['valor']), 2, ',', '.') ?></td>
                                
                                <td><?= date('d/m/Y', strtotime(esc($fatura['data_vencimento']))) ?></td>
                                
                                <td>
                                    <?php 
                                        $statusClass = ['Paga' => 'success', 'Pendente' => 'warning', 'Vencida' => 'danger', 'Cancelada' => 'secondary'];
                                    ?>
                                    <span class="badge text-bg-<?= $statusClass[$fatura['status']] ?? 'light' ?>"><?= esc($fatura['status']) ?></span>
                                </td>
                                <td class="text-center">
                                    <a href="<?= base_url('dashboard/faturas/editar/' . $fatura['id']) ?>" class="btn btn-info btn-sm" title="Editar"><i class="fas fa-pencil-alt"></i></a>
                                    <a href="#" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal-<?= $fatura['id'] ?>" title="Excluir"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">Nenhuma fatura encontrada.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php if (!empty($faturas)): ?>
    <?php foreach ($faturas as $fatura): ?>
        <div class="modal fade" id="confirmDeleteModal-<?= $fatura['id'] ?>" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content bg-dark text-white">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirmar Exclusão</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>Deseja realmente excluir a fatura ID #<?= esc($fatura['id']) ?>?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <a href="<?= base_url('dashboard/faturas/excluir/' . $fatura['id']) ?>" class="btn btn-danger">Excluir</a>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<?= $this->endSection() ?>