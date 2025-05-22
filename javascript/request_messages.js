document.addEventListener('DOMContentLoaded', () => {
    let lastTimestamp = Math.floor(Date.now() / 1000);

    function pollForNewMessages() {
        const receiverInput = document.getElementById('receiver-id');
        const chatMessages = document.getElementById('chat-messages');

        if (!receiverInput || !chatMessages) {
            return;
        }

        const otherUserId = receiverInput.value;

        fetch(`/api/get_new_messages.php?user_id=${otherUserId}&since=${lastTimestamp}`)
            .then(res => res.json())
            .then(messages => {
                if (Array.isArray(messages)) {
                    messages.forEach(msg => {
                        const isOwn = msg.senderId == currentUserId;
                        const msgHtml = `
              <div class="chat-message ${isOwn ? 'own-message' : 'other-message'}">
                <div class="message-meta">
                  <strong>${isOwn ? 'You' : otherUserName}</strong>
                  <span class="message-time">${new Date(msg.timestamp * 1000).toLocaleString()}</span>
                </div>
                <div class="message-text">${msg.content.replace(/\n/g, '<br>')}</div>
              </div>
            `;
                        chatMessages.insertAdjacentHTML('beforeend', msgHtml);
                        chatMessages.scrollTop = chatMessages.scrollHeight;

                        if (msg.timestamp > lastTimestamp) {
                            lastTimestamp = msg.timestamp;
                        }
                    });
                }
            })
            .catch(err => console.error('Polling error:', err));
    }

    setInterval(pollForNewMessages, 500);
});
