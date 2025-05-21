document.addEventListener('DOMContentLoaded', function () {
    const editButton = document.getElementById('toggle-edit-btn');
    const saveButton = document.getElementById('toggle-save-btn');

    editButton.addEventListener('click', function () {
        editButton.style.display = 'none';
        saveButton.style.display = 'inline-block';

        // Ativa contentEditable para todos os elementos .editable (h2, p, h3), exceto para preço que tem regra especial
        document.querySelectorAll('.editable').forEach(el => {
            if (['P', 'H2'].includes(el.tagName)) {
                // Se for preço, não tornar o container editável, vamos fazer só a span.price-value editável
                if (el.classList.contains('service-detail-price')) {
                    // nada aqui
                } else {
                    el.contentEditable = true;
                    el.style.border = '1px dashed #ccc';
                    el.style.padding = '5px';
                    el.dataset.originalText = el.innerText;
                }
            }
        });

        // Tornar só o número do preço editável
        const priceSpan = document.querySelector('.price-value');
        if (priceSpan) {
            priceSpan.contentEditable = true;
            priceSpan.style.border = '1px dashed #ccc';
            priceSpan.style.padding = '5px';
            priceSpan.dataset.originalText = priceSpan.innerText;
        }

        // Delivery time edição
        const deliveryParagraph = document.querySelector('.service-detail-delivery');
        if (deliveryParagraph) {
            const match = deliveryParagraph.innerText.match(/(\d+)\s*days/);
            if (match) {
                const span = document.createElement('span');
                span.contentEditable = true;
                span.classList.add('editable-delivery-days');
                span.style.border = '1px dashed #ccc';
                span.style.padding = '2px';
                span.dataset.originalText = match[1];
                span.innerText = match[1];

                deliveryParagraph.innerHTML = `<strong>Delivery Time:</strong> `;
                deliveryParagraph.appendChild(span);
                deliveryParagraph.innerHTML += ` days`;
            }
        }
    });

    saveButton.addEventListener('click', function () {
        // Validação ANTES de mudar estado dos botões

        // Validar deliveryTime
        const deliveryDays = document.querySelector('.editable-delivery-days');
        if (deliveryDays) {
            const value = deliveryDays.innerText.trim();
            if (!/^\d+$/.test(value)) {
                alert('Delivery time tem de ser um número inteiro.');
                deliveryDays.focus();
                return;
            }
        }

        // Validar preço (float com 0-2 decimais)
        const priceSpan = document.querySelector('.price-value');
        if (priceSpan) {
            const priceText = priceSpan.innerText.trim();
            if (!/^\d+(\.\d{1,2})?$/.test(priceText)) {
                alert('O preço tem de ser um número válido (ex: 100 ou 99.99).');
                priceSpan.focus();
                return;
            }
        }

        // Só agora muda os botões
        editButton.style.display = 'inline-block';
        saveButton.style.display = 'none';

        const updatedData = {};

        // Campos editáveis
        document.querySelectorAll('.editable').forEach(el => {
            const field = el.dataset.field;
            if (field && !el.classList.contains('service-detail-price')) {
                updatedData[field] = el.innerText.trim();
                el.contentEditable = false;
                el.style.border = '';
                el.style.padding = '';
            }
        });

        // Valor do preço
        if (priceSpan) {
            updatedData['price'] = parseFloat(priceSpan.innerText.trim());
            priceSpan.contentEditable = false;
            priceSpan.style.border = '';
            priceSpan.style.padding = '';
        }

        // Delivery time
        if (deliveryDays) {
            updatedData['deliveryTime'] = parseInt(deliveryDays.innerText.trim());
            deliveryDays.contentEditable = false;
            deliveryDays.style.border = '';
            deliveryDays.style.padding = '';
        }

        // Inclui serviceId para atualizar na BD
        updatedData['serviceId'] = document.querySelector('.service-slider').dataset.serviceId;

        console.log(updatedData);

        fetch('/actions/action_update_service.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(updatedData)
        })
        .then(response => response.json())
        .then(data => {
            console.log('Resposta do servidor:', data);
            alert('Serviço atualizado com sucesso!');
        })
        .catch(error => {
            console.error('Erro ao atualizar:', error);
            alert('Erro ao atualizar o serviço.');
        });
    });
});
