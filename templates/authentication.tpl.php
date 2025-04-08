

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


