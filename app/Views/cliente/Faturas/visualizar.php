<?= $this->extend('cliente/templates/default') ?>

<?= $this->section('title') ?><?= esc($title) ?><?= $this->endSection() ?>

<?= $this->section('content') ?>

<a href="<?= base_url('cliente/faturas') ?>" class="btn btn-secondary mb-3"><i class="fas fa-arrow-left"></i> Voltar para a lista</a>

<h1 class="h3 mb-4">Detalhes da Fatura #<?= esc($fatura['id']) ?></h1>

<div class="card">
    <div class="card-body">
        <h3><?= esc($fatura['descricao']) ?></h3>
        <hr>
        <dl class="row">
            <dt class="col-sm-3">Status:</dt>
            <dd class="col-sm-9">
                <?php
                // Lógica de status melhorada para aceitar minúsculas e maiúsculas
                $status = strtolower($fatura['status']);
                $badgeClass = 'bg-warning text-dark'; // Pendente por padrão
                if ($status === 'paga') {
                    $badgeClass = 'bg-success';
                } elseif ($status === 'vencida') {
                    $badgeClass = 'bg-danger';
                }
                ?>
                <span class="badge <?= $badgeClass ?>"><?= ucfirst($fatura['status']) ?></span>
            </dd>

            <dt class="col-sm-3">Valor:</dt>
            <dd class="col-sm-9"><strong>R$ <?= number_format($fatura['valor'], 2, ',', '.') ?></strong></dd>

            <dt class="col-sm-3">Data de Emissão:</dt>
            <dd class="col-sm-9"><?= date('d/m/Y', strtotime($fatura['created_at'])) ?></dd>

            <dt class="col-sm-3">Data de Vencimento:</dt>
            <dd class="col-sm-9"><?= date('d/m/Y', strtotime($fatura['data_vencimento'])) ?></dd>
        </dl>
        <hr>

        <div class="d-flex gap-2">
            <?php if (strtolower($fatura['status']) !== 'paga'): ?>
                <button type="button" class="btn btn-success btn-pagar-fatura"
                        data-fatura-id="<?= esc($fatura['id']) ?>"
                        data-valor="<?= esc($fatura['valor']) ?>">
                    <i class="fas fa-dollar-sign"></i> Pagar Fatura
                </button>
            <?php else: ?>
                <p class="text-success"><i class="fas fa-check-circle"></i> Esta fatura já foi paga. Obrigado!</p>
            <?php endif; ?>
            
            <!-- Botões para download de PDF -->
            <a href="<?= base_url('cliente/faturas/gerar-pdf/' . $fatura['id']) ?>" class="btn btn-primary" target="_blank">
                <i class="fas fa-file-pdf"></i> Baixar Comprovante
            </a>
            
            <a href="<?= base_url('cliente/faturas/gerar-boleto/' . $fatura['id']) ?>" class="btn btn-secondary" target="_blank">
                <i class="fas fa-barcode"></i> Baixar Boleto
            </a>
        </div>
    </div>
</div>


<div class="modal fade" id="modalPagamento" tabindex="-1" aria-hidden="true" data-url-processar="<?= site_url('cliente/faturas/processar_pagamento_ficticio') ?>">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pagar Fatura #<span id="modal-fatura-id"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Selecione o método de pagamento:</p>
                <div class="d-grid gap-2 mb-3">
                    <button class="btn btn-info btn-gerar-pagamento" data-metodo="pix"><i class="fas fa-qrcode"></i> Pagar com PIX</button>
                    <button class="btn btn-secondary btn-gerar-pagamento" data-metodo="boleto"><i class="fas fa-barcode"></i> Gerar Boleto</button>
                </div>

                <div id="area-resultado" class="text-center mt-3" style="display:none;">
                    <div id="loading" class="spinner-border text-primary" role="status" style="display:none;">
                        <span class="visually-hidden">Gerando...</span>
                    </div>
                    <div id="resultado-content"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>