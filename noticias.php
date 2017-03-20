<?php require_once 'phps/php_functions.php'; ?>

<?php
require_once 'config/db/_database.php';

$sql = "select id from noticias order by fecha_noticia desc limit 1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $id = $row['id'];
    $result->free_result();
} else {
    $id='';
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//ES" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Noticias</title>

    <meta name="keywords" content="Noticias, LFP" />
    <meta name="description" content="Las últimas noticias de la LFP" />

    <?php require_once '_head_elements.php' ?>

    <script type="text/javascript">
        $(document).ready(function(){
            var id = getUrlParameter('id');

            if(id){
                getNoticiaInfo("id"+id);
            } else {
                defaultid = 'id' + <?php echo $id ?> ;
                getNoticiaInfo(defaultid);
            }
        });
    </script>


</head>

<body>

<div class="container">

    <?php
    require_once '_header.php';
    require_once '_signed_in_user.php';
    require_once '_info_section.php';
    ?>

    <div class="all-new-container">


    <div id="current-news" class="content-bgcolor">
        <div id="current-news-img-box">
            <img src="images/logos/warning_grey.png" alt="" id="current-news-img" />
        </div>
        <div id="current-news-text">
            <span id="news-date" class="news-date"></span>
            <span id="news-title" class="news-title block"></span>
            <span id="news-content" class="news-content"></span>
        </div>
    </div>


    <div id="all-news" class="content-bgcolor">
        <?php

        $sql = "select * from noticias order by fecha_noticia desc";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {

            echo '<div>';

            while($row = $result->fetch_assoc()) {
                $id = $row['id'];
                $path_parts = pathinfo($row['ruta_foto']);
                $ext = $path_parts['extension'];
                $fname = $path_parts['filename'];
                $short_desc = implode(' ', array_slice(explode(' ', $row['contenido']), 0, 25));
                $titulo = $row['titulo'];
                $fecha = $row['fecha_noticia'];

$str = <<<STR
<div class='noticias-box' id='el-news-$id'>

<a href='javascript:onclick=getNoticiaInfo("id$id")' title='$titulo' id='id$id'style='display:block'>
<img src='images/noticias/$fname-140x79.$ext' class='noticia-side-foto'/>
<span class='news-date'>$fecha</span> <br/>
<span class='el-titulo-noticia'> $titulo</span> <br/>
<span class='short-description'> $short_desc...</span>
</a>
</div>
STR;
echo $str . "\n";

            }
echo "</div>\n";

            // free result set
            $result->free_result();

        } else {
            echo "<script type='text/javascript'> $('#all-news').html('No hay noticias')</script>";
        }
        $conn->close();
        ?>

    </div>
</div>
    <?php require_once '_footer.php'?>

</div> <!-- /container -->

</body>
</html>
