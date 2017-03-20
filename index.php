<?php

    require_once 'phps/php_functions.php';

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//ES" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Home</title>

    <meta name="keywords" content="Equipos, LFP, Clasificación" />
    <meta name="description" content="Los equipos, la clasificación y las últimas noticias de la LFP" />

    <?php require_once '_head_elements.php' ?>
</head>

<body>



<div class="container">

    <?php
        require_once '_header.php';
        require_once '_signed_in_user.php';
        require_once '_info_section.php';
    ?>

    <div id="news-box" class="content-bgcolor">

        <?php

        require_once 'config/db/_database.php';

        $sql = "select * from noticias order by fecha_noticia desc limit 3";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {

            $row = $result->fetch_assoc();
            $id = $row['id'];
            $ruta_foto = $row['ruta_foto'];
            $titulo = $row['titulo'];

$str = <<<STR
<a href='noticias.php?id=$id' title='$titulo' class='block'>
    <img src='images/noticias/$ruta_foto'  alt='$titulo'  />
    <span id="news-title-box" class='block'>
    <span>$titulo</span>
    </span>
</a>
STR;
echo $str . "\n";

            echo '<div id="news-list-box">';

                while($row = $result->fetch_assoc()) {
                    $id = $row['id'];
                    $path_parts = pathinfo($row['ruta_foto']);
                    $ext = $path_parts['extension'];
                    $fname = $path_parts['filename'];
                    $titulo = $row['titulo'];
$str = <<<STR
<div class='inline-block wdt-50-per' id='news-list-item-$id'>
    <p class='inline-block wdt-48-per' >
    <a href='noticias.php?id=$id' title='$titulo' class='block'> <img src='images/noticias/$fname-140x79.$ext' alt='$titulo' /> </a>
    </p>
    <p class='inline-block wdt-48-per'>
    <a href='noticias.php?id=$id' title='$titulo' class='block'> $titulo </a>
    </p>
</div>
STR;
echo $str;
                }
            echo '</div>';

            // free result set
            $result->free_result();

        } else {
            echo "<script type='text/javascript'> $('#news-box').html('No hay noticias')</script>";
        }
        ?>
    </div> <!-- news-box -->

    <div id="sections-box-1">
        <div class="inline-block wdt-48-per sections-1 content-bgcolor">
            <h2 class="h2">Equipos</h2>
            <?php
                $sql = "select * from equipos";

                $result = $conn->query($sql);

                if ($result->num_rows > 0) {

                    while($row = $result->fetch_assoc()) {
                        $id = $row['id'];
                        $nombre = $row['nombre_equipo'];
                        $image_name = $row['ruta_logo'];
                        $image_filename = pathinfo($image_name, PATHINFO_FILENAME);
                        $image_extension = pathinfo($image_name, PATHINFO_EXTENSION);
$str = <<<STR
<a href='equipos.php?id=$id' title='$nombre'>
    <img src='images/logos/$image_filename-50x50.$image_extension' alt='$nombre' title='$nombre' class='equipo-logo-home' />
</a>
STR;
echo $str . "\n";
                    }

                    // free result set
                    $result->free_result();
                }
            ?>

        </div>

        <div class="inline-block wdt-50-per sections-1 content-bgcolor">
            <h2 class="h2">Clasificación</h2>

            <?php
            $sql = "select clasificacion.*, ruta_logo, nombre_equipo from clasificacion inner join equipos on equipos.id  = clasificacion.equipo_id  order by puntos desc limit 12";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $i =0;
                //<th title='Partidos Ganados'>PG</th> <th title='Partidos Empatados'>PE</th> <th title='Partidos Perdidos'>PP</th>
$str = <<<STR
<table class='classificacion' id='clasificacion-small'>
<tr>
<th></th> <th></th> <th></th>
<th title='Puntos'>Ptos</th>
<th title='Partidos Jugados'>PJ</th>

<th title='Goles a favor'>GA</th> <th title='Goles en contra'>GC</th>
</tr>
STR;
echo $str . "\n";

                while($row = $result->fetch_assoc()) {
                    ++$i;
                    // puntos 	jugados 	ganados 	empatados 	perdidos 	goles_a_favor 	goles_en_contra 	ruta_logo 	nombre_equipo
                    $id = $row['id'];
                    $puntos = $row['puntos'];
                    $jugados = $row['jugados'];
                    /*$ganados =  $row['ganados'];
                    $empatados =  $row['empatados'];
                    $perdidos =  $row['perdidos'];*/
                    $goles_a_favor =  $row['goles_a_favor'];
                    $goles_en_contra =  $row['goles_en_contra'];
                    $ruta_logo =  $row['ruta_logo'];
                    $nombre_equipo =  $row['nombre_equipo'];
                    $image_filename = pathinfo($ruta_logo, PATHINFO_FILENAME);
                    $image_extension = pathinfo($ruta_logo, PATHINFO_EXTENSION);


$str = <<<STR
<tr>
    <td>$i</td> <td><img src='images/logos/$image_filename-15x15.$image_extension' alt='$nombre_equipo' class="tiny-logo" /></td>  <td> <span>$nombre_equipo</span> </td>  <td>$puntos</td> <td>$jugados</td>  <td>$goles_a_favor</td> <td>$goles_en_contra</td>
</tr>

STR;
                    //<td>$ganados</td> <td>$empatados</td> <td>$perdidos</td>
echo $str . "\n";
                }
echo "</table>";
                // free result set
                $result->free_result();
            }
            ?>
        </div>
    </div>

    <?php
    // close connection
    $conn->close();
    ?>

    <?php require_once '_footer.php'?>

</div> <!-- /container -->

</body>
</html>
