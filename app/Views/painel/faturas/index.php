<?= $this->extend('painel/templates/default') ?>

<?= $this->section('title') ?>Minhas Faturas<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Minhas Faturas</h1>
    <div>
        <button class="btn btn-secondary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasFilters" aria-controls="offcanvasFilters">
            <i class="fas fa-filter me-2"></i>Filtrar
        </button>
        <a href="<?= base_url('dashboard/faturas/nova') ?>" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Nova Fatura</a>
    </div>
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
                                    <a href="<?= base_url('dashboard/faturas/visualizar/' . $fatura['id']) ?>" class="btn btn-success btn-sm" title="Visualizar"><i class="fas fa-eye"></i></a>
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
        <div class="mt-4">
            <?= $pager->links('default', 'bootstrap_pagination') ?>
        </div>
    </div>
</div>

<div class="offcanvas offcanvas-end bg-dark text-white" tabindex="-1" id="offcanvasFilters" aria-labelledby="offcanvasFiltersLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasFiltersLabel"><i class="fas fa-filter me-2"></i>Filtrar Faturas</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form action="<?= base_url('dashboard/faturas') ?>" method="get">
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" name="status" id="status">
                    <option value="">Todos</option>
                    <option value="Pendente" <?= (isset($filters['status']) && $filters['status'] == 'Pendente') ? 'selected' : '' ?>>Pendente</option>
                    <option value="Paga" <?= (isset($filters['status']) && $filters['status'] == 'Paga') ? 'selected' : '' ?>>Paga</option>
                    <option value="Vencida" <?= (isset($filters['status']) && $filters['status'] == 'Vencida') ? 'selected' : '' ?>>Vencida</option>
                    <option value="Cancelada" <?= (isset($filters['status']) && $filters['status'] == 'Cancelada') ? 'selected' : '' ?>>Cancelada</option>
                </select>
            </div>
            <div class="row mb-3">
                <div class="col-6">
                    <label for="valor_min" class="form-label">Valor Mínimo</label>
                    <input type="number" step="0.01" class="form-control" name="valor_min" id="valor_min" value="<?= esc($filters['valor_min'] ?? '') ?>">
                </div>
                <div class="col-6">
                    <label for="valor_max" class="form-label">Valor Máximo</label>
                    <input type="number" step="0.01" class="form-control" name="valor_max" id="valor_max" value="<?= esc($filters['valor_max'] ?? '') ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-6">
                    <label for="data_inicio" class="form-label">Vencimento De</label>
                    <input type="date" class="form-control" name="data_inicio" id="data_inicio" value="<?= esc($filters['data_inicio'] ?? '') ?>">
                </div>
                <div class="col-6">
                    <label for="data_fim" class="form-label">Vencimento Até</label>
                    <input type="date" class="form-control" name="data_fim" id="data_fim" value="<?= esc($filters['data_fim'] ?? '') ?>">
                </div>
            </div>
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-success">Aplicar Filtros</button>
                <a href="<?= base_url('dashboard/faturas') ?>" class="btn btn-light">Limpar Filtros</a>
            </div>
        </form>
    </div>
</div>

<?php if (!empty($faturas)): ?>
    <?php foreach ($faturas as $fatura): ?>
    <?php endforeach; ?>
<?php endif; ?>

<?= $this->endSection() ?>