document.addEventListener('DOMContentLoaded', function () {

    // --- Máscara para CPF (formulário de usuário) ---
    const cpfInput = document.getElementById('cpf');
    if (cpfInput) {
        IMask(cpfInput, {
            mask: '000.000.000-00'
        });
    }

    // --- Máscara dinâmica para CPF/CNPJ (formulário de cliente) ---
    const cpfCnpjInput = document.getElementById('cpf_cnpj');
    if (cpfCnpjInput) {
        IMask(cpfCnpjInput, {
            mask: [
                { mask: '000.000.000-00', maxLength: 11 },
                { mask: '00.000.000/0000-00' }
            ]
        });
    }
    
    // --- Máscara dinâmica para Telefone (fixo e celular) ---
    const telefoneInput = document.getElementById('telefone');
    if (telefoneInput) {
        IMask(telefoneInput, {
            mask: [
                { mask: '(00) 0000-0000' },
                { mask: '(00) 00000-0000' }
            ]
        });
    }

    // --- Máscara para Data de Nascimento ---
    const dataNascimentoInput = document.getElementById('data_nascimento');
    if(dataNascimentoInput) {
        IMask(dataNascimentoInput, {
            mask: Date,
            pattern: 'd/`m/`Y',
            blocks: {
                d: { mask: IMask.MaskedRange, from: 1, to: 31, maxLength: 2 },
                m: { mask: IMask.MaskedRange, from: 1, to: 12, maxLength: 2 },
                Y: { mask: IMask.MaskedRange, from: 1900, to: new Date().getFullYear() }
            },
            format: function (date) {
                const day = String(date.getDate()).padStart(2, '0');
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const year = date.getFullYear();
                return [day, month, year].join('/');
            },
            parse: function (str) {
                const [day, month, year] = str.split('/');
                return new Date(year, month - 1, day);
            }
        });
    }
});