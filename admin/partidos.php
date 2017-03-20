<?php
    require_once '../phps/php_functions.php';
    require_once '_restrict.php';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//ES" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Partidos</title>
    <?php require_once '_head_elements.php'?>
</head>

<body>

<div class="container">

    <?php
        require_once '_header.php';
        require_once '../_signed_in_user.php';
        require_once '../_info_section.php';
    ?>

    <div class="content-box">
        <div class="table-box">

            <?php

            require_once '../config/db/_database.php';

            $arr = paginate('partidos',$conn);

            $sql = "SELECT partidos.id, home.nombre_equipo as equipo_local, away.nombre_equipo as equipo_away, goles_equipo_local, goles_equipo_away, fecha_partido FROM partidos INNER JOIN equipos as home ON equipo_local_id = home.id INNER JOIN equipos as away ON equipo_away_id = away.id order by fecha_partido desc LIMIT ? OFFSET ?";

            $stmt = $conn->prepare($sql);

            if ($stmt) {


                // bind parameters for markers
                $stmt->bind_param("ii", $el_limit, $el_offset);
                // set parameters and execute

                //
                $el_limit = $arr['limit'];
                $el_offset = $arr['offset'];
                $stmt->execute();

                $stmt->store_result();
                $stmt->bind_result($id, $equipo_local, $equipo_away, $goles_equipo_local, $goles_equipo_away, $fecha_partido);


                if ($stmt->num_rows > 0) {
                    $str = <<<STR
<table class='records' >
    <tr> <th>Equipo Local</th> <th> </th> <th> </th> <th> </th> <th>Equipo Visitante</th> <th>Fecha del Partido</th> <th>Editar</th> <th>Borrar</th> </tr>
STR;
                    echo $str;

                    while ($row = $stmt->fetch()) {
                        //$id = $row['id'];
                        //$fecha = $row['fecha_partido'];
                        //$titulo = $row['titulo'];

                        $str = <<<STR
<tr>
    <td> $equipo_local </td>
    <td> $goles_equipo_local </td>
    <td> - </td>
    <td> $goles_equipo_away </td>
    <td> $equipo_away </td>
    <td> $fecha_partido </td>
    <td> <a href="partidos/edit.php?id=$id"><span class='ui-icon ui-icon-pencil'>&nbsp;</span></a></td>
    <td> <a href="partidos/delete.php?id=$id" class='delete-confirmation'><span class='ui-icon ui-icon-trash'>&nbsp;</span></a></td>
</tr>
STR;
                        echo $str;

                    }

                    echo '</table>';

                    require_once '../phps/_show_paging_info.php';

                } else {
                    echo "<script type='text/javascript'>  $('#info-sect-1').html('No hay partidos')</script>";
                }

                // free result set
                $stmt->free_result();

                $stmt->close();
            }
            // close connection
            $conn->close();
            ?>

        </div>

        <div class="table-actions">
            <a href='partidos/new.php'>
                <span class='ui-icon ui-icon-plus' style='display: inline-block;'>&nbsp;</span>
                <span>Partido Nuevo</span>
            </a>
        </div>

    </div>

    <?php require_once '_footer.php'?>
</div> <!-- /container -->

<!-- core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
</body>
</html>
