<?= $this->extend('painel/templates/default') ?>

<?= $this->section('title') ?>Clientes<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Meus Clientes</h1>
    <div>
        <button class="btn btn-secondary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasFilters" aria-controls="offcanvasFilters">
            <i class="fas fa-filter me-2"></i>Filtrar
        </button>

        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#importModal">
            <i class="fas fa-file-import me-2"></i>Importar Clientes
        </button>

        <a href="<?= base_url('dashboard/clientes/novo') ?>" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Novo Cliente</a>
    </div>
</div>

<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-white">
            <div class="modal-header">
                <h5 class="modal-title" id="importModalLabel">Importar Clientes via Planilha</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('dashboard/clientes/importar') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?> <div class="modal-body">
                    <p>Selecione um arquivo Excel (.xlsx) para importar. O arquivo deve ter os cabeçalhos na primeira linha, exatamente nesta ordem:</p>
                    <p class="text-info"><small><code>nome_completo, cpf_cnpj, email, telefone, endereco, cep, data_nascimento</code></small></p>
                    <p class="text-warning"><small><strong>Atenção:</strong> Linhas com CPF/CNPJ ou Email que já existam no sistema serão ignoradas.</small></p>
                    <div class="mb-3">
                        <label for="excel_file" class="form-label">Arquivo (.xlsx)</label>
                        <input class="form-control" type="file" name="excel_file" id="excel_file" required accept=".xlsx, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check me-2"></i>Enviar e Importar
                    </button>
                </div>
            </form>
        </div>
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
                                    <a href="<?= base_url('dashboard/clientes/visualizar/' . $cliente['id']) ?>" class="btn btn-success btn-sm" title="Visualizar"><i class="fas fa-eye"></i></a>
                                    <a href="<?= base_url('dashboard/clientes/editar/' . $cliente['id']) ?>" class="btn btn-info btn-sm" title="Editar"><i class="fas fa-pencil-alt"></i></a>
                                    <a href="#" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal-<?= $cliente['id'] ?>" title="Excluir"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">Nenhum cliente encontrado. Verifique os filtros aplicados.</td>
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
        <h5 class="offcanvas-title" id="offcanvasFiltersLabel"><i class="fas fa-filter me-2"></i>Filtros de Pesquisa</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form action="<?= base_url('dashboard/clientes') ?>" method="get">
            <div class="mb-3">
                <label for="termo" class="form-label">Nome, Email, CPF ou Telefone</label>
                <input type="text" class="form-control" name="termo" id="termo" placeholder="Digite para buscar..." value="<?= esc($filters['termo'] ?? '') ?>">
            </div>
            <div class="mb-3">
                <label for="data_cadastro" class="form-label">Data de Cadastro</label>
                <input type="date" class="form-control" name="data_cadastro" id="data_cadastro" value="<?= esc($filters['data_cadastro'] ?? '') ?>">
            </div>
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-success">Aplicar Filtros</button>
                <a href="<?= base_url('dashboard/clientes') ?>" class="btn btn-light">Limpar Filtros</a>
            </div>
        </form>
    </div>
</div>



<?php if (!empty($clientes)): ?>
    <?php foreach ($clientes as $cliente): ?>
        <div class="modal fade" id="confirmDeleteModal-<?= $cliente['id'] ?>" tabindex="-1" aria-labelledby="modalLabel-<?= $cliente['id'] ?>" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content bg-dark text-white">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel-<?= $cliente['id'] ?>">Confirmar Exclusão</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Deseja realmente excluir o cliente "<?= esc($cliente['nome_completo']) ?>"?</p>
                        <p class="text-warning"><small>Esta ação não pode ser desfeita.</small></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <a href="<?= base_url('dashboard/clientes/excluir/' . $cliente['id']) ?>" class="btn btn-danger">Confirmar Exclusão</a>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<?= $this->endSection() ?>