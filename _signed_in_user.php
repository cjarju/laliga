<div class="user-info-sect" id="user-sect-1">
    <?php
    if (isset($_SESSION['username'])) {
        echo "<span>Logged in as: <span id='username' class='notification-color'>" . $_SESSION['username'] . "</span> </span>\n";
    }
    ?>
</div>