<?php
include '../config.php';
?>
<!DOCTYPE html>

<head>

    <?php include CLASSPATH . 'head.php'; ?>
</head>
<body<?php echo $body_class; ?>>

    <?php include CLASSPATH . 'menu-top.php'; ?>

    <div class="container-fluid">
        <div class="panel_contenido_blanco">
            <?php
//RECIBIMOS EL TERMINO A BUSCAR Y LO ESCAPAMOS DE CODIGO MALICIOSO
            $termino = mysql_real_escape_string($_POST['termino']);

//COMPROBAMOS QUE EXITA UN TERMINO PARA BUSCAR
            if ($termino != null) {
                //CONSULTAS PARA USUARIOS SIN NECESIDAD DE ESTAR LOGEADO
                $terminos = explode(" ", $termino);
                $numero_terminos = count($terminos);
                ?>
                <h1 style="text-align: center;">Resultados de búsqueda para:</h1>
                <h2><?php echo $termino; ?></h2>
                <?php
                //CONSULTAS SI EL USUARIO ESTA LOGEADO
                //SI EXISTE LA COOKIE COMO PROVEEDOR
                if (isset($_COOKIE['id_proveedor'])) {
                    $datos_cliente = "SELECT * FROM clientes WHERE mail_clientes LIKE '%$termino%' OR tel_clientes LIKE '%$termino%' OR nombre_clientes LIKE '%$termino%' LIMIT 1";
                    $resultado_datos_cliente = $mysqli->query($datos_cliente);
                    $cont_datos_cliente = mysqli_num_rows($resultado_datos_cliente);
                    if ($cont_datos_cliente == 1) {
                        while ($row = $resultado_datos_cliente->fetch_assoc()) {
                            $id_cliente = $row['id_clientes'];
                        }
                    } else {
                        $id_cliente = null;
                    }

                    $consultas = "SELECT * FROM consultas LEFT JOIN clientes ON consultas.cliente=clientes.id_clientes WHERE prov_consultas='" . $_COOKIE['id_proveedor'] . "' AND cliente='$id_cliente' OR id_mostrar_consulta LIKE '%$termino%' OR descripcion_consultas LIKE '%$termino%' ORDER BY RAND() LIMIT 10";
                    $resultado_consultas = $mysqli->query($consultas);
                    $cont_consultas_cliente = mysqli_num_rows($resultado_consultas);

                    $ventas = "SELECT *  FROM compras LEFT JOIN clientes ON compras.cliente_compra=clientes.id_clientes LEFT JOIN articulos ON compras.articulo_compra=articulos.id WHERE prov_compra='" . $_COOKIE['id_proveedor'] . "' AND id_compra LIKE '%$termino%' OR cliente_compra LIKE '$id_cliente' OR titulo LIKE '%$termino%' OR codigo LIKE '%$termino%' LIMIT 10";
                    $resultado_ventas = $mysqli->query($ventas);
                    $cont_ventas_cliente = mysqli_num_rows($resultado_ventas);

                    if ($cont_consultas_cliente >= 1) {
                        ?>
                        <div class="col-md-6">
                            <div class="panel filterable">
                                <div class="panel-heading">
                                    <h3 class="panel-title">CONSULTAS LOCALIZADAS</h3>
                                </div>
                                <table class="table">
                                    <thead>

                                        <tr class="filters">
                                            <th><input type="text" class="form-control" placeholder="ID" disabled></th>
                                            <th><input type="text" class="form-control" placeholder="Cliente" disabled></th>
                                            <th><input type="text" class="form-control" placeholder="Asunto" disabled></th>
                                            <th><input type="text" class="form-control" placeholder="Estado" disabled></th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = $resultado_consultas->fetch_assoc()) { ?>
                                            <tr onclick="window.location = '//proveedor.muebles.uy/consulta.php?id=<?php echo $row['id_con']; ?>';">
                                                <td><?php echo $row['id_mostrar_consulta']; ?></td>
                                                <td><?php echo $row['nombre_clientes']; ?></td>
                                                <td><?php echo $row['asunto_consultas']; ?></td>
                                                <td><?php
                                                    if ($row['estado_admin_consultas'] == 1) {
                                                        echo "Recepción";
                                                    } else if ($row['estado_admin_consultas'] == 2) {
                                                        echo "Bandeja de entrada";
                                                    } else if ($row['estado_admin_consultas'] == 3) {
                                                        echo "Presupuestando";
                                                    } else if ($row['estado_admin_consultas'] == 4) {
                                                        echo "Fabricando";
                                                    } else if ($row['estado_admin_consultas'] == 5) {
                                                        echo "Cerrada";
                                                    } else if ($row['estado_admin_consultas'] == 6) {
                                                        echo "Inactiva";
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?php
                    } else {
                        
                    }
                    if ($cont_ventas_cliente >= 1) {
                        ?>
                        <div class="col-md-6">
                            <div class="panel filterable">
                                <div class="panel-heading">
                                    <h3 class="panel-title">VENTAS LOCALIZADAS</h3>
                                    <div class="pull-right">
                                        <button class="btn btn-default btn-xs btn-filter">Filtro</button>
                                    </div>
                                </div>
                                <table class="table">
                                    <thead>
                                        <tr class="filters">
                                            <th><input type="text" class="form-control" placeholder="ID" disabled></th>
                                            <th><input type="text" class="form-control" placeholder="Cliente" disabled></th>
                                            <th class="hidden-sm hidden-xs"><input type="text" class="form-control" placeholder="Artículo" disabled></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = $resultado_ventas->fetch_assoc()) { ?>
                                            <tr onclick="window.location = '//proveedor.muebles.uy/venta.php?id=<?php echo $row['id_compra']; ?>';">
                                                <td><?php echo $row['id_compra']; ?></td>
                                                <td><?php echo $row['nombre_clientes']; ?>
                                                    <br><?php echo $row['mail_clientes']; ?>
                                                    <br><?php echo $row['tel_clientes']; ?>
                                                </td>
                                                <td class="hidden-sm hidden-xs"><?php echo $row['titulo']; ?>
                                                    <br>$ <?php echo $row['precio_compra']; ?> X
                                                    <?php echo $row['cantidad']; ?> = $
                                                    <?php echo $row['total']; ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?php
                    } else {
                        
                    }
                } else {
                    
                }

                //SI EL NUMERO DE TERMINOS ES IGUAL A 1
                if ($numero_terminos == 1) {
                    //SI SOLO HAY UNA PALABRA DE BUSQUEDA SE ESTABLECE UNA INSTRUCION CON LIKE 
                    $estandar = "SELECT * FROM articulos WHERE visible=1 AND descripcion LIKE '%$termino%' OR titulo LIKE '%$termino%' OR codigo LIKE '%$termino%' LIMIT 20";
                    $resultado_estandar = $mysqli->query($estandar);
                    $cont_estandar = mysqli_num_rows($resultado_estandar);
                }
                //SI EL NUMERO DE TERMINOS ES MAYOR..
                else {
                    //SI HAY UNA FRASE SE UTILIZA EL ALGORTIMO DE BUSQUEDA AVANZADO DE MATCH AGAINST 
                    //busqueda de frases con mas de una palabra y un algoritmo especializado 
                    $estandar = "SELECT *, MATCH ( titulo, descripcion, codigo ) AGAINST ('$termino' IN BOOLEAN MODE) AS relevancia FROM articulos WHERE MATCH ( titulo, descripcion, codigo ) AGAINST ('$termino' IN BOOLEAN MODE) ORDER BY relevancia LIMIT 20";
                    $resultado_estandar = $mysqli->query($estandar);
                    $cont_estandar = mysqli_num_rows($resultado_estandar);
                }
                $ccotizacion = "SELECT * FROM cotizacion LIMIT 1";
                $resultado_ccotizacion = $mysqli->query($ccotizacion);
                while ($row = $resultado_ccotizacion->fetch_assoc()) {
                    $valor_cotizacion = $row['valor'];
                }
                ?>

                <?php if ($cont_estandar >= 1) { ?>
                    <div class="row">
                        <?php
                        $uno = "0";
                        $doble = "00";
                        while ($row = $resultado_estandar->fetch_assoc()) {
                            $id = $row['id'];
                            $titulo = $row['titulo'];
                            $codigo = $row['codigo'];
                            $subcategoria = $row['subcategoria'];
                            $moneda = $row['moneda'];
                            $precioa = $row['precio'];

                            if ($moneda == 0) {
                                $precio = $precioa;
                            } else {
                                $precioa = round($precioa * $valor_cotizacion);
                                $cont_precio = strlen($precioa);
                                if ($cont_precio == 3) {
                                    $preciob = substr($precioa, 0, 2);
                                    $precio = "$preciob$uno";
                                } else if ($cont_precio == 4) {
                                    $preciob = substr($precioa, 0, 3);
                                    $precio = "$preciob$uno";
                                } else if ($cont_precio == 5) {
                                    $preciob = substr($precioa, 0, 4);
                                    $precio = "$preciob$uno";
                                }
                            }


                            $iva = $row['iva'];
                            if ($iva == 1) {
                                $iva = ' <span class="iva">+IVA</span>';
                            } else {
                                $iva = ' <span class="iva">IVA incluído</span>';
                            }


                            if ($row['origen'] == 1) {
                                $origen = "IMPORTADO pack cerrado";
                            } else if ($row['origen'] == 2) {
                                $origen = "Fabricación NACIONAL";
                            } else if ($row['origen'] == 3) {
                                $origen = "Marca DEAKI de Uruguay";
                            } else {
                                $origen = "N/E";
                            }
                            $medidas = $row['medidas'];
                            $slugarticulo = $row['slug'];
                            $arrmedidas = explode(',', $medidas);

                            $fotos = $row['fotos'];
                            $arrfotos = explode(',', $fotos);
                            if (isset($arrfotos[0]) || $arrfotos[0] != "") {
                                $foto = $arrfotos[0];

                                $extension = strtolower(end(explode('.', $foto)));
                                $name = substr($foto, 0, -(strlen($extension) + 1));
                                $foto = $name . "-500.jpg";
                            } else {
                                $foto = "";
                            }
                            $id_proveedor = $row['idproveedor'];
                            $cprecodigo = "SELECT precodigo FROM proveedores WHERE id_proveedor='$id_proveedor' LIMIT 1";
                            $resultado_cprecodigo = $mysqli->query($cprecodigo);
                            while ($row = $resultado_cprecodigo->fetch_assoc()) {
                                $precodigo = $row['precodigo'];
                            }
                            ?>
                            <div class="col-md-3 articulo">
                                <a href="//estandar.muebles.uy/articulo.php?<?php echo $slugarticulo; ?>&ida=<?php echo $id; ?>&_<?php echo $codigo; ?>" target="_blank">
                                    <div class="hovereffect">
                                        <img class="img-responsive" src="http://www.cdn.muebles.uy<?php echo $foto; ?>" alt="">
                                        <div class="overlay">
                                            <h4><?php echo $titulo; ?></h4>
                                        </div>
                                    </div>
                                </a>
                                <div class="clearfix"></div>
                                <ul><li> <a style="color:#fff !important;" href="//estandar.muebles.uy/articulo.php?<?php echo $slugarticulo; ?>&ida=<?php echo $id; ?>&_<?php echo $codigo; ?>" target="_blank" title="<?php echo $titulo; ?>"><span style="font-size:15px; margin-right:3px;"><strong><?php echo $precio; ?></strong></span><span  style="color:#999">Pesos</span>
                                            <br>
                                        </a><i class="fa fa-arrows-v" style="color:#f97352 !important;margin-right: 0px !important;"></i><?php echo $arrmedidas[0]; ?> <i class="fa fa-arrows-h" style="color:#f97352 !important;margin-right: 0px !important"></i><?php echo $arrmedidas[1]; ?> <i class="fa fa-expand" style="color:#f97352 !important;margin-right: 0px !important"></i><?php echo $arrmedidas[2]; ?>
                                        <br>
                                        <span style="color:#f97352;"><?php echo $precodigo; ?>.<?php echo $codigo; ?></span>
                                        <br>
                                        <span class=""><?php echo $origen; ?></span>
                                    </li>
                                </ul>
                            </div>

                            <?php
                        }
                    } else {
                        
                    }
                    ?>
                </div>
                <?php
            } else {
                ?>
                Ingresa una busqueda    
                <?php
            }
            ?>

        </div>
    </div>
    <?php include CLASSPATH . 'foot.php'; ?>
</body>
</html>