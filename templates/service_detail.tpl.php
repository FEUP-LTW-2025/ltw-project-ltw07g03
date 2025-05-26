<?php

declare(strict_types=1);

function drawServiceDetail(array $service_freelancer, array $feedbacks_author): void
{ ?>
    <section class="section service-detail-section">
        <div class="container">
            <div class="service-detail-grid">
                <div class="service-detail-left">
                    <div class="freelancer-info">
                        <div class="freelancer-details">
                            <p class="freelancer-name-detail">By
                                <strong><?= htmlspecialchars($service_freelancer['freelancer']['name'] ?? 'Unknown') ?></strong>
                            </p>
                            <p class="service-detail-rating">
                                <strong>Rating:</strong>
                                <?= $service_freelancer['avgRating'] > 0 ? '⭐ ' . $service_freelancer['avgRating'] . ' /5' : 'No ratings yet' ?>
                            </p>
                        </div>
                    </div>
                    <div class="carousel">
                        <?php if (count($service_freelancer['images']) > 1): ?>
                            <button class="prev">&#10094;</button>
                        <?php endif; ?>
                        <div class="carousel-images">
                            <?php foreach ($service_freelancer['images'] as $index => $img): ?>
                                <img src="<?= htmlspecialchars($img) ?>"
                                    alt="Service image"
                                    class="carousel-image <?= $index === 0 ? 'active' : '' ?>">
                            <?php endforeach; ?>
                        </div>
                        <?php if (count($service_freelancer['images']) > 1): ?>
                            <button class="next">&#10095;</button>
                        <?php endif; ?>
                    </div>
                    <h2 class="service-detail-title"><?= htmlspecialchars($service_freelancer['title']) ?></h2>
                    <p class="service-detail-description"><?= htmlspecialchars($service_freelancer['description']) ?></p>
                    <?php if (!empty($service_freelancer['about'])): ?>
                        <section class="about-section">
                            <h3>About this gig</h3>
                            <p><?= nl2br(htmlspecialchars($service_freelancer['about'])) ?></p>
                        </section>
                    <?php endif; ?>
                    <p class="service-detail-delivery">
                        <?php if($service_freelancer['deliveryTime'] == 1): ?>
                            <strong>Delivery Time:</strong> <?= $service_freelancer['deliveryTime'] ?> day
                        <?php else: ?>
                            <strong>Delivery Time:</strong> <?= $service_freelancer['deliveryTime'] ?> days
                        <?php endif; ?>
                    </p>
                    <div class="reviews-section">
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
                <div class="service-detail-right">
                    <div class="service-detail-price-box">
                        <p class="service-detail-price">
                            <?= $service_freelancer['price'] ?> €
                        </p>
                        <a href="/pages/checkout.php?serviceId=<?= $service_freelancer['serviceId'] ?>"
                            class="purchase-btn btn-transition">
                            Purchase
                        </a>
                        <a href="/pages/chat.php?user_id=<?= $service_freelancer['freelancer']['id'] ?>"
                            class="service-contact-btn btn-transition">
                            Contact Me
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>
<?php }


function drawEditableServiceDetail(array $service_freelancer, array $feedbacks_author): void
{ ?>
    <section class="section service-detail-section">
        <div class="container">
            <div class="service-detail-grid">
                <div class="service-detail-left">
                    <div class="freelancer-info">
                        <div class="freelancer-details">
                            <p class="freelancer-name-detail">By
                                <strong><?= htmlspecialchars($service_freelancer['freelancer']['name'] ?? 'Unknown') ?></strong>
                            </p>
                            <p class="service-detail-rating">
                                <strong>Rating:</strong>
                                <?= $service_freelancer['avgRating'] > 0 ? '⭐ ' . $service_freelancer['avgRating'] . ' /5' : 'No ratings yet' ?>
                            </p>
                        </div>
                    </div>
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
                    <h2 class="service-detail-title editable" data-field="title"><?= htmlspecialchars($service_freelancer['title']) ?></h2>
                    <p class="service-detail-description editable" data-field="description"><?= htmlspecialchars($service_freelancer['description']) ?></p>
                    <?php if (!empty($service_freelancer['about'])): ?>
                        <section class="about-section" data-field="about">
                            <h3 class="editable" data-field="about-heading">About this gig</h3>
                            <p class="editable" data-field="about"><?= nl2br(htmlspecialchars($service_freelancer['about'])) ?></p>
                        </section>
                    <?php endif; ?>
                    <p class="service-detail-delivery">
                        <strong>Delivery Time:</strong> <?= $service_freelancer['deliveryTime'] ?> days
                    </p>
                    <div class="reviews-section">
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
                <div class="service-detail-right">
                    <div class="service-detail-price-box">
                        <p class="service-detail-price editable" data-field="price">
                            <span class="price-value"><?= $service_freelancer['price'] ?></span> <span>€</span>
                        </p>
                    </div>
                </div>
            </div>
            <button id="toggle-edit-btn">Edit</button>
            <button id="toggle-save-btn" style='display: none;'>Save</button>
        </div>
    </section>
<?php } ?>
