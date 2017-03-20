<?php require_once 'phps/php_functions.php'; ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//ES" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Equipos</title>

    <meta name="keywords" content="Fichas, Jugadores, Entrenador, Partidos, Clasificación, Estadio" />
    <meta name="description" content="Las fichas de los equipos: jugadores, entrenador, partidos jugados, clasificación, estadio de fútbol" />

    <?php require_once '_head_elements.php' ?>
</head>

<body>

<div class="container">
    <?php
    require_once '_header.php';
    require_once '_signed_in_user.php';
    require_once '_info_section.php';
    ?>

    <div id="equipos-main-div">
    <div class="equipos-logos content-bgcolor" id="equipos-logos">
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

                echo "<a href='equipos.php?id=$id'><img src='images/logos/" . $fname . "-50x50." . $ext . "' alt='$fname' title='$nombre_equipo' /> </a>\n";

            }
        $result->free_result();
        }  else {
            echo "<script type='text/javascript'> $('#equipos-logos').html('No hay equipos')</script>";
        }

    ?>
    </div>


<div id="equipo-box">

    <div class="equipo-info content-bgcolor" id="equipo-info">

        <?php

        $res = $conn->query("select * from equipos order by id limit 1");
        if ($res->num_rows>0 && !isset($_GET['id'])) {  $_GET['id'] = $res->fetch_assoc()['id'] ; }

        $id = trim($_GET['id']);

        // create a prepared statement

        $sql = "select equipos.*, nombre_estadio, direccion from equipos inner join estadios on equipos.id = estadios.equipo_id where equipos.id = ?";

        //$sql = "SELECT * FROM equipos WHERE id = ?";

        $stmt = $conn->prepare($sql);

        if ($stmt) {

            // bind parameters for markers
            $stmt->bind_param("i", $el_id);

            // set parameters and execute
            $el_id = $id;
            $stmt->execute();

            /* return data as a mysqli_result object; avoids me storing stmt object and binding it*/
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                //fetch next row as an array
                $row = $result->fetch_assoc();
                $nombre = $row['nombre_equipo'];
                $logo_src = "images/logos/" . $row['ruta_logo'];
                $estadio = $row['nombre_estadio'];
                $direccion = $row['direccion'];
                $web = $row['web'];
                $twitter = $row['twitter'];
                $facebook = $row['facebook'];
                $email = $row['email'];
                $telefono = $row['telefono'];

                $twitter_url_suffix = substr($twitter,1);

$str = <<<STR
<div id="logo-col" class="inline-block wdt-48-per sections-2">
    <h2 class="h2" id="nombre-equipo">$nombre</h2>
    <img src="$logo_src" alt="Record Not Found"  id="logo-equipo"/>
</div>
<div id="info-col" class="inline-block wdt-48-per sections-2">
    <p id="p-estadio">
        <span class="hdr-med block">Estadio: </span>
        <span id="estadio" class="block text-size-small">$estadio</span>
        <span id="direccion" class="text-size-small">$direccion</span>
    </p>
    <p>
        <span class="hdr-med block">Web: </span>
        <a href="$web#" target="_blank"><span id="web" class="text-size-small">$web</span></a>
    </p>
    <p>
        <span class="hdr-med block">Twitter: </span>
        <a href="https://twitter.com/$twitter_url_suffix#" target="_blank"><span id="twitter" class="text-size-small">$twitter</span></a>
    </p>
    <p>
        <span class="hdr-med block">Facebook: </span>
        <a href="$facebook#" target="_blank"><span id="facebook" class="text-size-small">$facebook</span></a>
    </p>
    <p>
        <span class="hdr-med block">Email: </span>
        <a href="mailto:$email#" target="_blank"><span id="email" class="text-size-small">$email</span></a>
    </p>
    <p>
        <span class="hdr-med block">Telefono: </span>
        <span id="telefono" class="text-size-small">$telefono</span>
    </p>

</div>
STR;
echo $str . "\n";

                //free result
                $result->free_result();

                /* get other info related to equipo */

                $sql = "select * from jugadores where equipo_id = $el_id";
                $jugadores = $conn->query($sql);

                $sql = "select * from entrenadores where equipo_id = $el_id";
                $entrenador = $conn->query($sql);

                $sql = "SELECT partidos.id, home.nombre_equipo as equipo_local, away.nombre_equipo as equipo_away, goles_equipo_local, goles_equipo_away, fecha_partido FROM partidos INNER JOIN equipos as home ON equipo_local_id = home.id INNER JOIN equipos as away ON equipo_away_id = away.id where (equipo_local_id = $el_id or equipo_away_id = $el_id) and goles_equipo_local is not null";
                $partidos = $conn->query($sql);

                $conn->query("SET @a=0");
                $sql = "select * from (select @a:=@a+1 rank, clasificacion.*, ruta_logo, nombre_equipo from clasificacion inner join equipos on equipos.id  = clasificacion.equipo_id order by puntos desc)t where equipo_id = $el_id";
                $clasificacion = $conn->query($sql);
$str = <<<STR
</div>
<div id="jug-entr" class="equipo-info-tbl-box content-bgcolor">
    <h3 class="h3">Jugadores y Entrenador</h3>
STR;
echo $str . "\n";


                if ( $jugadores->num_rows>0) {
$str = <<<STR
<table class="records text-size-small equipo-info-tbl">
 <tr>
   <th> Nombre </th> <th> Apellido </th> <th> Dorsal </th> <th> Posicion </th>
 </tr>
STR;
echo $str . "\n";

                    while ($row = $jugadores->fetch_assoc()) {
                        //nombre_jugador, apellidos_jugador, dorsal_jugador, posicion_jugador
                        $nombre = $row['nombre_jugador'];
                        $apellido = $row['apellidos_jugador'];
                        $dorsal = $row['dorsal_jugador'];
                        $posicion = $row['posicion_jugador'];
$str = <<<STR
<tr>
    <td> $nombre </td>
    <td> $apellido </td>
    <td> $dorsal </td>
    <td> $posicion </td>
</tr>
STR;
echo $str . "\n";

                    }

if ( $entrenador->num_rows>0) {
    $row = $entrenador->fetch_assoc();
    $nombre = $row['nombre'];
    $apellido = $row['apellidos'];

$str = <<<STR
<tr>
    <td> $nombre </td>
    <td> $apellido </td>
    <td> &nbsp; </td>
    <td> Entrenador </td>
</tr>
STR;
echo $str;

    $entrenador->free_result();
}

echo "</table>\n";

                    $jugadores->free_result();
                }

echo "</div>\n";

echo "<div id='partidos-jugados' class='equipo-info-tbl-box content-bgcolor'>\n";
echo "<h3 class='h3'>Partidos Jugados</h3>\n";

                if ( $partidos->num_rows>0) {
$str = <<<STR
<table class='records text-size-small equipo-info-tbl'>
    <tr> <th>Equipo Local</th> <th> </th> <th> </th> <th> </th> <th>Equipo Visitante</th> <th>Fecha del Partido</th>  </tr>
STR;
echo $str . "\n";

                    while ($row = $partidos->fetch_assoc()) {
                        //home.nombre_equipo as equipo_local, away.nombre_equipo as equipo_away, goles_equipo_local, goles_equipo_away, fecha_partido
                        $equipo_local = $row['equipo_local'];
                        $goles_equipo_local = $row['goles_equipo_local'];
                        $goles_equipo_away = $row['goles_equipo_away'];
                        $equipo_away = $row['equipo_away'];;
                        $fecha_partido = $row['fecha_partido'];

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


                    $partidos->free_result();
                }

echo "</div>";
echo "<div id='clasif-equip' class='equipo-info-tbl-box content-bgcolor'>";
echo "<h3 class='h3'>Clasificación</h3>";
                
                if ($clasificacion->num_rows > 0) {

$str = <<<STR
<table class='records text-size-small equipo-info-tbl'>
    <tr>
    <th></th> <th></th> <th></th>
    <th title='Puntos'>Ptos</th>
    <th title='Partidos Jugados'>PJ</th>
    <th title='Partidos Ganados'>PG</th> <th title='Partidos Empatados'>PE</th> <th title='Partidos Perdidos'>PP</th>
    <th title='Goles a favor'>GA</th> <th title='Goles en contra'>GC</th>
</tr>
STR;
echo $str . "\n";

                    $row = $clasificacion->fetch_assoc();

                    // puntos 	jugados 	ganados 	empatados 	perdidos 	goles_a_favor 	goles_en_contra 	ruta_logo 	nombre_equipo
                    $id = $row['id'];
                    $puntos = $row['puntos'];
                    $jugados = $row['jugados'];
                    $ganados =  $row['ganados'];
                    $empatados =  $row['empatados'];
                    $perdidos =  $row['perdidos'];
                    $goles_a_favor =  $row['goles_a_favor'];
                    $goles_en_contra =  $row['goles_en_contra'];
                    $ruta_logo =  $row['ruta_logo'];
                    $nombre_equipo =  $row['nombre_equipo'];
                    $image_filename = pathinfo($ruta_logo, PATHINFO_FILENAME);
                    $image_extension = pathinfo($ruta_logo, PATHINFO_EXTENSION);
                    $rank = $row['rank'];

$str = <<<STR
<tr>
    <td>$rank</td> <td><img src='images/logos/$image_filename-15x15.$image_extension' alt='$nombre_equipo' class="tiny-logo" /></td>  <td> <span>$nombre_equipo</span> </td>  <td>$puntos</td> <td>$jugados</td> <td>$ganados</td> <td>$empatados</td> <td>$perdidos</td> <td>$goles_a_favor</td> <td>$goles_en_contra</td>
</tr>
</table>
STR;
echo $str . "\n";


                    // free result set
                    $clasificacion->free_result();
                }

            } else {

$str = <<<STR
<div id="logo-col" class="inline-block col-50-per sections-2">
            <h4 class="h4" id="nombre-equipo">El registro no encontrado</h4>
            <img src="images/logos/warning_grey.png" alt="Record Not Found"  id="logo-equipo"/>
</div>
STR;
echo $str . "\n";

            }

            // close statement
            $stmt->close();

        }
        else {
            //prepare failed in preparing statement
            //false is returned if prepare fails. $stmt has false
            echo "";
        }
        ?>

</div>
</div>
<?php
// close connection
$conn->close();
?>
    </div>
    <?php require_once '_footer.php'?>

</div> <!-- /container -->

</body>
</html>
