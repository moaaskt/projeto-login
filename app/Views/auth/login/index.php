<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | Doar Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
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
        .login-container {
            background: #ffffff;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 2.5rem;
            width: 100%;
            max-width: 420px;
        }
        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .login-header img {
            width: 80px;
            height: auto;
            margin-bottom: 1rem;
        }
        .login-header h1 {
            font-weight: 700;
            font-size: 1.75rem;
            margin-bottom: 0.5rem;
        }
        .login-header p {
            color: #64748b;
            margin-bottom: 0;
        }
        .form-control {
            height: 50px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            background-color: #f8fafc;
        }
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(99, 102, 241, 0.2);
            background-color: #fff;
        }
        .input-group-text {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-right: 0;
            border-radius: 8px 0 0 8px;
            color: #94a3b8;
        }
        .form-control-icon {
            border-left: 0;
            padding-left: 0;
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
            color: #64748b;
            margin-top: 2rem;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

<main class="login-container">
    <div class="login-header">
        <img src="https://doardigital.com.br/wp-content/uploads/2022/11/Webp.net-resizeimage-1.png" alt="Logo Doar Digital">
        <h1>Faça seu login</h1>
        <p>Acesse o painel de controle do seu projeto</p>
    </div>

    <form action="<?= base_url('login/auth') ?>" method="post">
        
        <!-- Bloco de mensagens de erro/sucesso -->
        <?php if (session()->getFlashdata('msg')) : ?>
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <div><?= session()->getFlashdata('msg') ?></div>
            </div>
        <?php endif; ?>

        <!-- ==================================================================== -->
        <!-- == ADAPTADO AQUI: Bloco para exibir mensagem de sucesso do reset == -->
        <!-- ==================================================================== -->
        <?php if (session()->getFlashdata('msg_success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('msg_success') ?></div>
        <?php endif; ?>


        <div class="input-group mb-3">
            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
            <input type="email" name="email" id="email" class="form-control form-control-icon" placeholder="seu@email.com" required>
        </div>

        <div class="input-group mb-3"> <!-- Alterado de mb-4 para mb-3 para dar espaço ao novo link -->
            <span class="input-group-text"><i class="fas fa-lock"></i></span>
            <input type="password" name="password" id="password" class="form-control form-control-icon" placeholder="Senha" required>
        </div>

        <!-- =================================================================== -->
        <!-- == ADAPTADO AQUI: Link para a página "Esqueceu a senha?" == -->
        <!-- =================================================================== -->
        <div class="text-end mb-4">
            <a href="<?= site_url('forgot-password') ?>" style="font-size: 0.9rem; text-decoration: none; color: var(--primary-color);">Esqueceu a senha?</a>
        </div>


        <div class="d-grid">
            <button class="btn btn-primary btn-lg" type="submit">Entrar</button>
        </div>

        <div class="text-center mt-4">
            <p class="mb-0">Não tem uma conta? <a href="<?= base_url('cadastro') ?>" class="fw-bold" style="color: var(--primary-color); text-decoration: none;">Cadastre-se</a></p>
        </div>

        <div class="footer-text">
            <p>Doar Digital &copy; 2025</p>
        </div>
    </form>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
