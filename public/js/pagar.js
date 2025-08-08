document.addEventListener('DOMContentLoaded', function () {
    const modalPagamentoElement = document.getElementById('modalPagamento');
    if (!modalPagamentoElement) return;

    // AQUI ESTÁ A MUDANÇA: Lemos a URL que o PHP nos deu!
    const urlProcessamento = modalPagamentoElement.dataset.urlProcessar;

    const modalPagamento = new bootstrap.Modal(modalPagamentoElement);
    const resultadoArea = document.getElementById('area-resultado');
    const loadingSpinner = document.getElementById('loading');
    const resultadoContent = document.getElementById('resultado-content');
    
    let currentFaturaId = null;

    document.querySelectorAll('.btn-pagar-fatura').forEach(button => {
        button.addEventListener('click', function () {
            currentFaturaId = this.dataset.faturaId;
            document.getElementById('modal-fatura-id').textContent = currentFaturaId;
            resultadoArea.style.display = 'none';
            resultadoContent.innerHTML = '';
            modalPagamento.show();
        });
    });

    document.querySelectorAll('.btn-gerar-pagamento').forEach(button => {
        button.addEventListener('click', async function() {
            const metodo = this.dataset.metodo;
            resultadoArea.style.display = 'block';
            loadingSpinner.style.display = 'block';
            resultadoContent.innerHTML = '';

            await new Promise(resolve => setTimeout(resolve, 1500));

            loadingSpinner.style.display = 'none';

            if (metodo === 'pix') {
                resultadoContent.innerHTML = `
                    <h5>PIX Fictício Gerado</h5>
                    <p>Leia o QR Code de teste abaixo:</p>
                    <img src="https://www.investopedia.com/thmb/hJrIBjjMBGfx0W_9sG5SoCDkK24=/1500x0/filters:no_upscale():max_bytes(150000):strip_icc()/qr-code-bc94057f452f4806979e7534d1326b57.png" 
                         class="img-fluid" style="max-width: 200px;" alt="PIX QR Code Fictício">
                `;
            } else if (metodo === 'boleto') {
                 resultadoContent.innerHTML = `
                    <h5>Boleto Fictício Gerado</h5>
                    <p class="alert alert-info">Isto é apenas uma simulação. Seu boleto de teste foi gerado com sucesso!</p>
                `;
            }

            try {
                // AQUI USAMOS A VARIÁVEL COM A URL CORRETA!
                const response = await fetch(urlProcessamento, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ fatura_id: currentFaturaId })
                });

                const data = await response.json();
                if (!data.success) {
                    throw new Error(data.message || 'Erro ao processar o pagamento.');
                }
                
                resultadoContent.innerHTML += `<div class="alert alert-success mt-3">Pagamento confirmado! A página será atualizada.</div>`;
                setTimeout(() => {
                    location.reload();
                }, 2500);

            } catch(err) {
                resultadoContent.innerHTML += `<div class="alert alert-danger mt-3">${err.message}</div>`;
            }
        });
    });
});