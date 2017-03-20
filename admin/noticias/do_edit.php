<?php

require_once '../../phps/php_functions.php';

require_once '../_restrict_subdir.php';

if( isset($_COOKIE['token']) && isset($_SESSION['token']) && $_COOKIE['token'] == $_SESSION['token']  ){
    //request ok (form has valid token)
    require_once '../../config/db/_database.php';

// run SQL direct query

// no result set returned (insert, create, update, delete)

    $upload_dir = '../../images/noticias/';
    $file_input_id = "file_to_upload";
    $image_name = "";

    $isempty = empty($_FILES["$file_input_id"]["name"]);

    if (!$isempty) {
        $image_name = uploadImage('../../images/noticias/', $file_input_id);
    }

    if (!empty($image_name)) {
        $src_file = $upload_dir . $image_name;
        $image_filename = pathinfo($image_name, PATHINFO_FILENAME);

        $new_width  = 140;
        $new_height = 79;
        $dst_file = $upload_dir . $image_filename . "-" . $new_width . "x" . $new_height;

        resizeImage($src_file, $new_width, $new_height, $dst_file);
    }

    $id = trim($_POST['rec_id']);
    $titulo = trim($_POST['titulo']);
    $contenido = trim($_POST['contenido']);
    $fecha = trim($_POST['fecha_noticia']);
    $ruta_foto = $image_name;

// create a prepared statement

    if (!empty($image_name)) {
        $sql = "UPDATE noticias SET titulo = ?, contenido = ?, fecha_noticia = ?, ruta_foto = ? WHERE id = ?";
    } else {
        $sql = "UPDATE noticias SET titulo = ?, contenido = ?, fecha_noticia = ? WHERE id = ?";
    }

    $stmt = $conn->prepare($sql);


    if ($stmt) {

        if (!empty($ruta_foto)) {
            // bind parameters for markers
            $stmt->bind_param("ssssi", $el_titulo, $el_contenido, $la_fecha, $la_ruta, $el_id);
            // set parameters and execute

            // insert a row
            $el_titulo = $titulo;
            $el_contenido = $contenido;
            $la_fecha = $fecha;
            $la_ruta = $ruta_foto;
            $el_id = $id;
            $stmt->execute();



        } else {
            // bind parameters for markers
            $stmt->bind_param("sssi", $el_titulo, $el_contenido, $la_fecha, $el_id);
            // set parameters and execute

            // insert a row
            $el_titulo = $titulo;
            $el_contenido = $contenido;
            $la_fecha = $fecha;
            $el_id = $id;
            $stmt->execute();



        }

        array_push($_SESSION['flash'], "Noticia editada.");

        // close statement
        $stmt->close();

        // close connection
        $conn->close();

        redirect("../noticias.php");

    }
    else {

        array_push($_SESSION['flash'], "Noticia no editada.");

        $stmt->error;

        // close statement
        $stmt->close();

        // close connection
        $conn->close();

        redirect("edit.php?id=$id");
    }
} else{
    // bad request

    resetFormToken();

    // redirect to form

    redirect('../signin.php');
}



?>

