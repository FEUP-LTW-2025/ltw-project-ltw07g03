<?php
declare(strict_types=1);
?>

<?php function drawServiceDetail(Service $service, array $reviews): void {
?>
    <section class="section service-detail-section">
        <div class="container">
            <div class="service-detail-grid">

                <!-- LEFT: Main service content --> 
                <div class="service-detail-left">

                    <!-- Freelancer name --> 
                    <p class="freelancer-name-detail">By <strong><?= htmlspecialchars($service->getFreelancerName()) ?></strong></p>

                    <!-- Image -->
                    <img src="<?= htmlspecialchars($service->getImages()[0]['mediaURL'] ?? '/assets/images/pfps/default.jpeg') ?>"
                        alt="Service image" class="service-detail-img">

                    <!-- Title -->
                    <h2 class="service-detail-title"><?= htmlspecialchars($service->getTitle()) ?></h2>

                    <!-- Short description -->
                    <p class="service-detail-description"><?= htmlspecialchars($service->getDescription()) ?></h2>

                    <!-- About this gig -->
                    
                        <h3>About this gig</h3>
                        <?php 
                        $aboutText = explode("\n", $service->getAbout(), 2);
                        ?>
                        <p class="about-intro"><em><?= htmlspecialchars(trim($aboutText[0])) ?></em></p>
                        <?php if (isset($aboutText[1])): ?>
                            <p><?= nl2br(htmlspecialchars(trim($aboutText[1]))) ?></p>
                        <?php endif; ?>
                    
                    <!-- Delivery and Rating -->
                    <p class="service-detail-delivery">
                        <strong>Delivery Time:</strong> <?= $service->getDeliveryTime() ?> days
                    </p>
                    <p class="service-detail-rating">
                        <strong>Rating:</strong>
                        <?= $service->getRating() > 0 ? '⭐ ' . $service->getRating() . ' /5' : 'No ratings yet' ?>
                    </p>
                
                    <!-- REVIEWS --> 
                    <div class="reviews-section">
                        <h3>Reviews</h3>
                        <?php if (count($reviews) > 0): ?>
                            <ul class="review-list">
                                <?php foreach ($reviews as $review): ?>
                                    <li class="review-item">
                                        <p><strong><?= htmlspecialchars($review['clientName']) ?></strong> says:</p>
                                        <p><?= htmlspecialchars($review['review']) ?></p>
                                        <p>Rating: ⭐ <?= $review['rating'] ?> / 5</p>
                                        <p class="review-date"><?= htmlspecialchars($review['date']) ?></p>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p>No reviews yet. Be the first!</p>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- RIGHT: Price and CTA --> 
                <div class="service-detail-right">
                    <div class="service-detail-price-box">
                        <p class="service-detail-price">
                          <?= htmlspecialchars((string) $service->getPrice()) ?> €
                        </p>
                        <a href="/actions/action_purchase.php?serviceId=<?= $service->getId() ?>" class="purchase-btn">
                          Purchase
                        </a>
                        <a href="/pages/user.php?id=<?= $service->getFreelancerId() ?>" class="service-contact-btn">
                          Contact Me
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>
<?php } ?>
