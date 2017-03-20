<?php


require_once '../config/db/_database.php';

$id = trim($_POST['id']);

// create a prepared statement

$sql = "select * from noticias where id = ?";

//$sql = "SELECT * FROM equipos WHERE id = ?";

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
         $arr['contenido'] = nl2br($arr['contenido'],true);
        //encode an array into a JSON string;
        $json_string = json_encode($arr);

        //send the result
        echo trim($json_string);

        //free result
        $result->free_result();
    } else {
        echo "no record";
    }

    // close statement
    $stmt->close();

}
else {

    echo "invalid statement";
}

// close connection
$conn->close();


?>
