<?php require_once 'phps/php_functions.php'; ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//ES" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Equipos</title>

    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />

    <link rel="shortcut icon" href="#" />

    <link rel="stylesheet" href="javascripts/vendor/jquery-ui/jquery-ui.min.css"  type="text/css" media="screen" />
    <link rel="stylesheet" href="javascripts/vendor/jquery-ui/jquery-ui.theme.min.css"  type="text/css" media="screen" />
    <link rel="stylesheet" href="stylesheets/estilos.css"  type="text/css" media="screen" />

    <script type="text/javascript" src="javascripts/vendor/jquery.min.js"></script>
    <script type="text/javascript" src="javascripts/vendor/jquery-ui/jquery-ui.min.js"></script>
    <script type="text/javascript" src="javascripts/vendor/jquery-ui/datepicker-es.js"></script>
    <script type="text/javascript" src="javascripts/comun.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            var id = getUrlParameter('id');

            if(id){
                getEquipoInfo("id"+id);
            } else {
                getEquipoInfo("id1");
            }



        });
    </script>
</head>

<body>

<div class="container">
    <?php require_once '_header.php'?>

    <div class="user-info-sect" id="user-sect-1">
        <?php
        if (isset($_SESSION['username'])) {
            echo "<span>Logged in as: <span id='username'>" . $_SESSION['username'] . "</span> </span>";
        }
        ?>
    </div>
    <div class="notification-sect-1" id="info-sect-1">
        <?php showNotifications() ?>
    </div>

    <div class="equipos-logos" id="equipos-logos" style="margin-bottom: 15px;border-radius:6px;background-color:#808080;">
    <?php
        require_once 'config/db/_database.php';

        $sql = "select * from equipos";

        $result = $conn->query($sql);
        if ($result->num_rows > 0) {

            while($row = $result->fetch_assoc()) {
                $id = $row['id'];
                $path_parts = pathinfo($row['ruta_logo']);
                $ext = $path_parts['extension'];
                $fname = $path_parts['filename'];
                $nombre_equipo = $row['nombre_equipo'];

                echo " <img src='images/logos/" . $fname . "-50x50." . $ext . "' alt='$fname' title='$nombre_equipo' id='id$id' onclick='getEquipoInfo(this.id)'/> ";

            }

        }  else {
            echo "<script type='text/javascript'> $('#equipos-logos').html('No hay equipos')</script>";
        }

    ?>
    </div>



    <div class="equipo-info" id="equipo-info" style="border-radius:6px;background-color:#808080;">
        <div id="logo-col" class="inline-block col-50-per sections-2" style="text-align:center">
            <h4 class="h4" id="nombre-equipo">El registro no encontrado</h4>
            <img src="images/logos/warning_grey.png" alt="Record Not Found"  id="logo-equipo"/>
        </div>
        <div id="info-col" class="inline-block col-50-per sections-2">
            <p>
                <span>Estadio: <br/></span>
                <span id="estadio" style="display:block"> </span>
                <span id="direccion" style="display:block"> </span>
            </p>
            <p>
                <span>Web: <br/></span>
                <span id="web"> </span>
            </p>
            <p>
                <span>Twitter: <br/></span>
                <span id="twitter"> </span>
            </p>
            <p>
                <span>Facebook: <br/></span>
                <span id="facebook"> </span>
            </p>
            <p>
                <span>Email: <br/></span>
                <span id="email"> </span>
            </p>
            <p>
                <span>Telefono: <br/></span>
                <span id="telefono"> </span>
            </p>

        </div>
    </div>


    <?php require_once '_footer.php'?>

</div> <!-- /container -->


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
</body>
</html>
