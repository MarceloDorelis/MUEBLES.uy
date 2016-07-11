<?php

include '../config.php';

//OBTENEMOS LOS DATOS PASADOS POR POST
$articulo = mysql_real_escape_string($_POST['art']);
$prov = mysql_real_escape_string($_POST['prov']);
$precio = mysql_real_escape_string($_POST['precio']);
$cantidad = mysql_real_escape_string($_POST['cantidad']);
$total = mysql_real_escape_string($_POST['total']);
$sesion = mysql_real_escape_string($_POST['sesion']);
$comentario = mysql_real_escape_string($_POST['comentario']);
$porcentaje = "5%";
$comision = ($total * $porcentaje / 100);
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
if ($sesion == 1) {
    //SINO EXISTE SESION CONTINUAMOS A VERIFICAR QUE EL IP NO PASE EL LIMITE DE COMPRAS SIN INICIAR SESION
    $com_ip = "SELECT ip_compra FROM compras WHERE ip_compra='$ip' LIMIT 3";
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

            //REGISTRAMOS LA COMPRA
            $compras = ("INSERT INTO compras (ip_compra,cliente_compra,prov_compra,articulo_compra,precio_compra,cantidad,total) VALUES ('$ip','$cliente','$prov','$articulo','$precio','$cantidad','$total')");
            mysql_query($compras) or die(mysql_error());
            $ultima_compra = mysql_insert_id();

            //SI EXISTE UN COMENTARIO, COLOCAMOS UN NUEVO MENSAJE DE COMPRA A NOMBRE DEL CLIENTE
            if ($comentario != null) {
                mysql_query("INSERT INTO mensajes_venta (id_venta_mensajes,autor_mensajes,nombre_autor_mensajes,mensaje_mensajes,rol,visto_cliente_mensajes) VALUES ('$ultima_compra','$cliente','$nombre','$comentario','Cliente','2')");
            } else {
                
            }

            // GENERAMOS Y GUARDAMOS VARIABLES PARA LA BIENVENIDA DEL CLIENTE DEL cliente
            $url_bienvenida = "resumen.php";
            $variable_cliente2 = substr(md5(microtime()), 2, 20);
            mysql_query("INSERT INTO ulgin (variable,tipo_usuario,id_usuario,url) VALUES ('$variable_cliente2','1','$cliente','$url_bienvenida')");


            //ENVIAMOS EL EMAIL DE BIENVENIDA
            $para_cli1 = $mail;
            $titulo_cli1 = 'Bienvenid@ ' . $nombre . '';
            $mensaje_cli1 = $head;
            $mensaje_cli1 .= '</br>';
            $mensaje_cli1 .= "Bienvenid@ a MUEBLES.uy " . $nombre .
                    "<br> Estos son los datos que recibimos al realizar una compra en estandar.muebles.uy :
                <br>Nombre: " . $nombre .
                    "<br>Mail:  " . $mail .
                    "<br>Contrase&ntilde;:  " . $pass .
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
            //REGISTRAMOS LAS COMPRA
            $compra = ("INSERT INTO compras (ip_compra,cliente_compra,prov_compra,articulo_compra,precio_compra,cantidad,total) VALUES ('$ip','$cliente','$prov','$articulo','$precio','$cantidad','$total')");
            mysql_query($compra) or die(mysql_error());
            $ultima_compra = mysql_insert_id();
            //SI EXISTE UN COMENTARIO, COLOCAMOS UN NUEVO MENSAJE DE COMPRA A NOMBRE DEL CLIENTE

            if ($comentario != null) {
                mysql_query("INSERT INTO mensajes_venta (id_venta_mensajes,autor_mensajes,nombre_autor_mensajes,mensaje_mensajes,rol,visto_cliente_mensajes) VALUES ('$ultima_compra','$cliente','$nombre','$comentario','Cliente','2')");
            } else {
                
            }
        }
    }
}
//SI EXISTE LA SESION...
else {
    //OBTENEMOS EL ID PASADO POR POST Y CONSULTAMOS POR EL RESTO DE SUS DATOS
    $cliente = mysql_real_escape_string($_POST['cliente']);
    $ccliente = "SELECT * FROM clientes WHERE id_clientes='$cliente'";
    $resultado_ccliente = $mysqli->query($ccliente);
    while ($row = $resultado_ccliente->fetch_assoc()) {
        $nombre = $row['nombre_clientes'];
        $mail = $row['mail_clientes'];
        $tel = $row['tel_clientes'];
        $zona = $row['zona_clientes'];
    }

    //INGRESAMOS LA COMPRA
    $compra = ("INSERT INTO compras (ip_compra,cliente_compra,prov_compra,articulo_compra,precio_compra,cantidad,total) VALUES ('$ip','$cliente','$prov','$articulo','$precio','$cantidad','$total')");
    mysql_query($compra) or die(mysql_error());
    $ultima_compra = mysql_insert_id();

    //SI HAY UN COMENTARIO, LO INSERTAMOS COMO MENSAJE DE COMPRA
    if ($comentario != null) {
        mysql_query("INSERT INTO mensajes_venta (id_venta_mensajes,autor_mensajes,nombre_autor_mensajes,mensaje_mensajes,rol,visto_cliente_mensajes) VALUES ('$ultima_compra','$cliente','$nombre','$comentario','Cliente','2')");
    } else {
        
    }
}
$cprov = "SELECT * FROM proveedores WHERE id_proveedor='$prov'";
$resultado_cprov = $mysqli->query($cprov);
while ($row = $resultado_cprov->fetch_assoc()) {
    $nombre_prov = $row['nombre_proveedor'];
    $mail_prov = $row['mail_proveedor'];
    $tel_prov = $row['tel_proveedor'];
    $zona_prov = $row['zona_proveedor'];
}

//OBTENEMOS EL TITULO DEL ARTICULO, CLIENTE 
$ctitulo = "SELECT titulo FROM articulos WHERE id='$articulo' LIMIT 1";
$resultado_ctitulo = $mysqli->query($ctitulo);
while ($row = $resultado_ctitulo->fetch_assoc()) {
    $titulo = $row['titulo'];
}

$texto_noti = "Felicitaciones!! vendiste el artículo: $titulo";
$texto_noti_cliente = "Felicitaciones!! compraste el artículo: $titulo";

$url_proveedor = "venta.php?id=$ultima_compra";
mysql_query("INSERT INTO notificaciones_proveedor (tipo_notificaciones_proveedor,texto_notificaciones_proveedor,id_prov_notificaciones_proveedor,id_consulta_notificaciones_proveedor,url_notificacion,cliente_notificaciones_proveedor,visto_notificaciones_proveedor) VALUES ('3','$texto_noti','$prov','$id_consulta','$url_proveedor','$cli','1')");

$url_cliente = "compra.php?id=$ultima_compra";
mysql_query("INSERT INTO notificaciones_clientes (tipo_notificaciones_clientes,texto_notificaciones_clientes,id_cliente_notificaciones_clientes,id_consulta_notificaciones_clientes,url_notificaciones_clientes,cliente_notificaciones_clientes,visto_notificaciones_clientes) VALUES ('3','$texto_noti_cliente','$cli','$id_consulta','$url_cliente','$cli','1')");

//GENERAMOS Y GUARDAMOS VARIABLES PARA AUTO LOGIN DEL PROVEEDOR
$variable_proveedor = substr(md5(microtime()), 2, 20);
mysql_query("INSERT INTO ulgin (variable,tipo_usuario,id_usuario,url) VALUES ('$variable_proveedor','2','$prov','$url_proveedor')");
// GENERAMOS Y GUARDAMOS VARIABLES PARA AUTO LOGIN DEL cliente
$variable_cliente = substr(md5(microtime()), 2, 20);
mysql_query("INSERT INTO ulgin (variable,tipo_usuario,id_usuario,url) VALUES ('$variable_cliente','1','$cliente','$url_cliente')");

$para_prov = $mail_prov;
$titulo_prov = 'Felicitaciónes ' . $nombre_prov . ' , vendiste un arítulo nuevo...';
$mensaje_prov = $head;
$mensaje_prov .= '</br>';
$mensaje_prov .= "Felicitaci&oacute;nes " . $nombre . " te compr&oacute; el art&iacute;culo: " . $titulo .
        "<br> La venta est&aacute; realizada, contacta al comprador:
                <br>Nombre: " . $nombre .
        "<br>Mail:  " . $mail .
        "<br>Tel&eacute;fono: " . $tel .
        "<br>Zona: " . $zona .
        "<br><a href=\"http://cdn.muebles.uy/ulgin.php?v=$variable_proveedor\"><button style=\"width: 300px; margin:0px auto;height: 30px;color: #fff;background: #f97352;border: 0px solid #f97352;border-radius: 3px;font-weight: 500;font-size: 18px;-webkit-box-shadow: 0px 0px 5px 3px rgba(199,199,199,1);-moz-box-shadow: 0px 0px 5px 3px rgba(199,199,199,1);box-shadow: 0px 0px 5px 3px rgba(199,199,199,1);
            \">Ver detalles</button></a>";
$mensaje_prov .= $foot;

mail($para_prov, $titulo_prov, $mensaje_prov, $cabeceras);

$para_cli = $mail;
$titulo_cli = 'Felicitaciónes' . $nombre . ', compraste el artículo:' . $titulo . '';
$mensaje_cli = $head;
$mensaje_cli .= '</br>';
$mensaje_cli .= "Felicitaci&oacute;nes" . $nombre . " , compraste el art&iacute;culo:" . $titulo .
        "<br> Contacta al vendedor:
                <br>Nombre: " . $nombre_prov .
        "<br>Mail:  " . $mail_prov .
        "<br>Tel&eacute;fono: " . $tel_prov .
        "<br>Zona: " . $zona_prov .
        "<br><a href=\"http://cdn.muebles.uy/ulgin.php?v=$variable_cliente\"><button style=\"width: 300px; margin:0px auto;height: 30px;color: #fff;background: #f97352;border: 0px solid #f97352;border-radius: 3px;font-weight: 500;font-size: 18px;-webkit-box-shadow: 0px 0px 5px 3px rgba(199,199,199,1);-moz-box-shadow: 0px 0px 5px 3px rgba(199,199,199,1);box-shadow: 0px 0px 5px 3px rgba(199,199,199,1);
            \">Ver compra</button></a>";
$mensaje_cli .= $foot;

mail($para_cli, $titulo_cli, $mensaje_cli, $cabeceras);

//INCREMENTAMOS EL ESTADO DE CUENTA
mysql_query("INSERT INTO estado_cuenta (id_consulta_ec,id_proveedor_ec,id_cliente_ec,id_presupuesto,precio_presupuesto_ec,cantidad_aceptado_ec,cobrado_ec,porcentaje_ec,comision_ec,tipo_compra) VALUES ('$ultima_compra','$prov','$cliente','$articulo','$precio','$cantidad','$total','$porcentaje','$comision','2')");

mysql_query("INSERT INTO estado_cuenta_ami (id_consulta_ec,id_proveedor_ec,id_cliente_ec,id_presupuesto,precio_presupuesto_ec,cantidad_aceptado_ec,cobrado_ec,tipo_compra) VALUES ('$ultima_compra','$prov','$cliente','$articulo','$precio','$cantidad','$total','2')");

echo '<script> window.location="compra_exitosa.php"; </script>';
