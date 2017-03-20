<?php

require_once '../../phps/php_functions.php';
require_once '../_restrict_subdir.php';

/* generate a form token valid for 15 mins. the form will expire after this time
   limits the possibility of cross site request forgery (XSRF)
*/
generateFormToken('signin',900);


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//ES" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Edit | Partidos</title>
    <?php require_once '../_head_elements_subdir.php'?>
</head>

<body>

<div class="container">

    <?php
        require_once '../_header_subdir.php';
        require_once '../../_signed_in_user.php';
        require_once '../../_info_section.php';
    ?>

    <div class="content-box">
        <div class="form-box">
            <?php

            require_once '../../config/db/_database.php';




            $id = $_GET['id'];


            $sql = "SELECT partidos.id, home.id as local_id, home.nombre_equipo as equipo_local, away.nombre_equipo as equipo_away, away.id as away_id, goles_equipo_local, goles_equipo_away, fecha_partido FROM partidos INNER JOIN equipos as home ON equipo_local_id = home.id INNER JOIN equipos as away ON equipo_away_id = away.id WHERE partidos.id = '$id'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                $id_partido = trim($row['id']);
                $id_local = trim($row['local_id']);
                $id_away = trim($row['away_id']);
                $equipo_local = trim($row['equipo_local']);
                $equipo_away = trim($row['equipo_away']);
                $goles_equipo_local = trim($row['goles_equipo_local']);
                $goles_equipo_away = trim($row['goles_equipo_away']);
                $fecha_partido = trim($row['fecha_partido']);


                echo setDatepickerValue("#fecha_partido", $fecha_partido);

                $sql = "SELECT id, nombre_equipo FROM equipos";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {

                    // output data of each row
                    $str_local="";
                    while($row = $result->fetch_assoc()) {
                        $id_equipo = $row['id'];
                        $name = $row['nombre_equipo'];

                        if ($id_local == $id_equipo) {
                            $opt = "<option value='$id_equipo' selected='selected'> $name </option>";
                        } else {
                            $opt = "<option value='$id_equipo'> $name </option>";
                        }

                        $str_local .= $opt;
                    }

                    $str_away="";
                    $result->data_seek(0);
                    while($row = $result->fetch_assoc()) {
                        $id_equipo = $row['id'];
                        $name = $row['nombre_equipo'];

                        if ($id_away == $id_equipo) {
                            $opt = "<option value='$id_equipo' selected='selected'> $name </option>";
                        } else {
                            $opt = "<option value='$id_equipo'> $name </option>";
                        }

                        $str_away .= $opt;
                    }

                }


$form = <<<STR
<form method="post" name="edit-partido" id="edit-partido" class="rec-form" action="do_edit.php" onsubmit="return validateForm(this.id)">
<fieldset>
  <legend>Editar Partido</legend>

   <p>
        <input type="hidden" name="rec_id" id="rec_id" value="$id" />
    </p>
    <p style="display:inline;">
        <label id="equipo_local-label" for="equipo_local" class="form-label-2"> Local </label>
        <select name="equipo_local" id="equipo_local" class="equipos obligatorio">

                 $str_local

        </select>
    </p>
    <p style="display:inline;">
        <input type="text" name="goles_equipo_local" id="goles_equipo_local" class="goles" value='$goles_equipo_local' />
    </p>
    <span>&nbsp; - &nbsp; </span>
    <p style="display:inline;">
        <input type="text" name="goles_equipo_away" id="goles_equipo_away" class="goles" value='$goles_equipo_away' />
    </p>
    <p style="display:inline;">
        <select name="equipo_away" id="equipo_away" class="equipos obligatorio">

            $str_away

        </select>
        <label id="equipo_away-label" for="equipo_away" class="form-label-2"> Visitante </label>
    </p>
    <p>
        <label id="fecha_partido-label" for="fecha_partido" class="form-label-2"> Fecha del partido: </label>
        <input type="text" name="fecha_partido" id="fecha_partido" class="datefield obligatorio" value='$fecha_partido' />
    </p>
    <p style="display:inline;">
        <input type="submit" value="Guardar" class="btn-primary" />
    </p>
</fieldset>
</form>
STR;

echo $form;



            } else {
                /* if session variable is not set it must be initialized in document contains HTML code
                i initialized in the php_functions.php file but when i try to assign value to array i
                get a warning that it is not set
                */
                if (!isset($_SESSION['flash'])) {
                    $_SESSION['flash'] = array();
                }

                array_push($_SESSION['flash'], "No se pudo cargar el registro.");
                redirect("../partidos.php");
            }

            // free result set
            $result->free_result();

            // close connection
            $conn->close();


            ?>
        </div>
    </div>

    <?php require_once '../_footer.php'?>
</div> <!-- /container -->

<!-- core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
</body>
</html>





