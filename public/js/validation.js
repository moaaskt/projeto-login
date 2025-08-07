document.addEventListener('DOMContentLoaded', function () {
    const emailInput = document.getElementById('email');
    if (!emailInput) return; // Se não houver campo de email na página, não faz nada.


    const form = emailInput.closest('form');
    if (!form) return; // Garante que o email está dentro de um formulário.

    // Cria o elemento para exibir a mensagem de feedback uma única vez.
    const feedbackEl = document.createElement('div');
    emailInput.parentNode.appendChild(feedbackEl);

    // Usa o evento 'blur' para verificar quando o usuário sai do campo.
    emailInput.addEventListener('blur', async function () {
        const email = this.value.trim();
        const checkEmailUrl = form.dataset.checkEmailUrl;

        // Limpa mensagens anteriores
        feedbackEl.textContent = '';
        emailInput.classList.remove('is-invalid', 'is-valid');

        if (email.length < 5 || !email.includes('@')) {
            return; // Validação de front-end mínima
        }

        // Prepara os dados para envio de forma segura
        const idInput = form.querySelector('[name="id"]');
        const id = idInput ? idInput.value : '';

        const postData = new URLSearchParams({
            'email': email,
            'id': id,
            [document.querySelector('form [name^="csrf_token"]').name]: document.querySelector('form [name^="csrf_token"]').value
        });
        try {
            const response = await fetch(checkEmailUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest' // Essencial para o isAJAX() do CodeIgniter
                },
                body: postData
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const result = await response.json();

            if (result.exists) {
                emailInput.classList.add('is-invalid');
                feedbackEl.className = 'invalid-feedback d-block'; // d-block força a exibição
                feedbackEl.textContent = 'Este e-mail já está em uso.';
            } else {
                emailInput.classList.add('is-valid');
                feedbackEl.className = 'valid-feedback d-block';
                feedbackEl.textContent = 'E-mail disponível.';
            }

        } catch (error) {
            console.error('Erro na validação de e-mail:', error);
            feedbackEl.className = 'invalid-feedback d-block';
            feedbackEl.textContent = 'Não foi possível verificar o e-mail. Tente novamente.';
        }
    });
});