<?php

include '../config.php';

//OBTENEMOS LOS DATOS PASADOS POR POST
    $articulo = $_POST['art_p'];
    $prov = $_POST['prov'];
    $titulo = $_POST['tit_p'];
    $preg = $_POST['preg'];
    $tipo_f = $_POST['tipo_f'];
$ip = real_ip();

//OBTENEMOS LOS DATOS NECESARIOS PARA CREAR LAS notificaciones y mails
$h = "SELECT cuerpo_mail FROM mails WHERE id_mail='20'";
$header = $mysqli->query($h);

$f = "SELECT cuerpo_mail FROM mails WHERE id_mail='21'";
$footer = $mysqli->query($f);

while ($row = $header->fetch_assoc()) {
    $head = $row['cuerpo_mail'];
}

while ($row = $footer->fetch_assoc()) {
    $foot = $row['cuerpo_mail'];
}

/* CABECERAS PARA EL MAIL */

$cabeceras = "MIME-Version: 1.0\r\n";
$cabeceras .= "Content-type: text/html; charset=iso-8859-1\r\n";
$cabeceras .= 'From: info@muebles.uy' . "\r\n" .
        'Reply-To: info@muebles.uy' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();


//COMPROBAMOS SI EXISTE UNA SESION ABIERTA
if ($tipo_f == 2) {
    //SINO EXISTE SESION CONTINUAMOS A VERIFICAR QUE EL IP NO PASE EL LIMITE DE COMPRAS SIN INICIAR SESION
    $com_ip = "SELECT ip FROM preguntas WHERE ip='$ip' LIMIT 3";
    $resultado_com_ip = $mysqli->query($com_ip);
    $cont_resultado_com_ip = mysqli_num_rows($resultado_com_ip);

    //SI SUPERÓ EL LIMITE DE COMPRAR SIN INICIAR LO MANDAMOS A LOGEARSE ANTES DE CONTINUAR
    if ($cont_resultado_com_ip == 100) {
        echo '<script> window.location="//cdn.muebles.uy/index.php?msj=10.php"; </script>';
    }
    //SINO
    else {
        //RECIBIMOS EL MAIL ENVIADO POR POST CLIENTE
        $mail = mysql_real_escape_string($_POST['mail']);
        
        //COMPROBAMOS QUE EL MAIL NO ESTE REGISTRADO
        $com = "SELECT * FROM clientes WHERE mail_clientes='$mail' LIMIT 1";
        $resultado_com = $mysqli->query($com);
        $cont_resultado_com = mysqli_num_rows($resultado_com);

        //SI EL MAIL NO ESTA REGISTRADO CONTINUAMOS A REGISTRAR EL CLIENTE Y LUEGO L COMPRA
        if ($cont_resultado_com == 0) {
            //RECIBIMOS DATOS DEL NUEVO CLIENTE
            $nombre = mysql_real_escape_string($_POST['nombre']);
            $tel = mysql_real_escape_string($_POST['tel']);
            $zona = mysql_real_escape_string($_POST['zona']);
            $pass = mysql_real_escape_string($_POST['pass']);
            //REGISTRAMOS EL CLIENTE
            $clientes = ("INSERT INTO clientes (nombre_clientes,mail_clientes,tel_clientes,zona_clientes,pass_clientes) VALUES ('$nombre','$mail','$tel','$zona','$pass')");
            mysql_query($clientes) or die(mysql_error());
            $cliente = mysql_insert_id();

            //REGISTRAMOS LA PREGUNTA
            $pregunta = ("INSERT INTO preguntas (ip,cliente,proveedor,articulo,pregunta) VALUES ('$ip','$cliente','$prov','$articulo','$preg')");
            mysql_query($pregunta) or die(mysql_error());
            $ultima_pregunta = mysql_insert_id();

            // GENERAMOS Y GUARDAMOS VARIABLES PARA LA BIENVENIDA DEL CLIENTE DEL cliente
            $url_bienvenida = "resumen.php";
            $variable_cliente2 = substr(md5(microtime()), 2, 20);
            mysql_query("INSERT INTO ulgin (variable,tipo_usuario,id_usuario,url) VALUES ('$variable_cliente2','1','$cliente','$url_bienvenida')");

            $pass = substr(md5(microtime()), 1, 4);
             
//ENVIAMOS EL EMAIL DE BIENVENIDA
            $para_cli1 = $mail;
            $titulo_cli1 = 'Bienvenid@ ' . $nombre . '';
            $mensaje_cli1 = $head;
            $mensaje_cli1 .= '</br>';
            $mensaje_cli1 .= "Bienvenid@ a MUEBLES.uy " . $nombre .
                    "<br> Estos son los datos que recibimos al realizar una pregunta en estandar.muebles.uy :
                <br>Nombre: " . $nombre .
                    "<br>Mail:  " . $mail .
                    "<br>Contrase&ntilde;a:  " . $pass .
                    "<br>Tel&eacute;fono: " . $tel .
                    "<br>Zona: " . $zona .
                    "<br>Agradecemos verifiques tus datos ingresando en el siguiente bot&oacute;n
        <br><a href=\"http://cdn.muebles.uy/ulgin.php?v=$variable_cliente2\"><button style=\"width: 300px; margin:0px auto;height: 30px;color: #fff;background: #f97352;border: 0px solid #f97352;border-radius: 3px;font-weight: 500;font-size: 18px;-webkit-box-shadow: 0px 0px 5px 3px rgba(199,199,199,1);-moz-box-shadow: 0px 0px 5px 3px rgba(199,199,199,1);box-shadow: 0px 0px 5px 3px rgba(199,199,199,1);
            \">Ver mi cuenta</button></a>";
            $mensaje_cli1 .= $foot;

            mail($para_cli1, $titulo_cli1, $mensaje_cli1, $cabeceras);
        }
        // SI ESTA REGISTRADO
        else {
            //GUARDAMOS LOS DATOS DEL CLIENTE EN VARIABLES
            while ($row = $resultado_com->fetch_assoc()) {
                $cliente = $row['id_clientes'];
                $nombre = $row['nombre_clientes'];
                $tel = $row['tel_clientes'];
                $zona = $row['zona_clientes'];
            }
            //REGISTRAMOS LA PREGUNTA
            $pregunta = ("INSERT INTO preguntas (ip,cliente,proveedor,articulo,pregunta) VALUES ('$ip','$cliente','$prov','$articulo','$preg')");
            mysql_query($pregunta) or die(mysql_error());
            $ultima_pregunta = mysql_insert_id();

        }
    }
}
//SI EXISTE LA SESION...
else {
    //OBTENEMOS EL ID PASADO POR POST Y CONSULTAMOS POR EL RESTO DE SUS DATOS
    $cliente = mysql_real_escape_string($_POST['cli']);
    $ccliente = "SELECT * FROM clientes WHERE id_clientes='$cliente'";
    $resultado_ccliente = $mysqli->query($ccliente);
    while ($row = $resultado_ccliente->fetch_assoc()) {
        $nombre = $row['nombre_clientes'];
        $mail = $row['mail_clientes'];
        $tel = $row['tel_clientes'];
        $zona = $row['zona_clientes'];
    }

            //REGISTRAMOS LA PREGUNTA
            $pregunta = ("INSERT INTO preguntas (ip,cliente,proveedor,articulo,pregunta) VALUES ('$ip','$cliente','$prov','$articulo','$preg')");
            mysql_query($pregunta) or die(mysql_error());
            $ultima_pregunta = mysql_insert_id();

}
$cprov = "SELECT * FROM proveedores WHERE id_proveedor='$prov'";
$resultado_cprov = $mysqli->query($cprov);
while ($row = $resultado_cprov->fetch_assoc()) {
    $nombre_prov = $row['nombre_proveedor'];
    $mail_prov = $row['mail_proveedor'];
    $tel_prov = $row['tel_proveedor'];
    $zona_prov = $row['zona_proveedor'];
}

$texto_noti = "Tienes una nueva pregunta en el artículo: $titulo";
$texto_noti_cliente = "Mirá tu pregunta online sobre: $titulo";

$url_proveedor = "pregunta.php?id=$ultima_pregunta";
mysql_query("INSERT INTO notificaciones_proveedor (tipo_notificaciones_proveedor,texto_notificaciones_proveedor,id_prov_notificaciones_proveedor,id_consulta_notificaciones_proveedor,url_notificacion,cliente_notificaciones_proveedor,visto_notificaciones_proveedor) VALUES ('9','$texto_noti','$prov','$articulo','$url_proveedor','$cliente','1')");

$url_cliente = "pregunta.php?id=$ultima_pregunta";
mysql_query("INSERT INTO notificaciones_clientes (tipo_notificaciones_clientes,texto_notificaciones_clientes,id_cliente_notificaciones_clientes,id_consulta_notificaciones_clientes,url_notificaciones_clientes,cliente_notificaciones_clientes,visto_notificaciones_clientes) VALUES ('9','$texto_noti_cliente','$cliente','$id_consulta','$url_cliente','$cliente','1')");

//GENERAMOS Y GUARDAMOS VARIABLES PARA AUTO LOGIN DEL PROVEEDOR
$variable_proveedor = substr(md5(microtime()), 2, 20);
mysql_query("INSERT INTO ulgin (variable,tipo_usuario,id_usuario,url) VALUES ('$variable_proveedor','2','$prov','$url_proveedor')");
// GENERAMOS Y GUARDAMOS VARIABLES PARA AUTO LOGIN DEL cliente
$variable_cliente = substr(md5(microtime()), 2, 20);
mysql_query("INSERT INTO ulgin (variable,tipo_usuario,id_usuario,url) VALUES ('$variable_cliente','1','$cliente','$url_cliente')");

$para_prov = $mail_prov;
$titulo_prov = 'Hola ' . $nombre_prov . ' , tienes una nueva pregunta..';
$mensaje_prov = $head;
$mensaje_prov .= '</br>';
$mensaje_prov .= "Hola " . $nombre_prov . " tienes una nueva pregunta en el art&iacute;culo: " . $titulo .
        "<br> Ingresa en el siguiente bot&oacute;n para responderla:
        <br><a href=\"http://cdn.muebles.uy/ulgin.php?v=$variable_proveedor\"><button style=\"width: 300px; margin:0px auto;height: 30px;color: #fff;background: #f97352;border: 0px solid #f97352;border-radius: 3px;font-weight: 500;font-size: 18px;-webkit-box-shadow: 0px 0px 5px 3px rgba(199,199,199,1);-moz-box-shadow: 0px 0px 5px 3px rgba(199,199,199,1);box-shadow: 0px 0px 5px 3px rgba(199,199,199,1);
            \">Ver pregunta</button></a>";
$mensaje_prov .= $foot;

mail($para_prov, $titulo_prov, $mensaje_prov, $cabeceras);

$para_cli = $mail;
$titulo_cli = 'Hola ' . $nombre . ', hemos entregado tu pregunta';
$mensaje_cli = $head;
$mensaje_cli .= '</br>';
$mensaje_cli .= "Hola " . $nombre . " , hemos entregado automaticamente tu pregunta al vendedor del art&iacute;culo:" . $titulo .
        "<br> Tu pregunta: " . $preg . 
        "<br>En las siguientes 48 hs recibir&aacute;s tu respuesta, de no ser as&iacute;, por favor comun&iacute;quese con atenci&oacute;n al usuario de MUEBLES.uy: 22027288 o info@muebles.uy . 
        <br><a href=\"http://cdn.muebles.uy/ulgin.php?v=$variable_cliente\"><button style=\"width: 300px; margin:0px auto;height: 30px;color: #fff;background: #f97352;border: 0px solid #f97352;border-radius: 3px;font-weight: 500;font-size: 18px;-webkit-box-shadow: 0px 0px 5px 3px rgba(199,199,199,1);-moz-box-shadow: 0px 0px 5px 3px rgba(199,199,199,1);box-shadow: 0px 0px 5px 3px rgba(199,199,199,1);
            \">Ver pregunta</button></a>";
$mensaje_cli .= $foot;

mail($para_cli, $titulo_cli, $mensaje_cli, $cabeceras);

header("location:articulo.php?$titulo&ida=$articulo");