<?php
declare(strict_types=1);
require_once(__DIR__ . '/../model/user.class.php');

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

<?php function drawEditableUserProfile(User $user, $purchasesWithDetails): void
{ ?>
    <section class="section profile-section">
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

        <div class="right-column">
                <h3>Your Purchases</h3>
                <?php if(!empty($purchasesWithDetails)): ?>
                    <?php foreach ($purchasesWithDetails as $item): ?>
                        <div class="purchase-card">
                            <p><strong>Service:</strong> <?= htmlspecialchars($item['service']['title']) ?></p>
                            <p><strong>Freelancer:</strong> <?= htmlspecialchars($item['service']['freelancer']['name']) ?></p>
                            <p><strong>Status:</strong> <?= htmlspecialchars($item['purchase']->getStatus()) ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>You haven't made any purchases yet.</p>
                <?php endif; ?>
            </div>
    </section>
<?php } ?>
