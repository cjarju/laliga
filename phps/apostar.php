<?php

    require_once 'php_functions.php';

    require_once '../config/db/_database.php';

    $partido_id = $_POST['partido_id'];
    $usuario_id = $_POST['usuario_id'];
    $goles_1 = $_POST['goles_equipo_1'];
    $goles_2 = $_POST['goles_equipo_2'];
    $home_team = $_POST['home_team'];
    $away_team = $_POST['away_team'];


    //fallback validation on server side (bulletproof): complement the client side validation
    if (isEmpty($goles_1) || isEmpty($goles_2) || !isNumeric($goles_1) || !isNumeric($goles_2)) {
        array_push($_SESSION['flash'], "<span class='error-color'>Apuesta sin éxito.</span>");
        redirect('../apuestas.php');
    }

   /* check if user id and game id exist in database:
   insert if no record exist and show record in notification area (construct string)
   otherwise return to apuestas */

    //id, partido_id, usuario_id, goles_equipo_1, goles_equipo_2
    $sql = "select * from apuestas where usuario_id = ? and partido_id = ?";

    $stmt = $conn->prepare($sql);

    if ($stmt) {

        // bind parameters for markers
        $stmt->bind_param("ii", $el_user_id, $el_game_id);

        // set parameters and execute
        $el_user_id = $usuario_id;
        $el_game_id = $partido_id;
        $stmt->execute();
        $stmt->store_result();

        //$stmt->bind_result($id, $nombre);

        if ($stmt->num_rows > 0) {

            //apuesta exists already
            array_push($_SESSION['flash'], "<span class='error-color'>Apuesta sin éxito. Ha apostado por este partido ya.</span>");

            //free result
            $stmt->free_result();

            // close statement
            $stmt->close();

            // close connection
            $conn->close();

            redirect("../apuestas.php");

        } else {
            // insert record

            $sql_insert = "INSERT INTO apuestas (partido_id, usuario_id, goles_equipo_1, goles_equipo_2) VALUES (?, ?, ?, ?)";

            // create a prepared statement
            $stmt_insert = $conn->prepare($sql_insert);

            if ($stmt_insert) {

                // bind parameters for markers
                $stmt_insert->bind_param("iiii", $el_game_id, $el_user_id, $goles_eq_1, $goles_eq_2);

                // set parameters and execute

                // insert a row
                $el_user_id = $usuario_id;
                $el_game_id = $partido_id;
                $goles_eq_1 = $goles_1;
                $goles_eq_2 = $goles_2;
                $stmt_insert->execute();

                if (!$stmt_insert->error) {
                    /* sign in */
                    array_push($_SESSION['flash'], "Apuesta con éxito. $home_team $goles_1 - $goles_2 $away_team");

                    // close statement
                    $stmt_insert->close();

                    // close statement
                    $stmt->close();

                    // close connection
                    $conn->close();

                    redirect('../apuestas.php');

                } else {
                    //stmt_insert execute error
                    array_push($_SESSION['flash'], "<span class='error-color'>Apuesta sin éxito.</span>");

                    // close statement
                    $stmt_insert->close();

                    // close statement
                    $stmt->close();

                    // close connection
                    $conn->close();

                    redirect('../apuestas.php');
                }


            }
            else {
                // insert statement invalid

                array_push($_SESSION['flash'], "<span class='error-color'>Apuesta sin éxito.</span>");

                // close statement
                $stmt->close();

                // close connection
                $conn->close();

                redirect('../apuestas.php');

            }
        }

    }
    else {

        // statement is not valid; false returned

        array_push($_SESSION['flash'], "<span class='error-color'>Apuesta sin éxito.</span>");

        // close connection
        $conn->close();

        redirect("../apuestas.php");
    }

?>
