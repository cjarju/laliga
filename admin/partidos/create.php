<?php

require_once '../../phps/php_functions.php';

require_once '../_restrict_subdir.php';

if( isset($_COOKIE['token']) && isset($_SESSION['token']) && $_COOKIE['token'] == $_SESSION['token']  ){
    //request ok (form has valid token)
    require_once '../../config/db/_database.php';

    $equipo_local_id = trim($_POST['equipo_local']);
    $equipo_away_id = trim($_POST['equipo_away']);
    $goles_equipo_local = trim($_POST['goles_equipo_local']);
    $goles_equipo_away = trim($_POST['goles_equipo_away']);
    $fecha_partido = trim($_POST['fecha_partido']);

    if (empty($goles_equipo_local) || empty($goles_equipo_away)) {
        $goles_equipo_local = null;
        $goles_equipo_away = null;
    }

    /* you might want to check for duplicates: do a select of with the values of the record to be inserted; if no of rows returned is > 0 then
    record already exists, don't insert
    */
    $sql = "INSERT INTO partidos (equipo_local_id, equipo_away_id, goles_equipo_local, goles_equipo_away, fecha_partido) VALUES (?, ?, ?, ?, ?)";

// create a prepared statement
    $stmt = $conn->prepare($sql);

    if ($stmt) {

        // bind parameters for markers
        $stmt->bind_param("iiiis", $el_local_id, $el_away_id, $goles_eq_local, $goles_eq_away, $la_fecha);

        // set parameters and execute

        // insert a row
        $el_local_id = $equipo_local_id;
        $el_away_id = $equipo_away_id;
        $goles_eq_local = $goles_equipo_local;
        $goles_eq_away = $goles_equipo_away;
        $la_fecha = $fecha_partido;
        $stmt->execute();

        if (!$stmt->error) {
            array_push($_SESSION['flash'], "Partido creado.");

            include '_update_clasificacion.php';

        } else {
            array_push($_SESSION['flash'], "Partido no creado.");
        }

        // echo "New records created successfully";

        // close statement
        $stmt->close();

        // close connection
        $conn->close();

        redirect("../partidos.php"); // Redirect browser

    }
    else {

        array_push($_SESSION['flash'], "Partido no creado.");

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




