document.addEventListener('DOMContentLoaded', function () {

    // --- Máscara para CPF ---
    const cpfInput = document.getElementById('cpf');
    if (cpfInput) {
        IMask(cpfInput, {
            mask: '000.000.000-00'
        });
    }

    // --- Máscara dinâmica para CPF/CNPJ ---
    const cpfCnpjInput = document.getElementById('cpf_cnpj');
    if (cpfCnpjInput) {
        IMask(cpfCnpjInput, {
            mask: [
                {
                    mask: '000.000.000-00',
                    maxLength: 11
                },
                {
                    mask: '00.000.000/0000-00'
                }
            ]
        });
    }

        const cepInput = document.getElementById('cep');
    if (cepInput) {
        IMask(cepInput, {
            mask: '00000-000'
        });
    }

      const dataNascimentoInput = document.getElementById('data_nascimento');
    if(dataNascimentoInput) {
        IMask(dataNascimentoInput, {
            mask: '00/00/0000'
        });
    }


    // --- Máscara dinâmica para Telefone (fixo e celular) ---
    const telefoneInput = document.getElementById('telefone');
    if (telefoneInput) {
        IMask(telefoneInput, {
            mask: [
                {
                    mask: '(00) 0000-0000'
                },
                {
                    mask: '(00) 00000-0000'
                }
            ]
        });
    }

    // --- Máscara para CEP ---
    const cepInput = document.getElementById('cep');
    if (cepInput) {
        IMask(cepInput, {
            mask: '00000-000'
        });
    }







    

});

