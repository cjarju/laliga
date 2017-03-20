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
    <title>New | Partidos</title>
    <?php require_once '../_head_elements_subdir.php'?>
</head>

<body>

<div class="container">

    <?php
        require_once '../_header_subdir.php';
        require_once '../../_signed_in_user.php';
        require_once '../../_info_section.php';
    ?>

    <?php
        require_once '../../config/db/_database.php';

    $sql = "SELECT id, nombre_equipo FROM equipos";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {

        // output data of each row
        $str="";
        while($row = $result->fetch_assoc()) {
            $id = $row['id'];
            $name = $row['nombre_equipo'];
            $str .= "<option value='$id'> $name </option>";
        }

        // free result set
        $result->free_result();
    }

    // close connection
    $conn->close();

    ?>

    <div class="content-box">
        <div class="form-box">
            <form method="post" name="new-partido" id="new-partido" class="rec-form" action="create.php"  onsubmit="return validateForm(this.id)">
                <fieldset>
                    <legend>Nuevo Partido</legend>

                    <p style="display:inline;">
                        <label id="equipo_local-label" for="equipo_local" class="form-label-2"> Local </label>
                        <select name="equipo_local" id="equipo_local" class="equipos obligatorio">
                            <?php
                            if(!empty($str)) {
                                echo $str;
                            }

                            ?>
                        </select>
                    </p>
                    <p style="display:inline;">
                        <input type="text" name="goles_equipo_local" id="goles_equipo_local" class="goles" />
                    </p>
                    <span>&nbsp; - &nbsp; </span>
                    <p style="display:inline;">
                        <input type="text" name="goles_equipo_away" id="goles_equipo_away" class="goles" />
                    </p>
                    <p style="display:inline;">
                        <select name="equipo_away" id="equipo_away" class="equipos obligatorio">
                            <?php
                            if(!empty($str)) {
                                echo $str;
                            }

                            ?>
                        </select>
                        <label id="equipo_away-label" for="equipo_away" class="form-label-2"> Visitante </label>
                    </p>
                    <p>
                        <label id="fecha_partido-label" for="fecha_partido" class="form-label-2"> Fecha del partido: </label>
                        <input type="text" name="fecha_partido" id="fecha_partido" class="datefield obligatorio" />
                    </p>
                    <p style="display:inline;">
                        <input type="submit" value="Crear" class="btn-primary" />
                    </p>
                </fieldset>
            </form>
        </div>
    </div>

    <?php require_once '../_footer.php'?>
</div> <!-- /container -->

<!-- core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
</body>
</html>





