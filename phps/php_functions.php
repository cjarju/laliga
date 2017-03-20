<?php



/* functions and features included in the HTTP header (should be before any HTML code) */

function showNotifications() {
    if (!empty($_SESSION['flash'])) {
        foreach($_SESSION['flash'] as $message) {
            echo $message . "<br/>";
        }
    }
    unset($_SESSION['flash']);
}


function setDatepickerValue($element_id, $value) {

$jscript = <<<JS
<script type="text/javascript">
    $(document).ready(function() {
        var datepicker = $("$element_id");
        datepicker.datepicker();
        datepicker.datepicker('setDate', '$value');
    });
</script>
JS;

return $jscript;

}

/*
 * You can use the header() function to send a new HTTP header, but
 * this must be sent to the browser before any HTML or text
 * (so before the <!DOCTYPE ...> declaration, for example).
 */

function redirect($url, $statusCode = 303){
    header('Location: ' . $url, true, $statusCode);
    die();
}

function uploadImage($upload_dir, $file_input_id){

    $uploadOk = 1;
    $target_dir = $upload_dir;
    $uploaded_file = $_FILES["$file_input_id"];

    $path_parts = pathinfo($uploaded_file["name"]);
    $image_basename =  $path_parts['basename'];
    $image_filename =  $path_parts['filename'];
    $image_extension =  $path_parts['extension'];

    $target_file = $target_dir . $image_basename;

if (!empty($image_filename)) {

// Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
        $check = getimagesize($uploaded_file["tmp_name"]);
        if($check !== false) {
            //echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            //echo "File is not an image.";
            array_push($_SESSION['flash'], "El archivo no es una imagen.");
            $uploadOk = 0;
        }
    }
// Check if file already exists
    if (file_exists($target_file)) {
        //echo "Sorry, file already exists.";
        array_push($_SESSION['flash'], "El archivo ya existe.");
        $uploadOk = 0;
    }
// Check file size
    if ($_FILES["file_to_upload"]["size"] > 500000) {
        //echo "Sorry, your file is too large.";
        array_push($_SESSION['flash'], "El archivo es muy grande.");
        $uploadOk = 0;
    }
// Allow certain file formats
    if($image_extension != "jpg" && $image_extension != "png" && $image_extension != "jpeg" && $image_extension != "gif" ) {
        //echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        array_push($_SESSION['flash'], "Los archivos permitidos son JPG, JPEG, PNG y GIF.");
        echo $image_extension;
        $uploadOk = 0;
    }
// Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        //echo "Sorry, your file was not uploaded.";
        array_push($_SESSION['flash'], "El archivo no fue subido.");

// if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($uploaded_file["tmp_name"], $target_file)) {
            //echo "The file ". $image_basename . " has been uploaded.";
            $msg = "El archivo ". $image_basename . " ha sido subido.";
            array_push($_SESSION['flash'], $msg);
            return $image_basename;
        } else {
            //echo "Sorry, there was an error uploading your file.";
            array_push($_SESSION['flash'], "Hubo un error en subir el archivo.");
            return "";

        }
    }

    return "";
}

}

function resizeImage($originalFile, $newWidth, $newHeight, $targetFile) {

    $info = getimagesize($originalFile);
    $mime = $info['mime'];

    switch ($mime) {
        case 'image/jpeg':
            $image_create_func = 'imagecreatefromjpeg';
            $image_save_func = 'imagejpeg';
            $new_image_ext = 'jpg';
            break;

        case 'image/png':
            $image_create_func = 'imagecreatefrompng';
            $image_save_func = 'imagepng';
            $new_image_ext = 'png';
            break;

        case 'image/gif':
            $image_create_func = 'imagecreatefromgif';
            $image_save_func = 'imagegif';
            $new_image_ext = 'gif';
            break;

        default:
            throw Exception('Unknown image type.');
    }

    $img = $image_create_func($originalFile);
    list($width, $height) = getimagesize($originalFile);


    $tmp = imagecreatetruecolor($newWidth, $newHeight);

    /* you will get black background if you resize a transparent image. this will fix it */
    imagealphablending($tmp, false);
    imagesavealpha($tmp,true);
    $transparent = imagecolorallocatealpha($tmp, 255, 255, 255, 127);
    imagefilledrectangle($tmp, 0, 0, $newWidth, $newHeight, $transparent);
    /* this will fix it */

    imagecopyresampled($tmp, $img, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

    if (file_exists($targetFile)) {
        unlink($targetFile);
    }

    $image_save_func($tmp, "$targetFile.$new_image_ext");

    imagedestroy($tmp);

}


function paginate($table_name,$conn,$cond='') {

    // A variable declared outside a function has a global scope and can only be accessed outside a function.
    // i need to include the database config file to initialize my connection

    //include '../config/db/_database.php';

    // Find out how many items are in the table
    if (empty($cond)){
        $sql = "SELECT COUNT(*) FROM $table_name";
    } else {
        $sql = "SELECT COUNT(*) FROM $table_name where $cond";
    }

    $result = $conn->query($sql);
    $row = $result->fetch_row();
    $total = $row[0];

    // How many items to list per page
    $limit = 5;

    // How many pages will there be
    $pages = ceil($total / $limit);

    // What page are we currently on?
    $page = min($pages, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array(
        'options' => array(
            'default'   => 1,
            'min_range' => 1,
        ),
    )));

    // Calculate the offset for the query
    $offset = ($page - 1)  * $limit;

    // Some information to display to the user
    $start = $offset + 1;
    $end = min(($offset + $limit), $total);

    // The "back" link
    $prevlink = ($page > 1) ? '<a href="?page=1" title="First page">&laquo;</a> <a href="?page=' . ($page - 1) . '" title="Previous page">&lsaquo;</a>' : '<span class="disabled">&laquo;</span> <span class="disabled">&lsaquo;</span>';

    // The "forward" link
    $nextlink = ($page < $pages) ? '<a href="?page=' . ($page + 1) . '" title="Next page">&rsaquo;</a> <a href="?page=' . $pages . '" title="Last page">&raquo;</a>' : '<span class="disabled">&rsaquo;</span> <span class="disabled">&raquo;</span>';

    return array('total' => $total, 'limit' => $limit, 'offset' => $offset, 'pages' => $pages, 'page' => $page, 'start' => $start, 'end' => $end, 'prevlink' => $prevlink, 'nextlink' => $nextlink);

}

function curPageURL() {
    $pageURL = 'http';
    if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") {
        $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
    } else {
        $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
    }
    return $pageURL;
}

/* generate a random token for a given form
   create a cookie on client with a definite expiry time and store token
   store the token on the server in a session variable
   send the form to the client
*/

function generateFormToken($form_name, $expiry) {

    $formName = $form_name; // name of the form
    $random       = mt_rand (); // create a function to get the ip of the user
    $salt     = "8077_(-(àyhvboyr(à"; // secret salt
    $token    = md5(sha1($salt.$random).sha1($salt.$formName));

    // set cookie: time()+3600 = now + 1 hour
    // set cookie: time()+300 = now + 5 min

    setcookie("token",$token, time()+$expiry);

    //save token on server side
    $_SESSION['token'] = $token;
}

function resetFormToken() {
    setcookie("token",'', time()-5); // destruct cookie
    $_SESSION['token'] = "";  // OR destruct session

    array_push($_SESSION['flash'], "<span class='error-color'>Form has expired.</span>");
}

/* server side validation functions */

/* presence */
function isEmpty($el_variable) {
    if (empty($el_variable)) {
        return true;
    } else {
        return false;
    }
}

/* numeric */
function isNumeric($el_variable) {
    if (preg_match("/^[\-\+]?[\d\,]*\.?[\d]*$/",$el_variable)) {
        return true;
    } else {
        return false;
    }
}

/* alphas, numeric, special characters _&|*!*/
function isSafeAlphaNum1 ($el_variable) {
    if (!preg_match("/^[a-zA-Z0-9_&|*!]*$/",$el_variable)) {
        return true;
    } else {
        return false;
    }
}

/* alphas, numeric, space, special characters _&|*!*/
function isSafeAlphaNum2 ($el_variable) {
    if (!preg_match("/^[a-zA-Z0-9 _&|*!]*$/",$el_variable)) {
        return true;
    } else {
        return false;
    }
}

function replaceNewLineWithBR($str) {

}

/* start session and set flash variable is if not set; */
// set session setting before starting it */

//session settings like expiry time should be defined before starting it

session_start();

if (!isset($_SESSION['flash'])) {
    $_SESSION['flash'] = array();
}

?>