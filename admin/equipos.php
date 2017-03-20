<?php
    require_once '../phps/php_functions.php';
    require_once '_restrict.php';
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//ES" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Equipos</title>
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

            $arr = paginate('equipos',$conn);

            $sql = "SELECT id, nombre_equipo FROM equipos LIMIT ? OFFSET ?";

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
                $stmt->bind_result($id, $nombre_equipo);

            if ($stmt->num_rows > 0) {

                // output data of each row
                $str = <<<STR
<table class='records' >
    <tr> <th>Nombre</th> <th>Editar</th> <th>Borrar</th> </tr>
STR;
                echo $str;



                while($row = $stmt->fetch()) {
                    //$id = $row['id'];
                    //$name = $row['nombre_equipo'];

                    $str = <<<STR
<tr>
    <td> $nombre_equipo </td>
    <td> <a href="equipos/edit.php?id=$id"><span class='ui-icon ui-icon-pencil'>&nbsp;</span></a></td>
    <td> <a href="equipos/delete.php?id=$id" class='delete-confirmation'><span class='ui-icon ui-icon-trash'>&nbsp;</span></a></td>
</tr>
STR;
                    echo $str;

                }

                echo '</table>';

                require_once '../phps/_show_paging_info.php';

            } else {
                echo "<script type='text/javascript'>  $('#info-sect-1').html('No hay equipos')</script>";
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
            <a href='equipos/new.php'>
                <span class='ui-icon ui-icon-plus' style='display: inline-block;'>&nbsp;</span>
                <span>Equipo Nuevo</span>
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
