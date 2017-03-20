<div class="header">
    <ul class="nav">
        <li id="equipos-menu-link"><a href="../equipos.php">Equipos</a></li>
        <li id="partidos-menu-link"><a href="../partidos.php">Partidos</a></li>
        <li id="noticias-menu-link"><a href="../noticias.php">Noticias</a></li>
        <?php
        if (isset($_SESSION['is_admin']) || $_SESSION['is_admin']) {
            echo '<li><a href="../../signout.php">Signout</a></li>';
        }
        ?>
    </ul>
    <img src="../../images/logos/lfp_transparent.png" alt="LogoLPF" />
    <!-- <h3 class="text-muted">Project name</h3> -->
</div>