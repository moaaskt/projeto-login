<?= $this->extend('painel/templates/default') ?>

<?= $this->section('title') ?>Clientes<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Meus Clientes</h1>
    <a href="<?= base_url('dashboard/clientes/novo') ?>" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Novo Cliente</a>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<div class="card shadow">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome Completo</th>
                        <th>Email</th>
                        <th>Telefone</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($clientes)): ?>
                        <?php foreach ($clientes as $cliente): ?>
                            <tr>
                                <td><?= esc($cliente['id']) ?></td>
                                <td><?= esc($cliente['nome_completo']) ?></td>
                                <td><?= esc($cliente['email']) ?></td>
                                <td><?= esc($cliente['telefone']) ?></td>
                                <td class="text-center">
                                    <a href="<?= base_url('dashboard/clientes/editar/' . $cliente['id']) ?>" class="btn btn-info btn-sm" title="Editar"><i class="fas fa-pencil-alt"></i></a>
                                    <a href="#" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal-<?= $cliente['id'] ?>" title="Excluir"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">Nenhum cliente encontrado.</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
            </table>
        </div>
    </div>
</div>

<?php if (!empty($clientes)): ?>
    <?php foreach ($clientes as $cliente): ?>
        <div class="modal fade" id="confirmDeleteModal-<?= $cliente['id'] ?>" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content bg-dark text-white">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirmar Exclusão</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Deseja realmente excluir o cliente "<?= esc($cliente['nome_completo']) ?>"?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <a href="<?= base_url('dashboard/clientes/excluir/' . $cliente['id']) ?>" class="btn btn-danger">Excluir</a>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<?= $this->endSection() ?>