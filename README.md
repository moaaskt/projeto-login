# Sistema de Login com Painel de Controle - CodeIgniter 4

Este é um projeto de autenticação com painel administrativo desenvolvido em **PHP** utilizando o framework **CodeIgniter 4**. O sistema permite o cadastro e login de usuários com validações básicas e interface customizada com **HTML, CSS e JS**.

---

## 📂 Estrutura do Projeto

```
📁 app/
├── Config/
├── Controllers/
├── Models/
├── Views/
│   ├── login/
│   └── template/
├── .htaccess

📁 public/
├── index.php
├── css/
├── js/
└── favicon.ico
```

---

## ⚙️ Tecnologias Utilizadas

- PHP 7+
- CodeIgniter 4
- Bootstrap 4/5 (dependendo da versão usada no CSS)
- JavaScript (validações e interações no dashboard)
- HTML5 + CSS3

---

## 🚀 Funcionalidades

- Página de login com validação
- Sessão de usuário autenticado
- Painel administrativo com estilo personalizado
- Estrutura MVC organizada
- Rotas configuradas no `Routes.php`
- Middleware de autenticação (filtros)
- Templates reutilizáveis com cabeçalho e rodapé

---

## 🛠️ Como rodar o projeto localmente

### Pré-requisitos

- PHP 7.4 ou superior
- Composer
- Servidor Apache/Nginx (recomendado usar Laragon ou XAMPP)
- Banco de dados MySQL ou SQLite (dependendo da configuração)

### Passo a passo

```bash
# Clone o repositório
git clone https://github.com/moaaskt/projeto-login.git

# Acesse o diretório
cd projeto-login

# Instale as dependências do CodeIgniter (se necessário)
composer install

# Configure o arquivo .env com suas variáveis de ambiente
cp env .env

# Gere a chave de encriptação do framework
php spark key:generate

# Rode o servidor local
php spark serve
```

---

## 📸 Imagens do sistema

> Adicione capturas de tela do painel e da tela de login para ilustrar melhor o projeto.

---

## ✍️ Autor

**moaaskt**  
Desenvolvedor de sistemas apaixonado por tecnologia, skate e projetos criativos.  
GitHub: [@moaaskt](https://github.com/moaaskt)

---

## 📄 Licença

Este projeto está sob a licença MIT. Veja o arquivo [LICENSE](LICENSE) para mais detalhes.