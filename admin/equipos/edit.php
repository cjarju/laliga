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
    <title>Edit | Equipos</title>
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

            $sql = "SELECT * FROM equipos WHERE id = '$id'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                $nombre = $row['nombre_equipo'];
                $web = $row['web'];
                $twitter = $row['twitter'];
                $facebook = $row['facebook'];
                $email = $row['email'];
                $telefono = $row['telefono'];





$form = <<<STR
<form method="post" name="edit-equipo" id="edit-equipo" class="rec-form" action="do_edit.php" enctype="multipart/form-data" onsubmit="return validateForm(this.id)">
<fieldset>

        <legend>Editar Equipo</legend>
        <p>
            <input type="hidden" name="rec_id" id="rec_id" value="$id" />
        </p>
        <p>
            <label id="nombre-label" for="nombre" class="form-label-1"> Nombre: </label>
            <input type="text" name="nombre" id="nombre" class="txt-field-1 obligatorio" value="$nombre" />
        </p>
        <p>
            <label id="web-label" for="web" class="form-label-1"> Web: </label>
            <input type="text" name="web" id="web" class="txt-field-1 obligatorio" value="$web" />
        </p>
        <p>
            <label id="twitter-label" for="twitter" class="form-label-1"> Twitter: </label>
            <input type="text" name="twitter" id="twitter" class="txt-field-1" value="$twitter" />
        </p>
        <p>
            <label id="facebook-label" for="facebook" class="form-label-1"> Facebook: </label>
            <input type="text" name="facebook" id="facebook" class="txt-field-1" value="$facebook" />
        </p>
        <p>
            <label id="email-label" for="email" class="form-label-1"> Email: </label>
            <input type="text" name="email" id="email" class="txt-field-1 email" value="$email" />
        </p>
        <p>
            <label id="telefono-label" for="telefono" class="form-label-1"> Telefono: </label>
            <input type="text" name="telefono" id="telefono" class="txt-field-1 obligatorio" value="$telefono" />
        </p>
        <p>
            <label id="file_to_upload-label" for="file_to_upload" class="form-label-1"> Logo : </label>
            <input type="file" name="file_to_upload" id="file_to_upload" />
        </p>
        <p>
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
                redirect("../equipos.php");
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





