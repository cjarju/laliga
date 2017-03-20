<?php

    require_once 'php_functions.php';

/*echo $_COOKIE['token'] . '<br/>';
echo $_SESSION['token'] . '<br/>';
echo $_COOKIE['token'] == $_SESSION['token'];
*/


if( isset($_COOKIE['token']) && isset($_SESSION['token']) && $_COOKIE['token'] == $_SESSION['token']  ){
    // request from server - ok

    require_once '../config/db/_database.php';

    $username = strtolower($_POST['username']);
    $password = $_POST['password'];
    $password_hash = md5($password);

    //fallback validation on server side (bulletproof): complement the client side validation
    if (isEmpty($username) || isEmpty($password) || isSafeAlphaNum1($username) || isSafeAlphaNum2($password)) {
        array_push($_SESSION['flash'], "<span class='error-color'>Inicio de sesión sin éxito.</span>");
        redirect('../signin.php');
    }

    $sql = "select * from usuarios where nombre_usuario = ?";

    /* prepared statement:
      - string is escaped (quoted) implicitly; real_escape_string() not required
      - prevents 1st order injection (injection from external source; e.g. user input)
    */
    $stmt = $conn->prepare($sql);

    if ($stmt) {

// bind parameters for markers
        $stmt->bind_param("s", $el_nombre);

// set parameters and execute
        $el_nombre = $username;
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($id, $nombre, $hash, $admin);


        if ($stmt->num_rows > 0) {
            //username exists already: check if password is correct

            $stmt->fetch();

            if ($username == $nombre && $password_hash == $hash) {

                //signin successful

                $_SESSION['user_id'] = $id;
                $_SESSION['username'] = $nombre;
                $_SESSION['signed_in'] = true;
                $_SESSION['is_admin'] = $admin;

                array_push($_SESSION['flash'], "Inicio de sesión con éxito.");

                //free result
                $stmt->free_result();

                // close statement
                $stmt->close();

                // close connection
                $conn->close();

                if (isset($_SESSION['request_url'])) {
                    $request_url = $_SESSION['request_url'];
                    redirect($request_url);
                } else {
                    redirect('../index.php');
                }


            }  else {

                //signin unsuccessful: password incorrect

                array_push($_SESSION['flash'], "<span class='error-color'>Inicio de sesión sin éxito. ID del usuario y/o contraseña no valido.</span>");

                //free result
                $stmt->free_result();

                // close statement
                $stmt->close();

                // close connection
                $conn->close();

                redirect('../signin.php');
            }


        } else {
            //username does not exists

            array_push($_SESSION['flash'], "<span class='error-color'>Inicio de sesión sin éxito. ID del usuario y/o contraseña no valido.</span>");

            // close statement
            $stmt->close();

            // close connection
            $conn->close();

            redirect('../signin.php');

        }

    } else {
        //select statement not valid

        array_push($_SESSION['flash'], "<span class='error-color'>Inicio de sesión sin éxito. ID del usuario y/o contraseña no valido.</span>");

        // close connection
        $conn->close();

        redirect('../signin.php');

    }
}else{
    // bad request

    resetFormToken();

    // redirect to form

    redirect('../signin.php');
}


?>
