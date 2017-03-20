<?php require_once 'phps/php_functions.php'; ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//ES" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Partidos</title>

    <meta name="keywords" content="Partidos, Jugados, Resultados" />
    <meta name="description" content="Los partidos ya jugados y sus resultados" />

    <?php require_once '_head_elements.php' ?>
</head>

<body>

<div class="container">
    <?php
    require_once '_header.php';
    require_once '_signed_in_user.php';
    require_once '_info_section.php';
    ?>

    <div id="partidos-box" class="content-bgcolor">
        <h1 class="h1">Partidos Jugados</h1>

            <?php

            require_once 'config/db/_database.php';

            $arr = paginate('partidos',$conn, 'partidos.goles_equipo_local is not null');

            $sql = "SELECT partidos.id, home.nombre_equipo as equipo_local, away.nombre_equipo as equipo_away, goles_equipo_local, goles_equipo_away, fecha_partido FROM partidos INNER JOIN equipos as home ON equipo_local_id = home.id INNER JOIN equipos as away ON equipo_away_id = away.id where partidos.goles_equipo_local is not null LIMIT ? OFFSET ?";

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
<table class='records text-size-small' id="partidos-table">
    <tr> <th>Equipo Local</th> <th> </th> <th> </th> <th> </th> <th>Equipo Visitante</th> <th>Fecha del Partido</th>  </tr>
STR;
echo $str . "\n";
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
</tr>
STR;
echo $str . "\n";

                    }

echo "</table>\n";

                    require_once 'phps/_show_paging_info.php';

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

    <?php require_once '_footer.php'?>

</div> <!-- /container -->


</body>
</html>
