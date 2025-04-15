

<?php function draw_loginForm():void
    {?>
        <form action="/actions/action_login.php" method="POST" class="login">
        <label for="username">Username</label>
        <input type="text" name="username" placeholder="username">

        <label for="password">Password</label>
        <input type="password" name="password" placeholder="password">

        <input type="submit" value="Login">
    </form>

<?php } ?>



<?php 
function draw_registerForm(): void { ?>
    <form action="/actions/action_register.php" method="POST" enctype="multipart/form-data" class="login">

        <label for="name">Name</label>
        <input type="text" name="name" placeholder="name">

        <label for="username">Username</label>
        <input type="text" name="username" placeholder="username">

        <label for="email">Email</label>
        <input type="email" name="email" placeholder="jhon@gmail.com">

        <label for="password">Password</label>
        <input type="password" name="password" placeholder="password">

        <label for="profilePicture">Profile Picture</label>
        <input type="file" name="profilePicture">

        <input type="submit" value="Register">
    </form>
<?php } ?>






