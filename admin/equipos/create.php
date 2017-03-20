<?php

require_once '../../phps/php_functions.php';

require_once '../_restrict_subdir.php';

if( isset($_COOKIE['token']) && isset($_SESSION['token']) && $_COOKIE['token'] == $_SESSION['token']  ){
    //request ok (form has valid token)
    require_once '../../config/db/_database.php';

    $upload_dir = '../../images/logos/';
    $file_input_name = "file_to_upload";

    $image_name = uploadImage($upload_dir, $file_input_name);

    if (!empty($image_name)) {
        $src_file = $upload_dir . $image_name;
        $image_filename = pathinfo($image_name, PATHINFO_FILENAME);

        $new_width  = 50;
        $new_height = 50;
        $dst_file = $upload_dir . $image_filename . "-" . $new_width . "x" . $new_height;

        resizeImage($src_file, $new_width, $new_height, $dst_file);

        $new_width  = 25;
        $new_height = 25;
        $dst_file = $upload_dir . $image_filename . "-" . $new_width . "x" . $new_height;

        resizeImage($src_file, $new_width, $new_height, $dst_file);

        $new_width  = 15;
        $new_height = 15;
        $dst_file = $upload_dir . $image_filename . "-" . $new_width . "x" . $new_height;

        resizeImage($src_file, $new_width, $new_height, $dst_file);
    }


    $nombre = trim($_POST['nombre']);
    $web = trim($_POST['web']);
    $twitter = trim($_POST['twitter']);
    $facebook = trim($_POST['facebook']);
    $email = trim($_POST['email']);
    $telefono = trim($_POST['telefono']);
    $ruta_logo = $image_name;

    $sql = "INSERT INTO equipos (nombre_equipo,web,twitter,facebook,email,telefono,ruta_logo) VALUES (?, ?, ?, ?, ?, ?, ?)";

// create a prepared statement
    $stmt = $conn->prepare($sql);

    if ($stmt) {

        // bind parameters for markers
        $stmt->bind_param("sssssss", $el_nombre, $el_web, $el_twitter, $el_facebook, $el_email, $el_telefono, $la_ruta);

        // set parameters and execute

        // insert a row
        $el_nombre = $nombre;
        $el_web = $web;
        $el_twitter = $twitter;
        $el_facebook = $facebook;
        $el_email = $email;
        $el_telefono = $telefono;
        $la_ruta = $ruta_logo;
        $stmt->execute();

        if (!$stmt->error) {
            array_push($_SESSION['flash'], "Equipo creado.");

        } else {
            array_push($_SESSION['flash'], "Equipo no creado.");
        }



        // echo "New records created successfully";

        // close statement
        $stmt->close();

        // close connection
        $conn->close();

        redirect("../equipos.php"); // Redirect browser

    }
    else {

        array_push($_SESSION['flash'], "Equipo no creado.");

        // close statement
        $stmt->close();

        // close connection
        $conn->close();
        echo "error else";

        redirect("new.php");

    }
} else{
    // bad request

    resetFormToken();

    // redirect to form

    redirect('../signin.php');
}



?>
