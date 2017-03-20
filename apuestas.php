<?php

require_once 'phps/php_functions.php';

if (isset($_SESSION['username'])) {
    $username =  $_SESSION['username'];
    $userid = $_SESSION['user_id'];
} else {
    $_SESSION['request_url'] = curPageURL();
    redirect ('signin.php');
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//ES" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Apuestas</title>

    <meta name="keywords" content="Apuestas" />
    <meta name="description" content="Apuestas disponibles y hechas por el usuario" />

    <?php require_once '_head_elements.php' ?>
</head>

<body>

<div class="container">

    <?php
        require_once '_header.php';
        require_once '_signed_in_user.php';
        require_once '_info_section.php';
    ?>

    <div class="apuestas-main-div content-bgcolor">

        <h1 class="h1">Partidos y Apuestas</h1>

        <div class="apuestas-juegos-box">

            <?php

            require_once 'config/db/_database.php';

            $arr = paginate('partidos',$conn, 'partidos.goles_equipo_local is null');

$sql = <<<STR
select betable_games.*, user_bets.goles_equipo_1, user_bets.goles_equipo_2 from
(SELECT partidos.id, home.nombre_equipo as equipo_local, home.id as equipo_1_id, away.nombre_equipo as equipo_away, away.id as equipo_2_id, goles_equipo_local, goles_equipo_away, fecha_partido
FROM partidos INNER JOIN equipos as home ON equipo_local_id = home.id
INNER JOIN equipos as away ON equipo_away_id = away.id where partidos.goles_equipo_local is null) betable_games
LEFT OUTER JOIN (select * from apuestas where usuario_id = ?) user_bets on betable_games.id = user_bets.partido_id LIMIT ? OFFSET ?
STR;


            $stmt = $conn->prepare($sql);

            if ($stmt) {


                // bind parameters for markers
                $stmt->bind_param("iii", $el_user_id, $el_limit, $el_offset);
                // set parameters and execute

                //
                $el_user_id =  $userid;
                $el_limit = $arr['limit'];
                $el_offset = $arr['offset'];
                $stmt->execute();

                $stmt->store_result();
                $stmt->bind_result($id, $equipo_local, $equipo_1_id, $equipo_away, $equipo_2_id, $goles_equipo_local, $goles_equipo_away, $fecha_partido, $goles_equipo_1, $goles_equipo_2);


                if ($stmt->num_rows > 0) {
$str = <<<STR
<table class='records text-size-small' id='bet-table'>
    <tr> <th>Equipo Local</th> <th> </th> <th> </th> <th> </th> <th>Equipo Visitante</th> <th>Fecha del Partido</th> <th>Elegir</th> </tr>
STR;
                    echo $str . "\n";

                    while ($row = $stmt->fetch()) {
                        //$id = $row['id'];
                        //$fecha = $row['fecha_partido'];
                        //$titulo = $row['titulo'];

$str = <<<STR
<tr id="partido-id-$id">
    <td class="equipo_local" id="equipo-id-$id-$equipo_1_id">$equipo_local</td>
    <td class="goles_1">$goles_equipo_1</td>
    <td> - </td>
    <td class="goles_2">$goles_equipo_2</td>
    <td class="equipo_away" id="equipo-id-$id-$equipo_2_id">$equipo_away</td>
    <td>$fecha_partido</td>
    <td class="radio-td"><input type="radio" name="partido" id="id-$id" class="apostar-radio" style="display:inline-block" /></td>
</tr>
STR;
                        echo $str . "\n";

                    }

echo "</table>\n";

                    require_once 'phps/_show_paging_info.php';

                } else {
                    echo "<script type='text/javascript'>  $('#info-sect-1').html('No hay partidos')</script>\n";
                }

                // free result set
                $stmt->free_result();

                $stmt->close();
            }
            // close connection
            $conn->close();
            ?>

        </div>
    </div>

    <div id="apuesta-form-box" class="content-bgcolor">

        <h3 class="h3">Resultado</h3>

        <form action="phps/apostar.php" id="apostar-form" name="apostar-form" method="post" onsubmit="return validateForm(this.id)">

            <input type="hidden" id="partido_id" name="partido_id" />
            <input type="hidden" id="usuario_id" name="usuario_id" value="<?php echo $userid ?>" />
            <input type="hidden" id="home_team" name="home_team" />
            <input type="hidden" id="away_team" name="away_team" />
            <p>
                <span id="local_team_label"> Equipo local: </span>
                <input type="text" name="goles_equipo_1"  id="goles_equipo_1" class="obligatorio numeric goles_apuesta"/>
                <input type="text" name="goles_equipo_2" id="goles_equipo_2" class="obligatorio numeric goles_apuesta" />
                <span id="away_team_label"> Equipo Visitante </span>
            </p>
            <input type="submit" value="Apostar" class="btn-primary" />


        </form>
    </div>
    <?php require_once '_footer.php'?>

</div> <!-- /container -->

</body>
</html>
