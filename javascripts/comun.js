/* JavaScript functions */

/* utilizar AJAX para solicitar info de una noticia sin refrescar la pagina */
function getNoticiaInfo(rec_id){

    var objHttp=null;
    var json_string;
    var row;
    if(window.XMLHttpRequest) {
        objHttp=new XMLHttpRequest();
    }else if(window.ActiveXObject){
        objHttp=new ActiveXObject("Microsoft.XMLHTTP");
    }

    rec_id = rec_id.substr(2,rec_id.length-2);
    var param = "id=" + rec_id;

    objHttp.open("POST","phps/noticia_info.php",true);
    objHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    objHttp.send(param);

    objHttp.onreadystatechange=function() {
        if(objHttp.readyState==4){
            json_string=objHttp.responseText;

            //alert(json_string);
            row = JSON.parse(json_string);
            //alert(row['titulo']);

            //titulo, contenido, fecha_noticia, ruta_foto
            var titulo = row['titulo'];
            var contenido = row['contenido'];
            var fecha_noticia = row['fecha_noticia'];
            var ruta_foto = "images/noticias/" + row['ruta_foto'];
            //alert(ruta_foto);

            $( "#current-news-img" ).attr("src",ruta_foto);
            $( "#news-date" ).html(fecha_noticia);
            $( "#news-title" ).html(titulo);
            $( "#news-content" ).html(contenido);

            window.scrollTo(0, 0);
        }
    }
}

/* get a given URL parameter */
function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('&');
    for (var i = 0; i < sURLVariables.length; i++)
    {
        var sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] == sParam)
        {
            return sParameterName[1];
        }
    }
}

/* validation functions */

/* presence */
function hasValue(element_id) {
        input_element=document.getElementById(element_id);
        //trim leading and trailing spaces
        input_element.value = input_element.value.replace(/^\s*|\s*$/g, '');
        if (input_element.value==null || input_element.value=="") {
            error_message = input_element.name+" no puede estar vacío";
            return error_message;
        } else {
            return true;
        }
}

/* numeric */
function isNumber(element_id) {
    input_element=document.getElementById(element_id);
    regex_pattern = /^[\-\+]?[\d\,]*\.?[\d]*$/;
    if (!regex_pattern.test(input_element.value) && input_element.value.length > 0) {
        error_message = input_element.name+" debe ser numérico";
        return error_message;
    } else {
        return true;
    }
}

/* email */
function isEmail(element_id) {
    input_element=document.getElementById(element_id);
    regex_pattern = /\b[A-Z0-9._%+-]+@(?:[A-Z0-9-]+\.)+[A-Z]{2,4}\b/i;
    if (!regex_pattern.test(input_element.value) && input_element.value.length > 0) {
        error_message = input_element.name+" no es un email válido";
        return error_message;
    } else {
        return true;
    }
}

function isDBDate(element_id) {
    var isvalid;
    var error_message;
    input_element=document.getElementById(element_id);
    regex_pattern = /^(19|20)\d\d([- /.])(0[1-9]|1[012])\2(0[1-9]|[12][0-9]|3[01])$/;
    if (!regex_pattern.test(input_element.value) && input_element.value.length > 0) {
        isvalid = false;
    } else {
        var date_array = input_element.value.split("-");
        var yyyy = date_array[0];
        var mm = date_array[1];
        var dd = date_array[2];
        
        // At this point, yyyy holds the year, mm the month && dd the day of the date entered
        if (dd == 31 && (mm == 4 || mm == 6 || mm == 9 || mm == 11)) {
            isvalid = false; // 31st of a month with 30 days
        } else if (dd >= 30 && mm == 2) {
            isvalid = false; // February 30th || 31st
        } else if (mm == 2 && dd == 29 && !(yyyy % 4 == 0 && (yyyy % 100 != 0 || yyyy % 400 == 0))) {
            isvalid = false; // February 29th outside a leap year
        } else {
            return true; // Valid date
        }
    }

    if(!isvalid) {
        error_message = input_element.name+" no es una fecha válida para el base de dato";
        return error_message;
    }
}

/* equality of two input fields */
function equalValues(input_1_id, input_2_id) {

    input_1=document.getElementById(input_1_id);
    input_2=document.getElementById(input_2_id);

    if (input_1.value != input_2.value) {
        error_message = "Las contraseña no coinciden";
        return error_message;
    } else {
        return true;
    }
}

/* don't accepts sql interpreted character like ;#() to avoid injection */
/* for username field */
/* letter, alphabet, special character _&|*! */
function acceptedAlphaNum1 (element_id) {
    input_element=document.getElementById(element_id);
    regex_pattern = /^[a-zA-Z0-9_&|*!]*$/;
    if (!regex_pattern.test(input_element.value) && input_element.value.length > 0) {
        error_message = input_element.name+" contiene caracter inválido";
        return error_message;
    } else {
        return true;
    }
}

/* don't accepts sql interpreted character like ;#() to avoid injection */
/* for password field */
/* letter, alphabet, space, special character _&|*! */
function acceptedAlphaNum2 (element_id) {
    input_element=document.getElementById(element_id);
    regex_pattern = /^[a-zA-Z0-9 _&|*!]*$/;
    if (!regex_pattern.test(input_element.value) && input_element.value.length > 0) {
        error_message = input_element.name+" contiene carácter inválido";
        return error_message;
    } else {
        return true;
    }
}

function validateForm(form_id) {

    var error_message_div=document.getElementById("info-sect-1");
    var error_messages=[];
    var result;
    var has_error = false;
    var form_elements=[];

    /* presence */
    form_elements = $(".obligatorio");
    for (indx=0;indx<form_elements.length;indx++) {
        result = hasValue(form_elements[indx].id);
        if( result !== true) {
            error_messages.push(result);
            has_error=true;
        }
    }

    /* email */
    form_elements = $(".email");
    for (indx=0;indx<form_elements.length;indx++) {
        result = isEmail(form_elements[indx].id);
        if( result !== true) {
            error_messages.push(result);
            has_error=true;
        }
    }

    /* fecha */
    form_elements = $(".datefield");
    for (indx=0;indx<form_elements.length;indx++) {
        result = isDBDate(form_elements[indx].id);
        if( result !== true) {
            error_messages.push(result);
            has_error=true;
        }
    }

    /* numeric */
    form_elements = $(".numeric");
    for (indx=0;indx<form_elements.length;indx++) {
        result = isNumber(form_elements[indx].id);
        if( result !== true) {
            error_messages.push(result);
            has_error=true;
        }
    }

    /* alpahnumeric */
    form_elements = $(".safe-alphanum1");
    for (indx=0;indx<form_elements.length;indx++) {
        result = acceptedAlphaNum1(form_elements[indx].id);
        if( result !== true) {
            error_messages.push(result);
            has_error=true;
        }
    }

    form_elements = $(".safe-alphanum2");
    for (indx=0;indx<form_elements.length;indx++) {
        result = acceptedAlphaNum2(form_elements[indx].id);
        if( result !== true) {
            error_messages.push(result);
            has_error=true;
        }
    }

    /* equity of two inputs: password */
    form_elements = $(".compare");
    if (form_elements.length == 2) {
        result = equalValues(form_elements[0].id, form_elements[1].id);
        if (result !== true) {
            error_messages.push(result);
            has_error=true;
        }
    }

    /* same equipos */
    form_elements = $(".equipos");
    if (form_elements.length == 2) {
        if ((form_elements[0].options[equipo_local.selectedIndex].value == form_elements[1].options[equipo_away.selectedIndex].value)) {
            error_messages.push("Los equipos seleccionados son lo mismo");
            has_error=true;
        }
    }

    if(has_error) {
        div_inner_html="<ul class='form-error-list'>";
        for (indx=0;indx<error_messages.length;indx++){
            div_inner_html += "<li>" + error_messages[indx] + "</li>";
        }
        div_inner_html += "</ul>";
        error_message_div.innerHTML=div_inner_html;
        return false;
    }


}

/* JQuery code */

$(document).ready(function(){

    /* marcar el enlace actual en el menu con el color rojo */
    var url = window.location.href.split('?')[0];
    $('.nav>li>a').filter(function() {
        return this.href == url;
    }).parent().addClass("active");

    $('.delete-confirmation').on('click', function () {
        return confirm('Are you sure?');
    });

    $('textarea').on('focus', function () {
        $(this).html($(this).html().replace(/^\s*|\s*$/g, ''));
    });

    $( "#clasificacion-grande tr:odd, #clasificacion-small tr:odd" ).css( "background-color", "#bbbbff" );
    //$( "#clasificacion-grande tr" ).filter( ":even" ).css( "background-color", "red" );

    //alert($('.apostar-radio:checked').attr('id'));
    $('.apostar-radio').change(function(){

        //the id in the radio button is as follows: id-6 (game id)
        var $partido_id = $(this).attr('id').split('-')[1];

        //id of the parent row of radio button is as follows: partido-id-6
        var $row_selector = '#partido-' + $(this).attr('id');

        var $home_team = $($row_selector + '> .equipo_local').html();
        var $away_team = $($row_selector + '> .equipo_away').html();

        $("#home_team").val($home_team);
        $("#away_team").val($away_team);

        /* build the form data */

        $('#partido_id').val($partido_id);

        $('#local_team_label').html($home_team);
        $('#away_team_label').html($away_team);

        /* show form */
        $('#apuesta-form-box').show();

        $('.apostar-radio').parent().parent().css('backgroundColor', '#eee');
        $($row_selector).css('backgroundColor', '#428bca');

    });

    var $goles_1_tds = $('.goles_1');
    var $bet_games = $goles_1_tds.length;

    // if innerhtml is empty: this <td></td> will return true; but any value including whitespace in td content will return false
    // trim values - goles before inserting

    $goles_1_tds.each(function(index) {
        if (!$(this).is(':empty')) {
            //$($goles_1_tds[i]).siblings().last().children().first().attr('disabled','disabled');
            $(this).siblings(':last').children(':first').attr('disabled', 'disabled')
        }
    });


    $('#password_confirmation').bind("change paste keyup", function() {
        var $confirm_span = $('#pwd-confirm-span');
        if ( $(this).val() == $('#password').val() ) {
            $confirm_span.css('color', 'green').html('Coincide');
        } else {
            $confirm_span.css('color', 'red').html('No conincide');
        }
    });

    $('#username').bind("change paste keyup", function() {
        var $username_span = $('#username-span');
        if ( acceptedAlphaNum1($(this).attr('id')) === true ) {
            $username_span.attr('class', 'notification-color').html('Carácteres válidos');
        } else {
            $username_span.attr('class', 'error-color').html('Carácteres inválidos');
        }
    });

});

