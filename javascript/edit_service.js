document.addEventListener('DOMContentLoaded', function () {
    const editButton = document.getElementById('toggle-edit-btn');
    const saveButton = document.getElementById('toggle-save-btn');

    editButton.addEventListener('click', function () {
        editButton.style.display = 'none';
        saveButton.style.display = 'inline-block';

        document.querySelectorAll('.editable').forEach(el => {
            if (['P', 'H2', 'H3'].includes(el.tagName)) {
                el.contentEditable = true;
                el.style.border = '1px dashed #ccc';
                el.style.padding = '5px';
                el.dataset.originalText = el.innerText;
            }
        });

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
    const deliveryDays = document.querySelector('.editable-delivery-days');
    if (deliveryDays) {
        const value = deliveryDays.innerText.trim();
        if (!/^\d+$/.test(value)) {
            alert('Delivery time tem de ser um número inteiro.');
            deliveryDays.focus(); // opcional: dá foco para corrigir
            return;
        }
    }

    // Só agora muda os botões
    editButton.style.display = 'inline-block';
    saveButton.style.display = 'none';

    const updatedData = {};

    document.querySelectorAll('.editable').forEach(el => {
        const field = el.dataset.field;
        if (field) {
            updatedData[field] = el.innerText.trim();
            el.contentEditable = false;
            el.style.border = '';
            el.style.padding = '';
        }
    });

    if (deliveryDays) {
        updatedData['deliveryTime'] = parseInt(deliveryDays.innerText.trim());
        deliveryDays.contentEditable = false;
        deliveryDays.style.border = '';
        deliveryDays.style.padding = '';
    }

    //include the serviceId to update in the DB
    updatedData['serviceId'] = document.querySelector('.service-slider').dataset.serviceId;

    
    fetch('/actions/update_service.php', {
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
