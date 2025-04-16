<?php
declare(strict_types=1);
require_once(__DIR__ . '/../model/user.class.php');

function drawUserProfile(User $user): void
{ ?>
    <section class="section profile-section">
        <div class="container">
            <h2 class="section-title"><?= $user->getName() ?>'s Profile</h2>
            <div class="profile-card">
                <img src="<?= $user->getProfilePicture() ?>" alt="Profile Picture"
                     class="profile-picture">
                <div class="profile-details">
                    <p><strong>Username:</strong> <?= $user->getUsername() ?></p>
                    <p><strong>Email:</strong> <?= $user->getEmail() ?></p>
                    <p><strong>Status:</strong> <?= ucfirst($user->getStatus()) ?></p>
                    <p><strong>Role:</strong> <?= $user->isAdmin() ? 'Admin' : 'User' ?></p>
                </div>
            </div>
        </div>
    </section>
<?php } ?>
