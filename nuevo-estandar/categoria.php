<?php
include '../config.php';
include CLASSPATH . 'header.php';


$categoria = $_GET['c'];
//variable que controla si hay que consultar todos los artículos de una categoria superior
$t = $_GET['t'];
if ($t == 1) {
    $sql = "SELECT * FROM articulos LEFT JOIN proveedores ON articulos.idproveedor=proveedores.id_proveedor WHERE visible = 1 AND idcategoria='$categoria' ORDER BY id";
    $mysql->query($sql);
} else {
    $sql = "SELECT * FROM articulos LEFT JOIN proveedores ON articulos.idproveedor=proveedores.id_proveedor WHERE visible = 1 AND idsubcategoria='$categoria' ORDER BY id";
    $mysql->query($sql);
}

// Si hay un registro hay categorias 
if ($mysql->rowCount() > 0) {
    
    $ccotizacion = "SELECT * FROM cotizacion LIMIT 1";
$resultado_ccotizacion = $mysqli->query($ccotizacion);
while ($row = $resultado_ccotizacion->fetch_assoc()) {
    $valor_cotizacion = $row['valor'];
}
    $uno = "0";
    $doble = "00";
    while ($mysql->fetchRow(2)) {
        $id = $mysql->fieldValue("id");
        $titulo = $mysql->fieldValue("titulo");
        $codigo = $mysql->fieldValue("codigo");
        $subcategoria = $mysql->fieldValue("subcategoria");
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
            } else if ($cont_precio == 4) {
                $preciob = substr($precioa, 0, 3);
                $precio = "$preciob$uno";
            } else if ($cont_precio == 5) {
                $preciob = substr($precioa, 0, 4);
                $precio = "$preciob$uno";
            }
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
        $medidas = $mysql->fieldValue("medidas");
        $slugarticulo = $mysql->fieldValue("slug");
        $arrmedidas = explode(',', $medidas);

        $fotos = $mysql->fieldValue("fotos");
        $arrfotos = explode(',', $fotos);
        if (isset($arrfotos[0]) || $arrfotos[0] != "") {
            $foto = $arrfotos[0];

            $extension = strtolower(end(explode('.', $foto)));
            $name = substr($foto, 0, -(strlen($extension) + 1));
            $foto = $name . "-500.jpg";
        } else {
            $foto = "";
        }
        $precodigo = $mysql->fieldValue("precodigo");
        ?>


        <div class="col-md-3 articulo">
            <a href="articulo.php?<?php echo $slugarticulo; ?>&ida=<?php echo $id; ?>">
                <div class="hovereffect">
                    <img class="img-responsive" src="http://www.cdn.muebles.uy<?php echo $foto; ?>" alt="">
                    <div class="overlay">
                        <h4><?php echo $titulo; ?></h4>
                    </div>
                </div>
            </a>
            <ul><li> <a style="color:#fff !important;" href="/<?php echo $categoria; ?>/<?php echo $subcategoria; ?>/<?php echo $id; ?>_<?php echo $codigo; ?>_<?php echo $slugarticulo; ?>" title="<?php echo $titulo; ?>"><span style="font-size:15px; margin-right:3px;"><strong><?php echo $precio; ?></strong></span><span  style="color:#999">Pesos</span>
                        <br>
                    </a><i class="fa fa-arrows-v" style="color:#f97352 !important;margin-right: 0px !important;"></i><?php echo $arrmedidas[0]; ?> <i class="fa fa-arrows-h" style="color:#f97352 !important;margin-right: 0px !important"></i><?php echo $arrmedidas[1]; ?> <i class="fa fa-expand" style="color:#f97352 !important;margin-right: 0px !important"></i><?php echo $arrmedidas[2]; ?>
                    <br>
                    <span style="color:#f97352;"><?php echo $precodigo; ?>.<?php echo $codigo; ?></span>
                    <br>
                    <span class=""><?php echo $origen; ?></span>
                </li>
            </ul>
        </div>


    <?php }
} else {
    ?>
    <h1 style="text-align:center">No hay artículos en esta sección. Intenta haciendo una búsqueda.</h1>
<?php } ?>



</div><!-- /.row -->


<?php
include CLASSPATH . 'footer_clientes.php';
