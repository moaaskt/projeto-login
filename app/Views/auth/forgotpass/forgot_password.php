
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Recuperar Senha | Doar Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
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
        .form-header p { color: #64748b; margin-bottom: 0; }
        .form-control { height: 50px; border: 1px solid #e2e8f0; border-radius: 8px; }
        .btn-primary { background: var(--primary-color); border: none; padding: 12px; font-weight: 600; border-radius: 8px; }
    </style>
</head>
<body>

<main class="form-container">
    <div class="form-header">
        <h1>Recuperar Senha</h1>
        <p>Digite seu e-mail e enviaremos um link para você redefinir sua senha.</p>
    </div>

    <!-- Exibe mensagens de sucesso ou erro -->
    <?php if (session()->getFlashdata('msg_success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('msg_success') ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('msg_error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('msg_error') ?></div>
    <?php endif; ?>

    <form action="<?= site_url('send-reset-link') ?>" method="post">
        <?= csrf_field() ?>
        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="d-grid">
            <button type="submit" class="btn btn-primary btn-lg">Enviar Link de Redefinição</button>
        </div>
    </form>
    <div class="text-center mt-4">
        <a href="<?= site_url('/') ?>" style="text-decoration: none; color: var(--primary-color);">Voltar para o Login</a>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
