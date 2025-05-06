<?php
declare(strict_types=1);
require_once(__DIR__ . '/../model/message.class.php');
require_once(__DIR__ . '/../model/user.class.php');

function drawChat(User $user, User $otherUser, array $history): void
{
    $currentUserId = $user->getId(); ?>

    <script>
    const currentUserId = <?= $currentUserId ?>;
    const otherUserName = <?= json_encode($otherUser->getName()) ?>;
    </script>


    <section class="chat-section">
        <div class="chat-container">
            <h2>Chat with <?= htmlspecialchars($otherUser->getName()) ?></h2>

            <div class="chat-messages" id="chat-messages">
                <?php if (empty($history)): ?>
                    <p>No messages yet. Say hi!</p>
                <?php else: ?>
                    <?php foreach ($history as $message): 
                        $isOwn = $message->getSenderId() === $currentUserId;
                    ?>
                        <div class="chat-message <?= $isOwn ? 'own-message' : 'other-message' ?>">
                            <div class="message-meta">
                                <strong><?= $isOwn ? 'You' : htmlspecialchars($otherUser->getName()) ?></strong>
                                <span class="message-time"><?= date('d/m/Y H:i', $message->getDate()) ?></span>
                            </div>
                            <div class="message-text">
                                <?= nl2br(htmlspecialchars($message->getContent())) ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <form id="chat-form">
                <input type="hidden" id="receiver-id" name="receiver_id" value="<?= $otherUser->getId() ?>">
                <textarea id="message-content" name="msg_content" rows="3" placeholder="Type your message..." required></textarea>
                <button type="submit">Send</button>
            </form>

        </div>
    </section>

<?php } ?>
