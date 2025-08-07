<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cadastro | Doar Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #6366f1;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .register-container {
            background: #ffffff;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 2.5rem;
            width: 100%;
            max-width: 480px;
        }

        .register-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .register-header img {
            width: 80px;
            height: auto;
            margin-bottom: 1rem;
        }

        .register-header h1 {
            font-weight: 700;
            font-size: 1.75rem;
        }

        .form-control {
            height: 50px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            background-color: #f8fafc;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.2);
        }

        .btn-primary {
            background: var(--primary-color);
            border: none;
            padding: 12px;
            font-weight: 600;
            border-radius: 8px;
        }

        .footer-text {
            text-align: center;
            margin-top: 1.5rem;
        }

        .footer-text a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
        }
    </style>
</head>

<body>
    <main class="register-container">
        <div class="register-header">
            <img src="https://doardigital.com.br/wp-content/uploads/2022/11/Webp.net-resizeimage-1.png" alt="Logo Doar Digital">
           <h1>Cadastro de Novo Usuário do Painel</h1>
        </div>

        <form action="<?= base_url('cadastro/salvar') ?>" method="post">

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

            <div class="mb-3">
                <label for="nome" class="form-label">Nome Completo</label>
                <input type="text" name="nome" id="nome" class="form-control" placeholder="Seu nome completo" required value="<?= old('nome') ?>">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="seu@email.com" required value="<?= old('email') ?>">
            </div>
            <div class="mb-3">
                <label for="senha" class="form-label">Senha</label>
                <input type="password" name="senha" id="senha" class="form-control" placeholder="Crie uma senha forte" required>
            </div>
            <div class="mb-4">
                <label for="confirmar_senha" class="form-label">Confirmar Senha</label>
                <input type="password" name="confirmar_senha" id="confirmar_senha" class="form-control" placeholder="Repita a senha" required>
            </div>
            <div class="d-grid">
                <button class="btn btn-primary btn-lg" type="submit">Cadastrar</button>
            </div>
            <div class="footer-text">
                <p>Já tem uma conta? <a href="<?= base_url('/') ?>">Faça login</a></p>
            </div>
        </form>
    </main>
</body>

</html>