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
    <title>Edit | Noticias</title>
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

            $sql = "SELECT * FROM noticias WHERE id = '$id'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                $titulo = trim($row['titulo']);
                $contenido = trim($row['contenido']);
                $fecha = trim($row['fecha_noticia']);

                echo setDatepickerValue("#fecha_noticia", $fecha);


$form = <<<STR
<form method="post" name="edit-noticia" id="edit-noticia" class="rec-form" action="do_edit.php" enctype="multipart/form-data" onsubmit="return validateForm(this.id)">
<fieldset>
  <legend>Edit Noticia</legend>

   <p>
        <input type="hidden" name="rec_id" id="rec_id" value="$id" />
    </p>
    <p>
        <label id="titulo-label" for="titulo" class="form-label-1"> Titulo: </label>
        <textarea rows="3" cols="50" name="titulo" id="titulo" class="obligatorio"> $titulo </textarea>
    </p>
    <p>
        <label id="contenido-label" for="contenido" class="form-label-1"> Contenido: </label>
        <textarea rows="5" cols="50" name="contenido" id="contenido" class="obligatorio"> $contenido </textarea>
    </p>
    <p>
        <label id="fecha_noticia-label" for="fecha_noticia" class="form-label-1"> Fecha de noticia: </label>
        <input type="text" name="fecha_noticia" id="fecha_noticia" class="datefield obligatorio" value="$fecha" />
    </p>

    <p>
        <label id="file_to_upload-label" for="file_to_upload" class="form-label-1"> Foto de la noticia : </label>
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
                redirect("../noticias.php");
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





