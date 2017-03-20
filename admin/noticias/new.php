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
    <title>New | Noticias</title>
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
            <form method="post" name="new-noticia" id="new-noticia" class="rec-form" action="create.php" enctype="multipart/form-data" onsubmit="return validateForm(this.id)">
                <fieldset>
                    <legend>Nueva Noticia</legend>

                    <p>
                        <label id="titulo-label" for="titulo" class="form-label-1"> Titulo: </label>
                        <textarea rows="3" cols="50" name="titulo" id="titulo" class="obligatorio"> </textarea>
                    </p>
                    <p>
                        <label id="contenido-label" for="contenido" class="form-label-1"> Contenido: </label>
                        <textarea rows="5" cols="50" name="contenido" id="contenido" class="obligatorio"> </textarea>
                    </p>
                    <p>
                        <label id="fecha_noticia-label" for="fecha_noticia" class="form-label-1"> Fecha de noticia: </label>
                        <input type="text" name="fecha_noticia" id="fecha_noticia" class="datefield obligatorio" />
                    </p>

                    <p>
                        <label id="file_to_upload-label" for="file_to_upload" class="form-label-1"> Foto de la noticia : </label>
                        <input type="file" name="file_to_upload" id="file_to_upload" class="obligatorio" />
                    </p>
                    <p>
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





