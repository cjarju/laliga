<?php

require_once 'phps/php_functions.php';

/* generate a form token valid for 5 mins. the form will expire after this time
   limits the possibility of cross site request forgery (XSRF)
*/
generateFormToken('signin',300);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//ES" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Signin</title>

    <meta name="keywords" content="Usuario, Contraseña, Sesión" />
    <meta name="description" content="Iniciar sesión para poder apostar" />

    <meta name="keywords" content="Registrar, Apostar" />
    <meta name="description" content="Registrarse para poder apostar" />

    <?php require_once '_head_elements.php' ?>

</head>

<body>

<div class="container">
    <?php
    require_once '_header.php';
    require_once '_info_section.php';
    ?>

    <form class="form-signin-up" name="signin" id="signin" method="post" action="phps/signin.php" onsubmit="return validateForm(this.id)">
        <h2 class="form-signin-heading h2">Iniciar sesión</h2>
        <label id="username-label" for="username">ID de usuario: </label> <input type="text" name="username" id="username" class="obligatorio input-text safe-alphanum1" />
        <label id="password-label" for="password">Contraseña: </label>  <input type="password" name="password" id="password" class="obligatorio input-password safe-alphanum2"  />

         <input type="submit" class="btn-primary" value="Sign in" />
    </form>


    <?php require_once '_footer.php'?>

</div> <!-- /container -->

</body>
</html>
