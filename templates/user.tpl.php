<?php
declare(strict_types=1);
require_once(__DIR__ . '/../model/user.class.php');
require_once(__DIR__ . '/../model/service.class.php');

function drawUserProfile(User $user): void
{ ?>
    <section class="section profile-section">
        <div class="profile-header">
            <img src="<?= $user->getProfilePicture() ?>" alt="Profile Picture" class="profile-picture-large">
            <h2><?= $user->getName() ?></h2>
            <p class="profile-username">@<?= $user->getUsername() ?></p>
        </div>

        <div class="container">
            <div class="profile-card">
                <h3 class="card-title">User Information</h3>
                <ul class="profile-info">
                    <li><span>Email:</span> <?= $user->getEmail() ?></li>
                    <li><span>Status:</span> <?= ucfirst($user->getStatus()) ?></li>
                    <li><span>Role:</span> <?= $user->isAdmin() ? 'Admin' : 'User' ?></li>
                </ul>
            </div>
        </div>
    </section>
<?php } ?>

<?php function drawEditableUserProfile(User $user, $conversationUsers): void
{ ?>
    <section class="section profile-section">
        <div class="container">
            <h2 class="section-title">Edit Your Profile</h2>
            <form action="/actions/action_edit_profile.php" method="post" class="profile-card" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $user->getId() ?>">
                <div class="form-group center">
                    <img src="<?= $user->getProfilePicture() ?>" class="profile-picture-large">
                    <input type="file" name="profilePicture" id="profilePicture" accept="image/*">
                </div>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" value="<?= $user->getName() ?>" required>
                </div>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" value="<?= $user->getUsername() ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" value="<?= $user->getEmail() ?>" required>
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
                    <input type="hidden" name="userId" value="<?= $user->getId() ?>">
                    <button type="submit" class="btn-outline">Create new Service</button>
                </form>
                <a href="/pages/services_history.php?id=<?= $user->getId() ?>" class="btn-outline">Check your services history</a>
                <a href="/pages/purchase_history.php?id=<?= $user->getId() ?>" class="btn-outline">Check your purchase history</a> 
            </div>

            <div class="messages-overview">
                <h3>Your Conversations</h3>
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
    </section>
<?php } ?>

<?php
function drawAdminStatusBar(User $user): void
{ ?>
    <div class="admin-status-bar">
        <h2>Admin Status</h2>
        <p>This user is currently: <strong><?= $user->isAdmin() ? 'Admin' : 'Regular User' ?></strong></p>

        <form method="post" action="/actions/action_toggle_admin.php">
            <input type="hidden" name="userId" value="<?= $user->getId() ?>">
            <input type="hidden" name="isAdmin" value="<?= $user->isAdmin() ? '0' : '1' ?>">
            <button type="submit" class="admin-toggle-btn">
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
            <h3 class="section-category-title"><?= htmlspecialchars($user->getName()) ?>'s services</h3>
            <div class="service-grid">
                <?php foreach ($services as $service): ?>
                    <article class="service-display">
                        <a href="/pages/service_detail.php?id=<?= $service->getId() ?>">
                            <img src="<?= htmlspecialchars($service->getImages()[0] ?? '/assets/images/default.jpeg') ?>" 
                                alt="Service Image" class="service-image">
                        </a>
                        <div class="service-info">
                            <a href="/pages/service_detail.php?id=<?= $service->getId() ?>">
                                <h3 class="service-title"><?= htmlspecialchars($service->getTitle()) ?></h3>
                            </a>
                            <p class="service-price"><?= htmlspecialchars(strval($service->getPrice())) ?> €</p>
                            <p class="service-delivery">Delivery: <?= htmlspecialchars(strval($service->getDeliveryTime())) ?> days</p>
                            <p class="service-rating">⭐ <?= htmlspecialchars(strval($service->getRating())) ?> / 5</p>
                            <p class="service-description"><?= htmlspecialchars($service->getDescription()) ?></p> 
                        </div>   
                </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php } ?>
