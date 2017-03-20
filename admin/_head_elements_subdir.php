<meta http-equiv="content-type" content="text/html; charset=utf-8" />

<link rel="shortcut icon" href="../../images/icons/favicon.ico" />
<link rel="stylesheet" href="../javascripts/jquery-ui/jquery-ui.min.css"  type="text/css" media="screen" />
<link rel="stylesheet" href="../../stylesheets/estilos.css"  type="text/css" media="screen" />
<link rel="stylesheet" href="../stylesheets/admin_pages.css"  type="text/css" media="screen" />

<script type="text/javascript" src="../../javascripts/vendor/jquery.min.js"></script>
<script type="text/javascript" src="../javascripts/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="../javascripts/jquery-ui/datepicker-es.js"></script>
<script type="text/javascript" src="../../javascripts/comun.js"></script>
<script type="text/javascript" src="../javascripts/admin.js"></script>

<script type="text/javascript">
    $(document).ready(function(){

        var pos;
        pos = window.location.href.search("/admin/equipos/");
        if(pos != -1) {
            window.location.href.search("/admin/equipos/");
            $("#equipos-menu-link").addClass('active');
        }

        pos = window.location.href.search("/admin/noticias/");
        if(pos != -1) {
            window.location.href.search("/admin/noticias/");
            $("#noticias-menu-link").addClass('active');
        }

        pos = window.location.href.search("/admin/partidos/");
        if(pos != -1) {
            window.location.href.search("/admin/partidos/");
            $("#partidos-menu-link").addClass('active');
        }

    });
</script>
