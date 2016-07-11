<?php
include '../config.php';
include CLASSPATH . 'header.php';

$articulo = $_POST['art'];
$titulo = $_POST['tit'];
$precio = $_POST['precio'];
$prov = $_POST['prov'];
$cantidad = $_POST['cant'];
$total = ($precio * $cantidad);

$sql = "SELECT * FROM articulos WHERE visible = 1 AND id = '$articulo' LIMIT 1";

$mysql->query($sql);

// Si hay un registro hay producto
if ($mysql->rowCount() > 0) {

    while ($mysql->fetchRow(2)) {
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
        ?>


        <div id="info-articulo">
            <h1>Confirmación de compra</h1>

            <div class="check_out">
                <div class="producto col-md-12">
                    <!-- Foto, galeria o video -->
                    <div class="col-md-3">


                        <?php if (count($arrfotos) == 1 && $video == "") { ?>	
                            <div class="col-md-12">
                                <img class="img-responsive" src="http://cdn.muebles.uy<?php echo $arrfotos[0]; ?>" alt="<?php echo $titulo; ?>">
                            </div>
                        <?php } else { ?>
                            <div class="col-md-12">
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
                    </div>
                    <div class="check_out_detalles col-md-9">
                        <div class="check_out_titulo"><?php echo $titulo; ?></div>
                        <div class="check_out_descripcion"<p><?php echo $descripcion; ?></p></div>
                    </div>
                </div>  
                <div class="detalles_pago col-md-12">
                <div class="col-md-4">
                    Precio: $ <?php echo $precio; ?>
                </div>
                <div class="col-md-4">
                    Cantidad: <?php echo $cantidad; ?>
                </div>
                <div class="col-md-4">
                    Total: $ <?php echo $total; ?>
                </div>
                </div>
                <div class="col-md-8 col-md-offset-2">

                    <form method="POST" action="procesar_compra.php">
                        <input type="hidden" name="art" id="art" value="<?php echo $articulo; ?>"/>
                        <input type="hidden" name="prov" id="prov" value="<?php echo $prov; ?>"/>
                        <input type="hidden" name="precio" id="precio" value="<?php echo $precio; ?>"/>
                        <input type="hidden" name="cantidad" id="cantidad" value="<?php echo $cantidad; ?>"/>
                        <input type="hidden" name="total" id="total" value="<?php echo $total; ?>"/>

                        <?php if (!isset($_COOKIE['id_clientes'])): ?>
                            <h2 style="text-align:center !important">Complete sus datos:</h2>
                            <input type="hidden" name="sesion" id="sesion" value="1"/>
                            <?php $pass = substr(md5(microtime()), 1, 4); ?>
                            <input type="hidden" name="pass" id="pass" value="<?php echo $pass; ?>">
                            <div class="form-group col-md-10 col-md-offset-1">
                                <input class="form-control input-sm" type="text" name="nombre" id="nombre" placeholder="Ingrese su nombre" required/>
                            </div>
                            <div class="form-group col-md-10 col-md-offset-1">
                                <input class="form-control input-sm" type="email" name="mail" id="mail" placeholder="Ingrese su e-mail" required/>
                            </div>

                            <div class="form-group col-md-10 col-md-offset-1">
                                <input class="form-control input-sm" type="tel" name="tel" id="tel" placeholder="Ingrese su teléfono" required/>
                            </div>
                            <div class="form-group col-md-10 col-md-offset-1">
                                <input class="form-control input-sm" type="text" name="zona" id="zona" placeholder="Ingrese su zona" required/>
                            </div>

                        <?php else: ?>
                            <h3 style="text-align:center !important">Ingrese un comentario opcional:</h3>
                            <input type="hidden" name="sesion" id="sesion" value="2"/>
                            <input type="hidden" name="cliente" id="cliente" value="<?php echo $_COOKIE['id_clientes']; ?>"/>
                        <?php endif; ?>
                        <div class="form-group">
                            <textarea class="form-control input-sm" rows="3" name="comentario" id="comentario" placeholder="Ingrese un comentario de compra opcional"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success col-md-12">Confirmar compra</button>
                    </form>
                </div>
            </div>
        </div>
        </div>


        <?php
    }
}
include CLASSPATH . 'footer_clientes.php';
