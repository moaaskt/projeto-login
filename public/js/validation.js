document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form[data-check-email-url]');
    if (!form) return;

    const btnSalvar = document.getElementById('btn-salvar');
    if (!btnSalvar) return;

    // Objeto para rastrear o status de validação de cada campo
    const validationStatus = {
        email: true,    // Começa como válido
        cpf_cnpj: true  // Começa como válido
    };

    /**
     * Verifica o status de todos os campos e habilita/desabilita o botão Salvar.
     */
    function checkFormValidity() {
        // Verifica se algum campo está marcado como inválido
        const isFormInvalid = Object.values(validationStatus).some(status => status === false);
        btnSalvar.disabled = isFormInvalid;
    }

    const csrfInput = form.querySelector('input[name^="csrf_test_name"]');
    if (!csrfInput) {
        console.error('CSRF input not found!');
        return;
    }

    function setupFieldValidator(inputId, dataAttribute, fieldName) {
        const inputEl = document.getElementById(inputId);
        const checkUrl = form.dataset[dataAttribute];

        if (!inputEl || !checkUrl) return;

        const feedbackEl = document.createElement('div');
        inputEl.parentNode.appendChild(feedbackEl);

        inputEl.addEventListener('blur', async function () {
            const value = this.value.trim();
            const id = form.querySelector('[name="id"]') ? form.querySelector('[name="id"]').value : '';
            
            feedbackEl.textContent = '';
            inputEl.classList.remove('is-invalid', 'is-valid');
            validationStatus[fieldName] = true; // Reseta para válido antes de checar

            if (value.length < 3) {
                checkFormValidity(); // Checa validade geral mesmo se não fizer AJAX
                return;
            }
            
            feedbackEl.className = 'form-text';
            feedbackEl.style.color = '#adb5bd';
            feedbackEl.textContent = 'Verificando...';

            const postData = new URLSearchParams({
                [fieldName]: value,
                'id': id,
                [csrfInput.name]: csrfInput.value
            });
            
            try {
                const response = await fetch(checkUrl, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest' },
                    body: postData
                });

                if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);

                const result = await response.json();

                if (result.exists) {
                    inputEl.classList.add('is-invalid');
                    feedbackEl.className = 'invalid-feedback d-block';
                    feedbackEl.textContent = 'Este valor já está em uso.';
                    validationStatus[fieldName] = false; // Marca como inválido
                } else {
                    inputEl.classList.add('is-valid');
                    feedbackEl.className = 'valid-feedback d-block';
                    feedbackEl.textContent = 'Disponível.';
                    validationStatus[fieldName] = true; // Marca como válido
                }

            } catch (error) {
                console.error(`Erro na validação do campo ${fieldName}:`, error);
            } finally {
                // Ao final de cada verificação, atualiza o estado do botão
                checkFormValidity();
            }
        });
    }

    // --- INICIA OS VALIDADORES ---
    setupFieldValidator('email', 'checkEmailUrl', 'email');
    setupFieldValidator('cpf_cnpj', 'checkCpfUrl', 'cpf_cnpj');
});