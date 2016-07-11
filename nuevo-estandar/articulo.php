<?php
include '../config.php';
include CLASSPATH . 'header.php';

$ccotizacion = "SELECT * FROM cotizacion LIMIT 1";
$resultado_ccotizacion = $mysqli->query($ccotizacion);
while ($row = $resultado_ccotizacion->fetch_assoc()) {
    $valor_cotizacion = $row['valor'];
}
$idarticulo = $_GET['ida'];

$preguntas = "SELECT * FROM preguntas WHERE articulo='$idarticulo' ORDER BY id_pregunta DESC";
$resultado_preguntas = $mysqli->query($preguntas);
$cont_resultado_preguntas = mysqli_num_rows($resultado_preguntas);
?>

<div class="container" id="info-articulo">

    <?php
    $sql = "SELECT * FROM articulos LEFT JOIN proveedores ON articulos.idproveedor=proveedores.id_proveedor WHERE visible = 1 AND id = $idarticulo LIMIT 1";

    $mysql->query($sql);

// Si hay un registro hay producto
    if ($mysql->rowCount() == 0) {

    }
    else{
        $uno = "0";
        $doble = "00";

        while ($mysql->fetchRow(2)) {
            $titulo = $mysql->fieldValue("titulo");
            $codigo = $mysql->fieldValue("codigo");
            $precodigo = $mysql->fieldValue("precodigo");
            $subcategoria = $mysql->fieldValue("subcategoria");
            $categoria = $mysql->fieldValue("categoria");
            $moneda = $mysql->fieldValue("moneda");
            $precioa = $mysql->fieldValue("precio");

            if ($moneda == 0) {
                $precio = $precioa;
            } else {
                $precioa = round($precioa * $valor_cotizacion);
                $cont_precio = strlen($precioa);
                if ($cont_precio == 3) {
                    $preciob = substr($precioa, 0, 2);
                    $precio = "$preciob$uno";
                }
                else if ($cont_precio == 4) {
                    $preciob = substr($precioa, 0, 3);
                    $precio = "$preciob$uno";
                } else if ($cont_precio == 5) {
                    $preciob = substr($precioa, 0, 4);
                    $precio = "$preciob$uno";
                }
            }


            $iva = $mysql->fieldValue("iva");
            if ($iva == 1) {
                $iva = '<span class="iva">+IVA</span>';
            } else {
                $iva = '<span class="iva">IVA incluído</span>';
            }


            if ($mysql->fieldValue("origen") == 1) {
                $origen = "IMPORTADO pack cerrado";
            } else if ($mysql->fieldValue("origen") == 2) {
                $origen = "Fabricación NACIONAL";
            } else if ($mysql->fieldValue("origen") == 3) {
                $origen = "Marca DEAKI de Uruguay";
            } else {
                $origen = "N/E";
            }
            $color = $mysql->fieldValue("color");
            $medidas = $mysql->fieldValue("medidas");
            $arrmedidas = explode(',', $medidas);

            $pago = $mysql->fieldValue("pago");
            $envio = $mysql->fieldValue("envio");
            $montaje = $mysql->fieldValue("montaje");

            $fotos = $mysql->fieldValue("fotos");
            $arrfotos = explode(',', $fotos);
            $arrfotos = array_filter($arrfotos);

            $video = $mysql->fieldValue("video");
            $prov = $mysql->fieldValue("idproveedor");
            $descripcion = $mysql->fieldValue("descripcion");
            $localidad = $mysql->fieldValue("localidad");
            ?>



            <div class="row">
                <div class="titulo_articulo">
                    <?php echo $titulo;?>
                </div>
                <!-- Foto, galeria o video -->
                <div class="col-md-6">


                    <?php if (count($arrfotos) == 1 && $video == "") { ?>	
                        <div class="col-md-8 col-md-offset-2 foto">
                            <img class="img-responsive" src="http://cdn.muebles.uy<?php echo $arrfotos[0]; ?>" alt="<?php echo $titulo; ?>">
                        </div>
                    <?php } else { ?>
                        <div class="col-md-8 col-md-offset-2 foto">
                            <div id="fotos-articulo" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner" role="listbox">
                                    <?php
                                    $active = 0;
                                    foreach ($arrfotos as $value) {
                                        ?>

                                        <div class="item<?php
                        if ($active == 0) {
                            echo " active";
                        }
                                        ?>">
                                            <img src="http://cdn.muebles.uy<?php echo $value; ?>" alt="<?php echo $titulo; ?>">
                                        </div>

                                        <?php
                                        $active = 1;
                                    }
                                    ?>

                                    <!-- Controls -->
                                    <a class="left carousel-control" href="#fotos-articulo" role="button" data-slide="prev">
                                        <span class="flecha_galeria glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                                        <span class="sr-only">Anterior</span>
                                    </a>
                                    <a class="right carousel-control" href="#fotos-articulo" role="button" data-slide="next">
                                        <span class="flecha_galeria glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                                        <span class="sr-only">Siguiente</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="descripcion_estandar col-md-10">
                        <strong class="titulo_estandar"><i class="fa fa-eye estandar_icon"></i>Descripción del artículo</strong>
                        <br><span class="descripcion_articulo"><?php echo $descripcion; ?></span>
                    </div>
                </div>

                <div class="col-md-6">

                    <i class="fa fa-usd estandar_icon"></i><span class="resaltado_color"> <?php echo $precio; ?> </span><span class="titulo_estandar">Pesos </span><span style="background: rgb(80, 80, 80);margin-left: 10px;">CONTADO</span>
                    <br><span style="background: rgb(80, 80, 80);margin-left: 10px;"><?php echo $origen; ?></span>
                    <br><span class="titulo_estandar">Código: </span><span class="resaltado"><?php echo $precodigo; ?>.<?php echo $codigo; ?></span>
                    <form method="POST" action="http://nuevoestandar.muebles.uy/compra.php">
                        <input type="hidden" name="art" id="art" value="<?php echo $idarticulo; ?>"/>
                        <input type="hidden" name="tit" id="tit" value="<?php echo $titulo; ?>"/>
                        <input type="hidden" name="precio" id="precio" value="<?php echo $precio; ?>"/>
                        <input type="hidden" name="prov" id="prov" value="<?php echo $prov; ?>"/>
                        <div class="col-md-3">
                            <input type="number" class="form-control input-sm" id="cant" name="cant" min="1" placeholder="Cantidad" required/>
                        </div>
                        <div class="col-md-9">
                            <button type="submit" class="btn btn-success btn-sm">Comprar!</button>
                            <button type="button" class="btn btn-primary btn-sm" id="btn_preguntas">Preguntar</button>
                        </div>
                    </form>
                    <hr>
                    <ul>
                        <li><i class="fa fa-arrows-v estandar_icon" style="margin-left:5px;"></i> <span class="titulo_estandar" style="margin-left:5px;"> Alto: </span><span><?php echo $arrmedidas[0]; ?> cm</span></li>
                        <li><i class="fa fa-arrows-h estandar_icon"></i> <span class="titulo_estandar">Largo: </span><span><?php echo $arrmedidas[1]; ?> cm</span></li>
                        <li><i class="fa fa-expand estandar_icon"></i> <span class="titulo_estandar">Prof.: </span><span><?php echo $arrmedidas[2]; ?> cm</span></li>
                    </ul>
                    <span class="titulo_estandar">Color:</span>
                    <br><span><?php echo $color; ?></span>
                    <hr>
                    <br><i class="fa fa-money estandar_icon"></i> <span class="titulo_estandar">Forma de pago</span>
                    <br><span><?php echo $pago; ?></span>
                    <br><br><i class="fa fa-truck estandar_icon"></i> <span class="titulo_estandar">Tarifas de entrega</span>
                    <br><span><?php echo $envio; ?></span>
                    <br><br><i class="fa fa-wrench estandar_icon"></i><span class="titulo_estandar">Tarifas de armado</span>
                    <br><span><?php echo $montaje; ?></span>
                    <br><br><i class="fa fa-money fa-globe estandar_icon"></i> <span class="titulo_estandar">Localidad del vendedor:</span>
                    <br><span><?php echo $localidad; ?></span>


                </div>
                <div class="col-md-12 preguntas_box_perfil">
                    <div class="col-md-6" id="preguntas">
                        <h3>Preguntas al vendedor</h3>
                        <form method="POST" action="http://nuevoestandar.muebles.uy/pregunta.php">         
                            <input type="hidden" name="art_p" id="art_p" value="<?php echo $idarticulo; ?>"/>
                            <input type="hidden" name="prov" id="prov" value="<?php echo $prov; ?>"/>
                            <input type="hidden" name="tit_p" id="tit_p" value="<?php echo $titulo; ?>"/>
                                <textarea class="form-control" rows="2" name="preg" id="preg" placeholder="Escribe tu pregunta aquí..." required></textarea>
                                <button type="submit" class="btn btn-success btn-block btn-sm" style="float: right;">Preguntar!</button>                            
                        </form>
                    </div>
                    <div class="col-md-6">
                        <h3 style="text-align: center">Respuestas del vendedor</h3>
                        <div class="preguntas_box col-md-12">
                            <?php if ($cont_resultado_preguntas == 0) { ?>
                                No hay preguntas
                            <?php
                            } else {
                                while ($row = $resultado_preguntas->fetch_assoc()) {
                                    ?>
                                    <div class="pregunta"><i class="fa fa-comment-o estandar_icon" aria-hidden="true"></i> <?php echo $row['pregunta']; ?> <small></small></div>
                                    <div class="respuesta"><i class="fa fa-comments-o estandar_icon" aria-hidden="true"></i> <?php
                                        if ($row['respuesta'] == null) {
                                            echo 'Esta pregunta no ha sido respondida por el vendedor';
                                        } else {
                                            echo $row['respuesta'];
                                        }
                                        ?> <small></small></div>
                                <?php }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <?php
    }
}
include CLASSPATH . 'footer_clientes.php';
