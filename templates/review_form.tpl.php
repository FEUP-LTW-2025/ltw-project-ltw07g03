<?php
declare(strict_types=1);

function drawReviewForm($purchase_id): void
{ ?>
    <h2>Leave a Review</h2>
    <form action="/actions/action_submitReview.php" method="POST" class="review-form">

        <input type="hidden" name="purchase_id" value="<?= $purchase_id ?>">

        <fieldset>
            <legend>Rating</legend>
            <?php for ($i = 1; $i <= 5; $i++): ?>
                <label>
                    <input type="radio" name="rating" value="<?= $i ?>" required>
                    <?= $i ?>
                </label>
            <?php endfor; ?>
        </fieldset>

        <label for="feedback">Feedback</label>
        <textarea id="feedback" name="feedback" rows="4" required></textarea>

        <button type="submit">Submit Review</button>
    </form>
<?php } ?>
