// public/js/viacep.js
document.addEventListener('DOMContentLoaded', function () {
    const cepInput = document.getElementById('cep');

    if (!cepInput) {
        return; // Sai se o campo CEP não existir na página
    }

    cepInput.addEventListener('blur', function () {
        const cep = this.value.replace(/\D/g, ''); // Remove tudo que não for número

        if (cep.length !== 8) {
            return; // CEP inválido
        }

        // Feedback visual para o usuário
        setAddressFieldsReadOnly(true, 'Buscando...');

        fetch(`https://viacep.com.br/ws/${cep}/json/`)
            .then(response => response.json())
            .then(data => {
                if (data.erro) {
                    // CEP não encontrado
                    setAddressFieldsReadOnly(false, '');
                    clearAddressFields();
                    alert('CEP não encontrado. Por favor, verifique o número.');
                } else {
                    // Sucesso! Preenche os campos
                    document.getElementById('logradouro').value = data.logradouro;
                    document.getElementById('bairro').value = data.bairro;
                    document.getElementById('cidade').value = data.localidade;
                    document.getElementById('estado').value = data.uf;
                    setAddressFieldsReadOnly(false, '');
                    document.getElementById('numero').focus(); // Move o foco para o campo "número"
                }
            })
            .catch(error => {
                console.error('Erro ao buscar CEP:', error);
                setAddressFieldsReadOnly(false, '');
            });
    });

    function setAddressFieldsReadOnly(isReadOnly, placeholderText) {
        document.getElementById('logradouro').readOnly = isReadOnly;
        document.getElementById('logradouro').placeholder = placeholderText;
        document.getElementById('bairro').readOnly = isReadOnly;
        document.getElementById('cidade').readOnly = isReadOnly;
        document.getElementById('estado').readOnly = isReadOnly;
    }

    function clearAddressFields() {
        document.getElementById('logradouro').value = '';
        document.getElementById('bairro').value = '';
        document.getElementById('cidade').value = '';
        document.getElementById('estado').value = '';
    }
});