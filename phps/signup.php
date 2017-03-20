<?php

    require_once 'php_functions.php';

if( isset($_COOKIE['token']) && isset($_SESSION['token']) && $_COOKIE['token'] == $_SESSION['token']  ){
    //request ok
    require_once '../config/db/_database.php';

    $username = strtolower($_POST['username']);
    $password = $_POST['password'];
    $password_hash = md5($password);

    //fallback validation on server side (bulletproof): complement the client side validation
    if (isEmpty($username) || isEmpty($password) || isSafeAlphaNum1($username) || isSafeAlphaNum2($password)) {
        array_push($_SESSION['flash'], "<span class='error-color'>Registro sin éxito.</span>");
        redirect('../signup.php');
    }

    $sql = "select * from usuarios where nombre_usuario = ?";

    /* prepared statement:
      - string is escaped (quoted) implicitly; real_escape_string() not required
      - prevents 1st order injection (injection from external source; e.g. user input)
    */
    $stmt = $conn->prepare($sql);

    //var_dump($stmt);

    if ($stmt) {

        // bind parameters for markers
        $stmt->bind_param("s", $el_nombre);

        // set parameters and execute
        $el_nombre = $username;
        $stmt->execute();
        $stmt->store_result();
        //$stmt->bind_result($id, $nombre);

        if ($stmt->num_rows > 0) {
            //username exists already - choose another
            array_push($_SESSION['flash'], "<span class='error-color'>ID de usuario ya existe. Escoje otro.</span>");

            //free result
            $stmt->free_result();

            // close statement
            $stmt->close();

            // close connection
            $conn->close();

            redirect("../signup.php");

        } else {
            // insert record

            $sql_insert = "INSERT INTO usuarios (nombre_usuario,password_hash) VALUES (?, ?)";
            $sql_insert = $conn->real_escape_string($sql_insert);

            // create a prepared statement
            $stmt_insert = $conn->prepare($sql_insert);

            if ($stmt_insert) {

                // bind parameters for markers
                $stmt_insert->bind_param("ss", $el_nombre, $el_hash);

                // set parameters and execute

                // insert a row
                $el_nombre = $username;
                $el_hash = $password_hash;
                $stmt_insert->execute();

                if (!$stmt_insert->error) {
                    // sign in
                    array_push($_SESSION['flash'], "Registro con éxito. Bienvenido $username.");

                    $_SESSION['username'] = $username;
                    $_SESSION['signed_in'] = true;
                    $_SESSION['is_admin'] = 0;

                    $result = $conn->query("select id from usuarios where nombre_usuario = $username");
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $_SESSION['user_id'] = $row['id'];
                    }

                    // close statement
                    $stmt_insert->close();

                    // close statement
                    $stmt->close();

                    // close connection
                    $conn->close();

                    redirect('../index.php');

                } else {
                    array_push($_SESSION['flash'], "<span class='error-color'>Registro sin éxito.</span>");

                    // close statement
                    $stmt_insert->close();

                    // close statement
                    $stmt->close();

                    // close connection
                    $conn->close();

                    redirect('../signup.php');
                }


            }
            else {
                // insert statement invalid

                array_push($_SESSION['flash'], "<span class='error-color'>Registro sin éxito.</span>");

                // close statement
                $stmt->close();

                // close connection
                $conn->close();

                redirect('../signup.php');

            }
        }

    }
    else {

        // statement is not valid; false returned

        array_push($_SESSION['flash'], "<span class='error-color'>Registro sin éxito.</span>");

        // close connection
        $conn->close();

        redirect("../signup.php");
    }

} else{
    // bad request

    resetFormToken();

    // redirect to form

    redirect('../signin.php');
}

?>
