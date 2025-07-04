<?php

declare(strict_types=1);
require_once(__DIR__ . '/../model/user.class.php');
require_once(__DIR__ . '/../model/service.class.php');

function drawUserProfile(User $user): void
{ ?>
    <section class="section profile-section">
        <div class="profile-header">
            <img src="<?= htmlspecialchars($user->getProfilePicture()) ?>" alt="Profile Picture"
                class="profile-picture-large">
            <h2><?= htmlspecialchars($user->getName()) ?></h2>
            <p class="profile-username">@<?= htmlspecialchars($user->getUsername()) ?></p>
        </div>

        <div class="container">
            <div class="profile-card card-hover-lift">
                <h3 class="card-title">User Information</h3>
                <ul class="profile-info">
                    <li><span>Email:</span> <?= htmlspecialchars($user->getEmail()) ?></li>
                    <li><span>Status:</span> <?= htmlspecialchars(ucfirst($user->getStatus())) ?></li>
                    <li><span>Role:</span> <?= $user->isAdmin() ? 'Admin' : 'User' ?></li>
                </ul>
            </div>
        </div>
    </section>
<?php } ?>

<?php function drawEditableUserProfile(User $user, $conversationUsers, array $services, Session $session): void
{ ?>
    <section class="section profile-section">
        <div class="profile-layout"> 
            <div class="profile-left-column"> 
                <h2 class="section-title">Edit Your Profile</h2>
                <form action="/actions/action_edit_profile.php" method="post" class="profile-card" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value="<?= $session->getCSRFToken() ?? '' ?>">
                    <input type="hidden" name="id" value="<?= htmlspecialchars((string)$user->getId()) ?>">
                    <div class="form-group center">
                        <img src="<?= htmlspecialchars($user->getProfilePicture()) ?>" class="profile-picture-large">
                        <input type="file" name="profilePicture" id="editProfilePicture" required>
                        <p id="profilePreviewLabel" class="preview-label">Selected Image</p>
                        <div id="profile-preview-container" class="image-preview-container profile-preview-container"></div>
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" value="<?= htmlspecialchars($user->getName()) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name="username" value="<?= htmlspecialchars($user->getUsername()) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" value="<?= htmlspecialchars($user->getEmail()) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status">
                            <option value="active" <?= $user->getStatus() === 'active' ? 'selected' : '' ?>>Active</option>
                            <option value="inactive" <?= $user->getStatus() === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn-secondary">Save Changes</button>
                </form>

                <div class="action-buttons">
                    <form action="/pages/service_creation.php" method="POST">
                        <input type="hidden" name="csrf_token" value="<?= $session->getCSRFToken() ?? '' ?>">
                        <input type="hidden" name="userId" value="<?= htmlspecialchars((string)$user->getId()) ?>">
                        <button type="submit" class="btn-outline">Create new Service</button>
                    </form>
                    <a href="/pages/services_history.php?id=<?= htmlspecialchars((string)$user->getId()) ?>" class="btn-outline">Check your services history</a>
                    <a href="/pages/purchase_history.php?id=<?= htmlspecialchars((string)$user->getId()) ?>" class="btn-outline">Check your purchase history</a> 
                </div>
            </div>

            <div class="profile-right-column">
                <?php drawUserServices($user, $services); ?>
                
                <div class="profile-conversations-overview">
                    <div class="messages-overview">
                        <h2 class="section-title">Your Conversations</h2>
                        <ul>
                            <?php if (empty($conversationUsers)): ?>
                                <li>No conversations yet.</li>
                            <?php else: ?>
                                <?php foreach ($conversationUsers as $otherUser): ?>
                                    <li class="conversation-entry">
                                        <a href="/pages/chat.php?user_id=<?= $otherUser->getId() ?>">
                                            <img src="<?= htmlspecialchars($otherUser->getProfilePicture()) ?>" 
                                                alt="Profile picture of <?= htmlspecialchars($otherUser->getName()) ?>" 
                                                class="profile-picture-small">
                                            <span><?= htmlspecialchars($otherUser->getName()) ?></span>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>  
            </div>  
        </div>  
    </section>
<?php } ?>

<?php
function drawAdminStatusBar(User $user, Session $session): void
{ ?>
    <div class="admin-status-bar">
        <h2>Admin Status</h2>
        <p>This user is currently: <strong><?= $user->isAdmin() ? 'Admin' : 'Regular User' ?></strong></p>

        <form method="post" action="/actions/action_toggle_admin.php">
            <input type="hidden" name="csrf_token" value="<?= $session->getCSRFToken() ?? '' ?>">
            <input type="hidden" name="userId" value="<?= htmlspecialchars((string)$user->getId()) ?>">
            <input type="hidden" name="isAdmin" value="<?= $user->isAdmin() ? '0' : '1' ?>">
            <button type="submit" class="admin-toggle-btn btn-transition">
                <?= $user->isAdmin() ? 'Revoke admin privileges' : 'Elevate this user to admin' ?>
            </button>
        </form>
    </div>
<?php } ?>

<?php function drawUserServices(User $user, array $services): void
{
    if (empty($services)) {
        echo '<!-- No services to display -->';
        return;
    }
?>

    <section class="user-services-section">
        <div class="category-container">
            <h3 class="section-title"><?= htmlspecialchars($user->getName()) ?>'s services</h3>
            <div class="service-grid">
                <?php foreach ($services as $service): ?>
                    <article class="service-display card-hover-lift">
                        <div class="service-slider" data-service-id="<?= htmlspecialchars((string)$service->getId()) ?>">
                            <?php if (count($service->getImages()) > 1): ?>
                                <button class="slider-prev">‹</button>
                            <?php endif; ?>

                            <div class="slider-images">
                                <?php foreach ($service->getImages() as $index => $imgURL): ?>
                                    <a href="/pages/service_detail.php?id=<?= htmlspecialchars((string)$service->getId()) ?>">
                                        <img src="<?= htmlspecialchars($imgURL) ?>"
                                            alt="Service image <?= $index + 1 ?>"
                                            class="slider-image<?= $index === 0 ? ' active' : '' ?>">
                                    </a>
                                <?php endforeach; ?>
                            </div>

                            <?php if (count($service->getImages()) > 1): ?>
                                <button class="slider-next">›</button>
                            <?php endif; ?>
                        </div>

                        <div class="service-info">
                            <a href="/pages/service_detail.php?id=<?= htmlspecialchars((string)$service->getId()) ?>">
                                <h3 class="service-title"><?= htmlspecialchars($service->getTitle()) ?></h3>
                            </a>
                            <p class="service-price"><?= htmlspecialchars(strval($service->getPrice())) ?> €</p>
                            <p class="service-delivery">
                                Delivery: <?= htmlspecialchars(strval($service->getDeliveryTime())) ?> days</p>
                            <p class="service-rating">⭐ <?= htmlspecialchars(strval($service->getRating())) ?> / 5</p>
                            <p class="service-description text-clamp-3"><?= htmlspecialchars($service->getDescription()) ?></p>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php } ?>
