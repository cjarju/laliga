<?php

require_once '../../phps/php_functions.php';

require_once '../_restrict_subdir.php';

require_once '../../config/db/_database.php';

$id = $_GET['id'];

$sql = "DELETE FROM partidos  WHERE id = ?";

$stmt = $conn->prepare($sql);

if ($stmt) {


    // bind parameters for markers
    $stmt->bind_param("i", $el_id);
    // set parameters and execute

    // delete
    $el_id = $id;
    $stmt->execute();

    array_push($_SESSION['flash'], "Partido borrada.");


}
else {
    array_push($_SESSION['flash'], "Partido no borrada.");
    $stmt->error;
}

// close statement
$stmt->close();

// close connection
$conn->close();

redirect("../partidos.php");

?>

