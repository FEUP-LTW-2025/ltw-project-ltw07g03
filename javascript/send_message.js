document.getElementById('chat-form').addEventListener('submit', function (event) {
    event.preventDefault(); // Impede o recarregamento da página

    const receiverId = document.getElementById('receiver-id').value;
    const content = document.getElementById('message-content').value;

    // Envia a mensagem via AJAX para o backend, sem esperar a resposta
    fetch('/actions/action_sendMessage.php', {
        method: 'POST',
        body: new URLSearchParams({
            'receiver_id': receiverId,
            'msg_content': content
        }),
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        }
    })
        .catch(err => console.error('Error sending message:', err));

    // Limpar o campo de mensagem após o envio
    document.getElementById('message-content').value = '';
});
