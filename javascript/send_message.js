const chatForm = document.getElementById("chat-form");

if (chatForm) {
    chatForm.addEventListener("submit", function (event) {
        event.preventDefault();

        const receiverIdInput = document.getElementById("receiver-id");
        const messageContentInput = document.getElementById("message-content");
        const csrfTokenInput = document.querySelector('input[name="csrf_token"]');

        if (!receiverIdInput || !messageContentInput || !csrfTokenInput) {
            console.error(
                "Missing required form fields (receiver-id, message-content, or csrf_token)."
            );
            return;
        }

        const receiverId = receiverIdInput.value;
        const content = messageContentInput.value;
        const csrfToken = csrfTokenInput.value;

        if (!content.trim()) {
            console.error("Message content cannot be empty.");
            return;
        }

        fetch("/actions/action_sendMessage.php", {
            method: "POST",
            body: new URLSearchParams({
                receiver_id: receiverId,
                msg_content: content,
                csrf_token: csrfToken,
            }),
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
        }).catch((err) => console.error("Error sending message:", err));

        messageContentInput.value = "";
    });
}
