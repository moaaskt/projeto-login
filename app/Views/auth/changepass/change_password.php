<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Alterar Senha | Doar Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --primary-color: #6366f1; }
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .form-container {
            background: #ffffff;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 2.5rem;
            width: 100%;
            max-width: 420px;
        }
        .form-header { text-align: center; margin-bottom: 2rem; }
        .form-header h1 { font-weight: 700; font-size: 1.75rem; margin-bottom: 0.5rem; }
        .form-control { height: 50px; border: 1px solid #e2e8f0; border-radius: 8px; }
        .btn-primary { background: var(--primary-color); border: none; padding: 12px; font-weight: 600; border-radius: 8px; }
    </style>
</head>
<body>

<main class="form-container">
    <div class="form-header">
        <h1>Crie sua Senha Definitiva</h1>
        <p class="text-muted">Por segurança, o seu primeiro acesso requer a criação de uma nova senha pessoal.</p>
    </div>

    <!-- Exibe erros de validação -->
    <?php if (session()->get('errors')): ?>
        <div class="alert alert-danger">
            <?php foreach (session()->get('errors') as $error): ?>
                <p class="mb-0"><?= esc($error) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form action="<?= site_url('force-change-password') ?>" method="post">
        <?= csrf_field() ?>

        <div class="mb-3">
            <label for="password" class="form-label">Nova Senha</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="mb-3">
            <label for="password_confirm" class="form-label">Confirmar Nova Senha</label>
            <input type="password" class="form-control" id="password_confirm" name="password_confirm" required>
        </div>
        <div class="d-grid mt-4">
            <button type="submit" class="btn btn-primary btn-lg">Salvar e Aceder ao Painel</button>
        </div>
    </form>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
