<?= $this->extend('painel/templates/default') ?>

<?= $this->section('title') ?><?= isset($fatura) ? 'Editar Fatura' : 'Nova Fatura' ?><?= $this->endSection() ?>

<?= $this->section('content') ?>

<h1 class="h3 mb-4"><?= isset($fatura) ? 'Editando Fatura ID: ' . esc($fatura['id']) : 'Cadastrar Nova Fatura' ?></h1>

<div class="card">
    <div class="card-body">

        <form action="<?= base_url('dashboard/faturas/salvar') ?>" method="post">

            <input type="hidden" name="id" value="<?= isset($fatura) ? esc($fatura['id']) : '' ?>">

            <div class="mb-3">
                <label for="cliente_id" class="form-label">Cliente</label>
                <select class="form-select" id="cliente_id" name="cliente_id" required>
                    <option value="">Selecione um cliente</option>
                    <?php if (!empty($clientes)): ?>
                        <?php foreach ($clientes as $cliente): ?>
                            <option value="<?= $cliente['id'] ?>" <?= (isset($fatura) && $fatura['cliente_id'] == $cliente['id']) ? 'selected' : '' ?>>
                                <?php // ALTERAÇÃO: Trocado 'nome_completo' para 'nome' para bater com a coluna da tabela 'usuarios' 
                                ?>
                                <?= esc($cliente['nome']) ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição</label>
                <textarea class="form-control" id="descricao" name="descricao" rows="3" required><?= isset($fatura) ? esc($fatura['descricao']) : '' ?></textarea>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="valor" class="form-label">Valor (R$)</label>
                    <input type="text" class="form-control" id="valor" name="valor" value="<?= isset($fatura) ? esc($fatura['valor']) : '' ?>" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="data_vencimento" class="form-label">Data de Vencimento</label>
                    <input type="date" class="form-control" id="data_vencimento" name="data_vencimento" value="<?= isset($fatura) ? esc($fatura['data_vencimento']) : '' ?>" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status" required>
                        <?php $status = isset($fatura) ? $fatura['status'] : 'Pendente'; ?>
                        <option value="Pendente" <?= $status == 'Pendente' ? 'selected' : '' ?>>Pendente</option>
                        <option value="Paga" <?= $status == 'Paga' ? 'selected' : '' ?>>Paga</option>
                        <option value="Vencida" <?= $status == 'Vencida' ? 'selected' : '' ?>>Vencida</option>
                        <option value="Cancelada" <?= $status == 'Cancelada' ? 'selected' : '' ?>>Cancelada</option>
                    </select>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-success">Salvar Fatura</button>
                <a href="<?= base_url('dashboard/faturas') ?>" class="btn btn-secondary">Cancelar</a>
            </div>

        </form>

    </div>
</div>

<?= $this->endSection() ?>