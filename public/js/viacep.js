document.addEventListener('DOMContentLoaded', function () {
    const cepInput = document.getElementById('cep');
    if (!cepInput) return;

    // 1. Aplica a máscara do CEP diretamente aqui
    const cepMask = IMask(cepInput, {
        mask: '00000-000'
    });

    // 2. Função de busca usando async/await
    const buscarCep = async (cep) => {
        // Feedback visual para o usuário
        setAddressFieldsReadOnly(true, 'Buscando...');
        
        try {
            const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
            if (!response.ok) throw new Error('Erro na requisição');

            const data = await response.json();

            if (data.erro) {
                clearAddressFields();
                // Poderia ser um alerta mais amigável
            } else {
                document.getElementById('logradouro').value = data.logradouro;
                document.getElementById('bairro').value = data.bairro;
                document.getElementById('cidade').value = data.localidade;
                document.getElementById('estado').value = data.uf;
                document.getElementById('numero').focus();
            }
        } catch (error) {
            console.error('Erro ao buscar CEP:', error);
            clearAddressFields();
        } finally {
            // Acontece sempre, com sucesso ou erro
            setAddressFieldsReadOnly(false, '');
        }
    };

    // 3. Aciona a busca quando o usuário termina de digitar (8 dígitos)
    cepMask.on('complete', function () {
        buscarCep(cepMask.unmaskedValue);
    });

    // Funções auxiliares (sem alteração)
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