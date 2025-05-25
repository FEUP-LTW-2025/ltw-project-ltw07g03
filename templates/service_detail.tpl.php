<?php
declare(strict_types=1);

function drawServiceDetail(array $service_freelancer, array $feedbacks_author): void
{ ?>
    <section class="service-detail-section">
        <div class="service-detail-layout">
            <div class="service-detail-left">
                <div class="freelancer-info">
                    <img class="freelancer-pic"
                         src="<?= htmlspecialchars($service_freelancer['freelancer']['profilePictureURL']) ?>" alt="">
                    <strong class="freelancer-name">By <?= htmlspecialchars($service_freelancer['freelancer']['name']) ?></strong>
                </div>
                <p class="service-detail-description"><?= htmlspecialchars($service_freelancer['description']) ?></p>
                <div class="service-slider" data-service-id="<?= $service_freelancer['serviceId'] ?>">
                    <?php if (count($service_freelancer['images']) > 1): ?>
                        <button class="slider-prev">‹</button>
                    <?php endif; ?>
                    <div class="slider-images">
                        <?php foreach ($service_freelancer['images'] as $index => $imgURL): ?>
                            <img src="<?= htmlspecialchars($imgURL) ?>"
                                 alt="Service image <?= $index + 1 ?>"
                                 class="slider-image slider-image-large<?= $index === 0 ? ' active' : '' ?>">
                        <?php endforeach; ?>
                    </div>
                    <?php if (count($service_freelancer['images']) > 1): ?>
                        <button class="slider-next">›</button>
                    <?php endif; ?>
                </div>

                <div class="service-price-box-inline">
                    <p class="price-amount">€<?= $service_freelancer['price'] ?></p>
                    <a href="/pages/checkout.php?serviceId=<?= $service_freelancer['serviceId'] ?>"
                       class="purchase-btn">Purchase</a>
                    <a href="/pages/chat.php?user_id=<?= $service_freelancer['freelancer']['id'] ?>"
                       class="service-contact-btn">Contact me</a>
                </div>
            </div>

            <div class="service-detail-right">
                <h2 class="service-detail-title"><?= htmlspecialchars($service_freelancer['title']) ?></h2>

                <?php if (!empty($service_freelancer['about'])): ?>
                    <div class="service-detail-about">
                        <h3>About this gig</h3>
                        <p><?= nl2br(htmlspecialchars($service_freelancer['about'])) ?></p>
                    </div>
                <?php endif; ?>
                <p class="service-detail-delivery">
                    <strong>Delivery Time:</strong> <?= $service_freelancer['deliveryTime'] ?> days
                </p>
                <p class="service-detail-rating">
                    <strong>Rating:</strong>
                    <?= $service_freelancer['avgRating'] > 0 ? '⭐ ' . $service_freelancer['avgRating'] . ' /5' : 'No ratings yet' ?>
                </p>
                <div class="service-reviews">
                    <h3>Reviews</h3>
                    <?php if (count($feedbacks_author) > 0): ?>
                        <ul class="review-list">
                            <?php foreach ($feedbacks_author as $feedback_author): ?>
                                <?php
                                $feedback = $feedback_author['feedback'];
                                $author = $feedback_author['author'];
                                ?>
                                <li class="review-item">
                                    <p><strong><?= htmlspecialchars($author->getName()) ?></strong> says:</p>
                                    <p><?= htmlspecialchars($feedback->getReview()) ?></p>
                                    <p>Rating: ⭐ <?= $feedback->getRating() ?> / 5</p>
                                    <p class="review-date"><?= date('d/m/Y H:i', $feedback->getDate()) ?></p>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p>No reviews yet. Be the first!</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
<?php } ?>

<?php function drawEditableServiceDetail(array $service_freelancer, array $feedbacks_author): void
{ ?>
    <section class="service-detail-section">
        <div class="service-detail-layout">
            <div class="service-detail-left">
                <div class="freelancer-info">
                    <img class="freelancer-pic"
                         src="<?= htmlspecialchars($service_freelancer['freelancer']['profilePictureURL']) ?>" alt="">
                    <span>By <strong><?= htmlspecialchars($service_freelancer['freelancer']['name']) ?></strong></span>
                </div>

                <p class="service-detail-description editable"
                   data-field="description"><?= htmlspecialchars($service_freelancer['description']) ?></p>

                <div class="service-slider" data-service-id="<?= $service_freelancer['serviceId'] ?>">
                    <?php if (count($service_freelancer['images']) > 1): ?>
                        <button class="slider-prev">‹</button>
                    <?php endif; ?>
                    <div class="slider-images">
                        <?php foreach ($service_freelancer['images'] as $index => $imgURL): ?>
                            <img src="<?= htmlspecialchars($imgURL) ?>"
                                 alt="Service image <?= $index + 1 ?>"
                                 class="slider-image<?= $index === 0 ? ' active' : '' ?>">
                        <?php endforeach; ?>
                    </div>
                    <?php if (count($service_freelancer['images']) > 1): ?>
                        <button class="slider-next">›</button>
                    <?php endif; ?>
                </div>

                <div class="service-price-box-inline">
                    <p class="price-amount editable" data-field="price">€<span
                                class="price-value"><?= $service_freelancer['price'] ?></span></p>
                    <a href="/pages/checkout.php?serviceId=<?= $service_freelancer['serviceId'] ?>"
                       class="purchase-btn">Purchase</a>
                    <a href="/pages/chat.php?user_id=<?= $service_freelancer['freelancer']['id'] ?>"
                       class="service-contact-btn">Contact me</a>
                    <a href="#" id="toggle-edit-btn" class="service-edit-btn">Edit</a>
                    <a href="#" id="toggle-save-btn" class="service-edit-btn" style="display: none;">Save</a>
                </div>
            </div>
            <div class="service-detail-right">
                <h2 class="service-detail-title editable"
                    data-field="title"><?= htmlspecialchars($service_freelancer['title']) ?></h2>

                <?php if (!empty($service_freelancer['about'])): ?>
                    <div class="service-detail-about" data-field="about">
                        <h3 class="editable" data-field="about-heading">About this gig</h3>
                        <p class="editable"
                           data-field="about"><?= nl2br(htmlspecialchars($service_freelancer['about'])) ?></p>
                    </div>
                <?php endif; ?>

                <p class="service-detail-delivery">
                    <strong>Delivery Time:</strong> <?= $service_freelancer['deliveryTime'] ?> days
                </p>
                <p class="service-detail-rating">
                    <strong>Rating:</strong>
                    <?= $service_freelancer['avgRating'] > 0 ? '⭐ ' . $service_freelancer['avgRating'] . ' /5' : 'No ratings yet' ?>
                </p>

                <div class="service-reviews">
                    <h3>Reviews</h3>
                    <?php if (count($feedbacks_author) > 0): ?>
                        <ul class="review-list">
                            <?php foreach ($feedbacks_author as $feedback_author): ?>
                                <?php $feedback = $feedback_author['feedback'];
                                $author = $feedback_author['author']; ?>
                                <li class="review-item">
                                    <p><strong><?= htmlspecialchars($author->getName()) ?></strong> says:</p>
                                    <p><?= htmlspecialchars($feedback->getReview()) ?></p>
                                    <p>Rating: ⭐ <?= $feedback->getRating() ?> / 5</p>
                                    <p class="review-date"><?= date('d/m/Y H:i', $feedback->getDate()) ?></p>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p>No reviews yet. Be the first!</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
<?php } 
