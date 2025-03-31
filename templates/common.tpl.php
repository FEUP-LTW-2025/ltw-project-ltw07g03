<?php
declare(strict_types = 1);
require_once(__DIR__ . '/../utils/session.php');
?>

    
<?php function drawHeader(Session $session){ ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>DeepWeb Fiver</title>
    </head>
    <body>
        <header>
        <h1><a href="/">DeepWeb Fiver</a></h1>

      <?php 
        if ($session->isLoggedIn()) drawLogoutForm($session);
        else drawLoginForm($session);

      ?>
        </header>


        <section id="messages">
            <?php foreach ($session->getMessages() as $messsage) { ?>
                <article class="<?=$messsage['type']?>">
                    <?=$messsage['text']?>
                </article>
            <?php } ?>
    </section>


    <main>

<?php } ?>




<?php function drawFooter() { ?>
    </main>

    <footer>
      DeepWeb Fivver &copy; 2025
    </footer>

  </body>
</html>
<?php } ?>




<?php function drawLoginForm(){ ?>
    <form action="action_login.php" method="post" class="login">

    <label>Email:</label>
    <input type="email" name="email" placeholder="jhon123@gmail.com">

    <label>Password:</label>
    <input type="password" name="password" placeholder="password">

    <a href="../pages/register.php">Register</a>
    <button type="submit">Login</button>
    
</form>

<?php } ?>



<?php   function drawLogoutForm(Session $session){ ?>
    <form action="../actions/action_logout.php" method="post" class="logout">
            <a href="../pages/profile.php"><?php $session->getName()?></a>
            <button type="submit">Logout</button>
          </form>
<?php } ?>




