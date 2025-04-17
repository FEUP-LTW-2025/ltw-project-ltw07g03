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
