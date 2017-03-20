<?php


require_once '../config/db/_database.php';

$id = trim($_POST['id']);

// create a prepared statement

$sql = "select equipos.*, nombre_estadio, direccion from equipos inner join estadios on equipos.id = estadios.equipo_id where equipos.id = ?";

$stmt = $conn->prepare($sql);

if ($stmt) {

    // bind parameters for markers
    $stmt->bind_param("i", $el_id);
    // set parameters and execute

    $el_id = $id;
    $stmt->execute();


    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
         $arr = $result->fetch_assoc();

        //encode an array into a JSON string;
        $json_string = json_encode($arr);

        //send the result
        echo trim($json_string);

        //free result
        $result->free_result();
    } else {
        echo "no records";
    }

    // close statement
    $stmt->close();

}
else {

    // statement is not valid; false returned
    echo "statement invalid";
}

// close connection
$conn->close();

?>
