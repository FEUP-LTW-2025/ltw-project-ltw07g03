


document.getElementById('chat-form').addEventListener('submit', async function(event) {
    event.preventDefault();

    const content = document.getElementById('message-content').value.trim();
    const receiverId = document.getElementById('receiver-id').value;

    if (content === '') return;

    const request = await fetch('/actions/action_sendMessage.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ receiver_id: receiverId, content: content })
    });

    const result = await request.json();
    console.log('Resposta do servidor:', result);


    if (result.messageId) {
        
        const chatMessages = document.getElementById('chat-messages');
        const now = new Date();
        
        const messageHtml = `
            <div class="chat-message own-message">
                <div class="message-meta">
                    <strong>You</strong>
                    <span class="message-time">${result.date}</span>
                </div>
                <div class="message-text">${content.replace(/\n/g, '<br>')}</div>
            </div>
        `;
        chatMessages.insertAdjacentHTML('beforeend', messageHtml);
        document.getElementById('message-content').value = '';
        chatMessages.scrollTop = chatMessages.scrollHeight;
    } else {
        alert('Error sending message: ' + (result.error || 'Unknown error'));
    }
});

