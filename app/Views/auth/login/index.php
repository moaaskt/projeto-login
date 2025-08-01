<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #6366f1;
            --secondary-color: #10b981;
            --dark-color: #1e293b;
            --light-color: #f8fafc;
        }

        body {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            padding: 2rem;
            width: 100%;
            max-width: 400px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-header img {
            width: 80px;
            height: 80px;
            object-fit: contain;
            margin-bottom: 1rem;
        }

        .login-header h1 {
            color: var(--dark-color);
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .login-header p {
            color: #64748b;
            margin-bottom: 0;
        }

        .form-control {
            padding: 12px 15px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(99, 102, 241, 0.25);
        }

        .form-label {
            color: var(--dark-color);
            font-weight: 500;
            margin-bottom: 8px;
        }

        .btn-primary {
            background: var(--primary-color);
            border: none;
            padding: 12px;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: #4f46e5;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }

        .alert {
            border-radius: 8px;
            border: none;
        }

        .footer-text {
            text-align: center;
            color: #64748b;
            margin-top: 2rem;
            font-size: 0.9rem;
        }

        .input-group-text {
            background: #f1f5f9;
            border: 2px solid #e2e8f0;
            border-radius: 8px 0 0 8px;
        }

        .form-floating > .form-control:focus,
        .form-floating > .form-control:not(:placeholder-shown) {
            ~ label {
                opacity: 0.65;
                transform: scale(0.85) translateY(-0.5rem) translateX(0.15rem);
            }
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="login-header">
        <img src="https://doardigital.com.br/wp-content/uploads/2022/11/Webp.net-resizeimage-1.png" alt="Logo">
        <h1>Faça login</h1>
        <p>Acesse sua conta</p>
    </div>

    <form action="<?= base_url('login/auth') ?>" method="post">
        <?php if (session()->getFlashdata('msg')) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('msg') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="form-floating mb-3">
            <input type="email" name="email" id="email" class="form-control" placeholder="Seu email" required>
            <label for="email" class="form-label">Email</label>
        </div>

        <div class="form-floating mb-4">
            <input type="password" name="password" id="password" class="form-control" placeholder="Senha" required>
            <label for="password" class="form-label">Senha</label>
        </div>

        <button class="w-100 btn btn-primary btn-lg" type="submit">Entrar</button>

        <div class="footer-text">
            <p>Doar Digital © 2025</p>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>