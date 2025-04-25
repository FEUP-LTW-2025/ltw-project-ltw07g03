<?php
declare(strict_types=1);
require_once(__DIR__ . '/../model/user.class.php');
require_once(__DIR__ . '/../model/service.class.php');

function drawUserProfile(User $user): void
{ ?>
    <section class="section profile-section">
        <div class="profile-header">
            <img src="<?= $user->getProfilePicture() ?>" alt="Profile Picture"
                 class="profile-picture-large">
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

<?php function drawEditableUserProfile(User $user): void
{ ?>
    <section class="section profile-section">
        <a href="/pages/purchase_history.php?id= <?= $user->getId() ?>">Check your purchase history</a>
        <div class="container">
            <h2>Edit Your Profile</h2>
            <form action="/actions/action_edit_profile.php" method="post" class="profile-card"
                  enctype="multipart/form-data">
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
                        <option value="inactive" <?= $user->getStatus() === 'inactive' ? 'selected' : '' ?>>Inactive
                        </option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </form>
            <form action="/pages/service_creation.php" method="POST">
                <input type="hidden" name="userId" value="<?= $user->getId() ?>">
                <button type="submit" class="btn-primary">Create new Service</button>
            </form>
        </div>
    </section>
<?php } ?>

<?php function drawUserServices(User $user, array $services): void
{ ?>
    <section class="user-services">
        <h3><?= $user->getName() ?>'s services</h3>
        <?php foreach ($services as $service): ?>
            <div class="service-card">
                <div class="service-image">
                    <a href="/pages/service_detail.php?id=<?= $service->getId() ?>">
                        <img
                                src="<?= $service->getImages()[0] ?? '/assets/images/default.jpeg' ?>"
                                alt="Service Image"
                        > </a>
                </div>
                <div class="service-info">
                    <a href="/pages/service_detail.php?id=<?= $service->getId() ?>">
                        <h3><?= $service->getTitle() ?></h3>
                    </a>
                    <p><strong>Price:</strong> <?= $service->getPrice() ?> €</p>
                    <p><strong>Delivery Time:</strong> <?= $service->getDeliveryTime() ?> days</p>
                    <p><strong>Rating:</strong> <?= $service->getRating() ?> / 5</p>
                    <p class="description"><?= $service->getDescription() ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </section>
<?php } ?>

