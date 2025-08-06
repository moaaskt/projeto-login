// public/js/perfil.js
document.addEventListener('DOMContentLoaded', function () {
    // Lógica para o formulário de DADOS CADASTRAIS
    const submitDadosBtn = document.getElementById('submit-dados-btn');
    const formDados = document.getElementById('form-dados');
    if (submitDadosBtn && formDados) {
        submitDadosBtn.addEventListener('click', function () {
            formDados.submit();
        });
    }

    // Lógica para o formulário de ALTERAÇÃO DE SENHA
    const submitSenhaBtn = document.getElementById('submit-senha-btn');
    const formSenha = document.getElementById('form-senha');
    if (submitSenhaBtn && formSenha) {
        submitSenhaBtn.addEventListener('click', function () {
            formSenha.submit();
        });
    }
});