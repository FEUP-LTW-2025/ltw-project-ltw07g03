<?php function drawLoginForm(Session $session): void
{ ?>
    <h2 class="section-title">Login</h2>
    <form action="/actions/action_login.php" method="POST" class="login">
        <input type="hidden" name="csrf_token" value="<?= $session->getCSRFToken() ?? '' ?>">
        <label for="username">Username</label>
        <input type="text" name="username" placeholder="username" required>

        <label for="password">Password</label>
        <input type="password" name="password" placeholder="password" required>

        <input type="submit" value="Login">
    </form>
<?php } ?>

<?php function drawRegisterForm(Session $session): void
{ ?>
    <h2 class="section-title">Register</h2>
    <form action="/actions/action_register.php" method="POST" enctype="multipart/form-data" class="login">
        <input type="hidden" name="csrf_token" value="<?= $session->getCSRFToken() ?? '' ?>">

        <label for="name">Name</label>
        <input type="text" name="name" placeholder="name" required>

        <label for="username">Username</label>
        <input type="text" name="username" placeholder="username" required>

        <label for="email">Email</label>
        <input type="email" name="email" placeholder="jhon@gmail.com" required>

        <label for="password">Password</label>
        <input type="password" name="password" placeholder="password" required>

        <label for="profilePicture">Profile Picture</label>
        <input type="file" name="profilePicture" id="registerPicture" required>
        <p id="profilePreviewLabel" class="preview-label">Selected Image</p>
        <div id="profile-preview-container" class="image-preview-container profile-preview-container"></div>
        <input type="submit" value="Register">
    </form>
<?php } ?>
