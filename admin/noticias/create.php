<?php

require_once '../../phps/php_functions.php';

require_once '../_restrict_subdir.php';

if( isset($_COOKIE['token']) && isset($_SESSION['token']) && $_COOKIE['token'] == $_SESSION['token']  ){
    //request ok (form has valid token)
    require_once '../../config/db/_database.php';

    $upload_dir = '../../images/noticias/';
    $file_input_name = "file_to_upload";

    $image_name = uploadImage($upload_dir, $file_input_name);

    if (!empty($image_name)) {
        $src_file = $upload_dir . $image_name;
        $image_filename = pathinfo($image_name, PATHINFO_FILENAME);

        $new_width  = 140;
        $new_height = 79;
        $dst_file = $upload_dir . $image_filename . "-" . $new_width . "x" . $new_height;

        resizeImage($src_file, $new_width, $new_height, $dst_file);
    }


    $titulo = trim($_POST['titulo']);
    $contenido = trim($_POST['contenido']);
    $fecha = trim($_POST['fecha_noticia']);
    $ruta_foto = $image_name;

    $sql = "INSERT INTO noticias (titulo,contenido,fecha_noticia,ruta_foto) VALUES (?, ?, ?, ?)";

// create a prepared statement
    $stmt = $conn->prepare($sql);

    if ($stmt) {

        // bind parameters for markers
        $stmt->bind_param("ssss", $el_titulo, $el_contenido, $la_fecha, $la_ruta);

        // set parameters and execute

        // insert a row
        $el_titulo = $titulo;
        $el_contenido = $contenido;
        $la_fecha = $fecha;
        $la_ruta = $ruta_foto;
        $stmt->execute();

        if (!$stmt->error) {
            array_push($_SESSION['flash'], "Noticia creada.");
        } else {
            array_push($_SESSION['flash'], "Noticia no creada.");
        }



        // echo "New records created successfully";

        // close statement
        $stmt->close();

        // close connection
        $conn->close();

        redirect("../noticias.php"); // Redirect browser

    }
    else {

        array_push($_SESSION['flash'], "Noticia no creada.");

        // close statement
        $stmt->close();

        // close connection
        $conn->close();

        redirect("new.php");

    }
} else{
    // bad request

    resetFormToken();

    // redirect to form

    redirect('../signin.php');
}

?>




