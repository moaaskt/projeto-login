<?= $this->extend('painel/templates/default') ?>

<?= $this->section('title') ?><?= isset($cliente) ? 'Editar Cliente' : 'Novo Cliente' ?><?= $this->endSection() ?>

<?= $this->section('content') ?>

<h1 class="h3 mb-4"><?= isset($cliente) ? 'Editando Cliente: ' . esc($cliente['nome_completo']) : 'Cadastrar Novo Cliente' ?></h1>

<div class="card">
    <div class="card-body">
        <?php if (session()->get('errors')): ?>
            <div class="alert alert-danger">
                <p><strong>Por favor, corrija os erros abaixo:</strong></p>
                <ul>
                    <?php foreach (session()->get('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach ?>
                </ul>
            </div>
        <?php endif; ?>


        <form action="<?= base_url('dashboard/clientes/salvar') ?>" method="post"
            data-check-email-url="<?= base_url('dashboard/clientes/check-email') ?>"
            data-check-cpf-url="<?= base_url('dashboard/clientes/check-cpf-cnpj') ?>">

            <?= csrf_field() ?>

            <input type="hidden" name="id" value="<?= old('id', $cliente['id'] ?? '') ?>">



            <div class="row">
                <div class="col-md-8 mb-3">
                    <label for="nome_completo" class="form-label">Nome Completo / Razão Social</label>
                    <input type="text" class="form-control" id="nome_completo" name="nome_completo" value="<?= old('nome_completo', $cliente['nome_completo'] ?? '') ?>" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="cpf_cnpj" class="form-label">CPF / CNPJ</label>
                    <input type="text" class="form-control" id="cpf_cnpj" name="cpf_cnpj" value="<?= old('cpf_cnpj', $cliente['cpf_cnpj'] ?? '') ?>">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= old('email', $cliente['email'] ?? '') ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="telefone" class="form-label">Telefone</label>
                    <input type="text" class="form-control" id="telefone" name="telefone" value="<?= old('telefone', $cliente['telefone'] ?? '') ?>">
                </div>
            </div>

            <hr>
            <h5 class="text-primary">Endereço</h5>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="cep" class="form-label">CEP</label>
                    <input type="text" class="form-control" id="cep" name="cep" placeholder="Apenas números" value="<?= old('cep', $cliente['cep'] ?? '') ?>">
                </div>
                <div class="col-md-8 mb-3">
                    <label for="logradouro" class="form-label">Logradouro (Rua, Avenida...)</label>
                    <input type="text" class="form-control" id="logradouro" name="logradouro" value="<?= old('logradouro', $cliente['logradouro'] ?? '') ?>">
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="numero" class="form-label">Número</label>
                    <input type="text" class="form-control" id="numero" name="numero" value="<?= old('numero', $cliente['numero'] ?? '') ?>">
                </div>
                <div class="col-md-8 mb-3">
                    <label for="bairro" class="form-label">Bairro</label>
                    <input type="text" class="form-control" id="bairro" name="bairro" value="<?= old('bairro', $cliente['bairro'] ?? '') ?>">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="cidade" class="form-label">Cidade</label>
                    <input type="text" class="form-control" id="cidade" name="cidade" value="<?= old('cidade', $cliente['cidade'] ?? '') ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="estado" class="form-label">Estado (UF)</label>
                    <input type="text" class="form-control" id="estado" name="estado" value="<?= old('estado', $cliente['estado'] ?? '') ?>">
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="data_nascimento" class="form-label">Data de Nascimento</label>
                    <input type="text" class="form-control" id="data_nascimento" name="data_nascimento" placeholder="DD/MM/AAAA" value="<?= old('data_nascimento', $cliente['data_nascimento'] ?? '') ?>">
                </div>
            </div>

            <?php if (!isset($cliente)): // Mostra apenas na criação de um novo cliente 
            ?>
                <h5 class="text-primary">Acesso ao Portal</h5>
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" role="switch" id="criar_acesso" name="criar_acesso" value="1">
                    <label class="form-check-label" for="criar_acesso">Criar um usuário de acesso ao portal para este cliente?</label>
                </div>
                <p class="text-muted"><small>Se marcado, um usuário será criado usando o e-mail do cliente e uma senha temporária será gerada. O cliente precisará redefinir a senha no primeiro acesso (funcionalidade futura).</small></p>
            <?php endif; ?>

            <div class="mt-4">
                <button type="submit" id="btn-salvar" class="btn btn-success">Salvar</button>
                <a href="<?= base_url('dashboard/clientes') ?>" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>




        <!-- <div class="mt-4">
            <button type="submit" class="btn btn-success">Salvar</button>
            <a href="<?= base_url('dashboard/clientes') ?>" class="btn btn-secondary">Cancelar</a>
        </div>
        </form>
    </div>
</div> -->

        <?= $this->endSection() ?>