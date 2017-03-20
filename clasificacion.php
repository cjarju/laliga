<?php
require_once 'phps/php_functions.php';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//ES" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Clasificación</title>

    <meta name="keywords" content="Clasificación" />
    <meta name="description" content="Clasificación de los equipos en la LFP" />

    <?php require_once '_head_elements.php' ?>
</head>

<body>

<div class="container">
    <?php
    require_once '_header.php';
    require_once '_signed_in_user.php';
    require_once '_info_section.php';

    ?>
    <div id="clasificacion-box" class="content-bgcolor">

        <h1 class="h1">Clasificación</h1>

        <?php
            require_once 'config/db/_database.php';
            $conn->query("SET @a=0");

$sql = <<<STR
select @a:=@a+1 rank, clasificacion.*, ruta_logo, nombre_equipo from clasificacion
inner join equipos on equipos.id  = clasificacion.equipo_id  order by puntos desc;
STR;

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {

$str = <<<STR
<table class='classificacion' id='clasificacion-grande'>
    <tr>
    <th></th> <th></th> <th></th>
    <th title='Puntos'>Ptos</th>
    <th title='Partidos Jugados'>PJ</th>
    <th title='Partidos Ganados'>PG</th> <th title='Partidos Empatados'>PE</th> <th title='Partidos Perdidos'>PP</th>
    <th title='Goles a favor'>GA</th> <th title='Goles en contra'>GC</th>
    </tr>
STR;
echo $str . "\n";

            while($row = $result->fetch_assoc()) {
                //++$i;
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
STR;
echo $str . "\n";
            }
echo "</table>\n";
                // free result set
                $result->free_result();

                $conn->close();
        }
        ?>

    </div>



    <?php require_once '_footer.php'?>

</div> <!-- /container -->

</body>
</html>
