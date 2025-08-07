<?= $this->extend('painel/templates/default') ?>


<?= $this->section('content') ?>

<style>
    .kpi-card {
        border-radius: 15px;
        padding: 20px;
        color: white;
        margin-bottom: 20px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
        border: none;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .kpi-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
    }

    .kpi-text .kpi-title {
        font-size: 0.9rem;
        font-weight: 600;
        text-transform: uppercase;
        margin-bottom: 5px;
        opacity: 0.8;
    }

    .kpi-text .kpi-count {
        font-size: 2.2rem;
        font-weight: 700;
        line-height: 1;
    }

    .kpi-text .kpi-sum {
        font-size: 1rem;
        opacity: 0.9;
    }

    .kpi-chart {
        width: 120px;
        height: 60px;
    }

    /* Gradientes */
    .kpi-card.total {
        background: linear-gradient(135deg, #0d6efd, #0a58ca);
    }

    .kpi-card.pendente {
        background: linear-gradient(135deg, #198754, #146c43);
    }

    .kpi-card.paga {
        background: linear-gradient(135deg, #ffc107, #d39e00);
    }

    .kpi-card.vencida {
        background: linear-gradient(135deg, #dc3545, #b02a37);
    }

    .kpi-card.cancelada {
        background: linear-gradient(135deg, #6c757d, #545b62);
    }
</style>


<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Listagem de Faturas</h1>
    <div>
    </div>
</div>
<div class="row">
    <div class="col-lg col-md-6">
        <div class="kpi-card total">
            <div class="kpi-text">
                <div class="kpi-title">Total de Faturas</div>
                <div class="kpi-count"><?= $stats['total']['count'] ?></div>
                <div class="kpi-sum">R$ <?= number_format($stats['total']['sum'], 2, ',', '.') ?></div>
            </div>
            <div class="kpi-chart" id="chart-total"></div>
        </div>
    </div>
    <div class="col-lg col-md-6">
        <div class="kpi-card pendente">
            <div class="kpi-text">
                <div class="kpi-title">Faturas Pendentes</div>
                <div class="kpi-count"><?= $stats['Pendente']['count'] ?></div>
                <div class="kpi-sum">R$ <?= number_format($stats['Pendente']['sum'], 2, ',', '.') ?></div>
            </div>
            <div class="kpi-chart" id="chart-pendente"></div>
        </div>
    </div>
    <div class="col-lg col-md-6">
        <div class="kpi-card paga">
            <div class="kpi-text">
                <div class="kpi-title">Faturas Pagas</div>
                <div class="kpi-count"><?= $stats['Paga']['count'] ?></div>
                <div class="kpi-sum">R$ <?= number_format($stats['Paga']['sum'], 2, ',', '.') ?></div>
            </div>
            <div class="kpi-chart" id="chart-paga"></div>
        </div>
    </div>
    <div class="col-lg col-md-6">
        <div class="kpi-card vencida">
            <div class="kpi-text">
                <div class="kpi-title">Faturas Vencidas</div>
                <div class="kpi-count"><?= $stats['Vencida']['count'] ?></div>
                <div class="kpi-sum">R$ <?= number_format($stats['Vencida']['sum'], 2, ',', '.') ?></div>
            </div>
            <div class="kpi-chart" id="chart-vencida"></div>
        </div>
    </div>
    <div class="col-lg col-md-6">
        <div class="kpi-card cancelada">
            <div class="kpi-text">
                <div class="kpi-title">Faturas Canceladas</div>
                <div class="kpi-count"><?= $stats['Cancelada']['count'] ?></div>
                <div class="kpi-sum">R$ <?= number_format($stats['Cancelada']['sum'], 2, ',', '.') ?></div>
            </div>
            <div class="kpi-chart" id="chart-cancelada"></div>
        </div>
    </div>
</div>




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

                                    <a href="#" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal-<?= $fatura['id'] ?>" title="Excluir">
                                        <i class="fas fa-trash"></i>
                                    </a>
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
        <h5 id="offcanvasFiltersLabel">Filtros de Faturas</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Fechar"></button>
    </div>
    <div class="offcanvas-body">
        <form method="get" action="<?= base_url('dashboard/faturas') ?>">
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-select">
                    <option value="">Todos</option>
                    <option value="Pendente" <?= $filters['status'] == 'Pendente' ? 'selected' : '' ?>>Pendente</option>
                    <option value="Paga" <?= $filters['status'] == 'Paga' ? 'selected' : '' ?>>Paga</option>
                    <option value="Vencida" <?= $filters['status'] == 'Vencida' ? 'selected' : '' ?>>Vencida</option>
                    <option value="Cancelada" <?= $filters['status'] == 'Cancelada' ? 'selected' : '' ?>>Cancelada</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="valor_min" class="form-label">Valor Mínimo</label>
                <input type="number" name="valor_min" id="valor_min" class="form-control" step="0.01" value="<?= esc($filters['valor_min']) ?>">
            </div>

            <div class="mb-3">
                <label for="valor_max" class="form-label">Valor Máximo</label>
                <input type="number" name="valor_max" id="valor_max" class="form-control" step="0.01" value="<?= esc($filters['valor_max']) ?>">
            </div>

            <div class="mb-3">
                <label for="data_inicio" class="form-label">Data de Início</label>
                <input type="date" name="data_inicio" id="data_inicio" class="form-control" value="<?= esc($filters['data_inicio']) ?>">
            </div>

            <div class="mb-3">
                <label for="data_fim" class="form-label">Data de Fim</label>
                <input type="date" name="data_fim" id="data_fim" class="form-control" value="<?= esc($filters['data_fim']) ?>">
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Aplicar Filtros</button>
                <a href="<?= base_url('dashboard/faturas') ?>" class="btn btn-outline-light">Limpar</a>
            </div>
        </form>
    </div>
</div>


<?php if (!empty($faturas)): ?>
    <?php foreach ($faturas as $fatura): ?>
        <div class="modal fade" id="confirmDeleteModal-<?= $fatura['id'] ?>" tabindex="-1" aria-labelledby="modalLabel-<?= $fatura['id'] ?>" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content bg-dark text-white">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel-<?= $fatura['id'] ?>">Confirmar Exclusão</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Deseja realmente excluir a fatura ID #<?= esc($fatura['id']) ?> para o cliente "<?= esc($fatura['nome_cliente']) ?>"?</p>
                        <p class="text-warning"><small>Esta ação não pode ser desfeita.</small></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <a href="<?= base_url('dashboard/faturas/excluir/' . $fatura['id']) ?>" class="btn btn-danger">Confirmar Exclusão</a>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<?= $this->section('scripts') ?>
<script>
    // Função auxiliar para criar as opções de gráfico
    function getChartOptions(data, color) {
        return {
            series: [{
                data: data
            }],
            chart: {
                type: 'line',
                height: 60,
                sparkline: {
                    enabled: true
                }
            },
            stroke: {
                curve: 'smooth',
                width: 2
            },
            colors: [color],
            tooltip: {
                fixed: {
                    enabled: false
                },
                x: {
                    show: false
                },
                y: {
                    title: {
                        formatter: function(seriesName) {
                            return ''
                        }
                    }
                },
                marker: {
                    show: false
                }
            }
        };
    }

    // Dados de exemplo para as linhas de tendência.
    // No futuro, isso pode vir de uma consulta ao banco (ex: faturas nos últimos 7 dias)
    const totalData = [10, 41, 35, 51, 49, 62, 69, 91, 148];
    const pendenteData = [5, 15, 10, 25, 22, 30, 25, 35, 30];
    const pagaData = [80, 50, 65, 45, 70, 40, 80, 55, 95];
    const vencidaData = [3, 2, 5, 1, 4, 2, 3, 1, 2];
    const canceladaData = [1, 3, 2, 2, 1, 4, 2, 3, 1];

    // Renderiza cada gráfico no seu respectivo div
    new ApexCharts(document.querySelector("#chart-total"), getChartOptions(totalData, '#fff')).render();
    new ApexCharts(document.querySelector("#chart-pendente"), getChartOptions(pendenteData, '#212529')).render();
    new ApexCharts(document.querySelector("#chart-paga"), getChartOptions(pagaData, '#fff')).render();
    new ApexCharts(document.querySelector("#chart-vencida"), getChartOptions(vencidaData, '#fff')).render();
    new ApexCharts(document.querySelector("#chart-cancelada"), getChartOptions(canceladaData, '#fff')).render();
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>