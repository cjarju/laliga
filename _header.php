<div class="header">
    <ul class="nav">
        <li><a href="index.php">Home</a></li>
        <li><a href="equipos.php">Equipos</a></li>
        <li><a href="clasificacion.php">Clasificación</a></li>
        <li><a href="partidos.php">Partidos</a></li>
        <li><a href="noticias.php">Noticias</a></li>

        <?php
            if ( isset($_SESSION['signed_in']) && $_SESSION['signed_in']) {
                echo "<li><a href='apuestas.php'>Apuestas</a></li>\n";
                echo "<li><a href='signout.php'>Signout</a></li>\n";
            } else {
                echo "<li ><a href = 'signup.php'>Signup</a ></li>\n";
                echo "<li ><a href = 'signin.php'>Signin</a ></li>\n";
            }
        ?>
    </ul>
    <img src="images/logos/lfp_transparent.png" alt="LogoLFP" />
</div>