<?php

require_once '../../phps/php_functions.php';

require_once '../_restrict_subdir.php';

if( isset($_COOKIE['token']) && isset($_SESSION['token']) && $_COOKIE['token'] == $_SESSION['token']  ){
    //request ok (form has valid token)
    require_once '../../config/db/_database.php';

// run SQL direct query

// no result set returned (insert, create, update, delete)

    var_dump($_POST);
    $id = trim($_POST['rec_id']);
    $equipo_local_id = trim($_POST['equipo_local']);
    $equipo_away_id = trim($_POST['equipo_away']);
    $goles_equipo_local = trim($_POST['goles_equipo_local']);
    $goles_equipo_away = trim($_POST['goles_equipo_away']);
    $fecha_partido = trim($_POST['fecha_partido']);


    if (($goles_equipo_local == '') || ($goles_equipo_away == '')) {
        $goles_equipo_local = null;
        $goles_equipo_away = null;
    }

// create a prepared statement

    $sql = "UPDATE partidos SET equipo_local_id = ?, equipo_away_id = ?, goles_equipo_local = ?, goles_equipo_away = ?, fecha_partido = ? WHERE id = ?";


    $stmt = $conn->prepare($sql);


    if ($stmt) {


        // bind parameters for markers
        $stmt->bind_param("iiiisi", $el_local_id, $el_away_id, $goles_eq_local, $goles_eq_away, $la_fecha, $el_id);
        // set parameters and execute

        // insert a row
        $el_local_id = $equipo_local_id;
        $el_away_id = $equipo_away_id;
        $goles_eq_local = $goles_equipo_local;
        $goles_eq_away = $goles_equipo_away;
        $la_fecha = $fecha_partido;
        $el_id = $id;
        $stmt->execute();

        if(!$stmt->error) {
            array_push($_SESSION['flash'], "Partido editado.");

        } else {
            array_push($_SESSION['flash'], "Partido no editado.");
        }

        // close statement
        $stmt->close();

        include '_update_clasificacion.php';

        // close connection
        $conn->close();

        redirect("../partidos.php");

    }
    else {

        array_push($_SESSION['flash'], "Partido no editado.");

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

