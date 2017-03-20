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
    <title>New | Equipos</title>
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
            <form method="post" name="new-equipo" id="new-equipo" class="rec-form" action="create.php" enctype="multipart/form-data" onsubmit="return validateForm(this.id)">
                <fieldset>
                    <legend>Nuevo Equipo</legend>
                    <p>
                        <label id="nombre-label" for="nombre" class="form-label-1"> Nombre: </label>
                        <input type="text" name="nombre" id="nombre" class="txt-field-1 obligatorio" />
                    </p>
                    <p>
                        <label id="web-label" for="web" class="form-label-1"> Web: </label>
                        <input type="text" name="web" id="web" class="txt-field-1 obligatorio" />
                    </p>
                    <p>
                        <label id="twitter-label" for="twitter" class="form-label-1"> Twitter: </label>
                        <input type="text" name="twitter" id="twitter" class="txt-field-1" />
                    </p>
                    <p>
                        <label id="facebook-label" for="facebook" class="form-label-1"> Facebook: </label>
                        <input type="text" name="facebook" id="facebook" class="txt-field-1" />
                    </p>
                    <p>
                        <label id="email-label" for="email" class="form-label-1"> Email: </label>
                        <input type="text" name="email" id="email" class="txt-field-1 email" />
                    </p>
                    <p>
                        <label id="telefono-label" for="telefono" class="form-label-1"> Telefono: </label>
                        <input type="text" name="telefono" id="telefono" class="txt-field-1 obligatorio" />
                    </p>
                    <p>
                        <label id="file_to_upload-label" for="file_to_upload" class="form-label-1"> Logo : </label>
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





