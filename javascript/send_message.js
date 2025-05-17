const chatForm = document.getElementById('chat-form');

if (chatForm) {
    chatForm.addEventListener('submit', function (event) {
        event.preventDefault();

        const receiverIdInput = document.getElementById('receiver-id');
        const messageContentInput = document.getElementById('message-content');

        if (!receiverIdInput || !messageContentInput) {
            console.error('Missing receiver-id or message-content input field.');
            return;
        }

        const receiverId = receiverIdInput.value;
        const content = messageContentInput.value;

        fetch('/actions/action_sendMessage.php', {
            method: 'POST',
            body: new URLSearchParams({
                'receiver_id': receiverId,
                'msg_content': content
            }),
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).catch(err => console.error('Error sending message:', err));

        messageContentInput.value = '';
    });
}
