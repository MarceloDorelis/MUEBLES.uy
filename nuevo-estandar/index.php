<?php
include '../config.php';
include CLASSPATH . 'header.php';

	$uno = "0";
        $doble = "00";
        
        $ccotizacion = "SELECT * FROM cotizacion LIMIT 1";
        $resultado_ccotizacion = $mysqli->query($ccotizacion);
        while ($row = $resultado_ccotizacion->fetch_assoc()) {
            $valor_cotizacion = $row['valor'];
        }
	
		
$categoria = $_GET['c'];
$pagina = $_GET['page'];



if ($categoria == ""){
	$categoria = "cocinas";
	}


//traigo id categoria
$sql = "SELECT id FROM categorias where slug = '$categoria'";
$mysql->query($sql);
while($mysql->fetchRow(2)){ 
	$categoriaid = $mysql->fieldValue("id");
}



// hago select en la base de datos para traer solo categorias con articulos
$sql = "SELECT c.id,c.slug,c.nombre,c.icono FROM articulos a INNER JOIN categorias c ON a.idcategoria = c.id and a.visible = 1 GROUP BY c.id";
$mysql->query($sql);

// Si hay un registro hay categorias 
if ($mysql->rowCount()>0){  

$subnav = "";

	while($mysql->fetchRow(2)){ 
		$id = $mysql->fieldValue("id");
		$nombre = $mysql->fieldValue("nombre");
		$slug = $mysql->fieldValue("slug");
		$icono = $mysql->fieldValue("icono");

		$subnav .= '<li><a href="/'.$slug.'">'.$nombre.' <i class="fa fa-angle-double-right"></i></a></li>';

	}						

}
                


// hago select en la base de datos para traer solo categorias con articulos
$sql = "SELECT id,slug,nombre,idmadre FROM categorias where idmadre = $categoriaid";
$mysql->query($sql);

// Si hay un registro hay categorias 
if ($mysql->rowCount()>0){  

$subcatnav = "";

	while($mysql->fetchRow(2)){ 
		$id = $mysql->fieldValue("id");
		$nombre = $mysql->fieldValue("nombre");
		$slug = $mysql->fieldValue("slug");

		$subcatnav .= '<li role="presentation"><a href="/'.$categoria.'/'.$slug.'">'.$nombre.'</a></li>';

	}						

}



?>

      
                <div class="row">
                                        <div class="col-md-12">
                 <!-- LOS NACIONALES -->
                              <h1 style="text-align:center">Fabricación nacional</h1>
    			<?php           
				$sql3 = "SELECT * FROM articulos LEFT JOIN proveedores ON articulos.idproveedor=proveedores.id_proveedor WHERE visible = 1 AND nacionales = 1 ORDER BY RAND() LIMIT 5";
				
				$mysql->query($sql3);
				
				// Si hay un registro hay categorias 
				if ($mysql->rowCount()>0){ 
                                    
				
				while($mysql->fetchRow(2)){ 
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
						$iva = ' <span class="iva">+IVA</span>';
					} else {
						$iva = ' <span class="iva">IVA incluído</span>';
					}
					
					
					            if($mysql->fieldValue("origen") == 1){
                $origen = "IMPORTADO pack cerrado";
            }
           else if($mysql->fieldValue("origen") == 2){
               $origen = "Fabricación NACIONAL";
           }
           else if($mysql->fieldValue("origen") == 3){
               $origen = "Marca DEAKI de Uruguay";
           }
           else{
               $origen = "N/E";
           }
					$medidas = $mysql->fieldValue("medidas");
					$slugarticulo = $mysql->fieldValue("slug");
					$arrmedidas = explode(',', $medidas);
					
					$fotos = $mysql->fieldValue("fotos");
					$arrfotos = explode(',', $fotos);
					if (isset($arrfotos[0]) || $arrfotos[0] != "") { 
						$foto = $arrfotos[0];
						
						$extension = strtolower(end(explode('.',$foto)));
						$name = substr($foto,0,-(strlen($extension) + 1));
						$foto = $name."-500.jpg";
						
					} else {
						$foto = "";
					}
                                        $precodigo = $mysql->fieldValue("precodigo");
					
				?>
               
               
				<div class="col-md-3 articulo">
                                    <a href="articulo.php?<?php echo $slugarticulo;?>&ida=<?php echo $id;?>&_<?php echo $codigo;?>">
                <div class="hovereffect">
                    <img class="img-responsive" src="http://www.cdn.muebles.uy<?php echo $foto;?>" alt="">
                    <div class="overlay">
                        <h4><?php echo $titulo;?></h4>
                    </div>
                </div>
                </a>
                <div class="clearfix"></div>
                 <ul><li> <a style="color:#fff !important;" href="/<?php echo $categoria;?>/<?php echo $subcategoria;?>/<?php echo $id;?>_<?php echo $codigo;?>_<?php echo $slugarticulo;?>" title="<?php echo $titulo;?>"><span style="font-size:15px; margin-right:3px;"><strong><?php echo $precio; ?></strong></span><span  style="color:#999">Pesos</span>
<br>
 </a><i class="fa fa-arrows-v" style="color:#f97352 !important;margin-right: 0px !important;"></i><?php echo $arrmedidas[0];?> <i class="fa fa-arrows-h" style="color:#f97352 !important;margin-right: 0px !important"></i><?php echo $arrmedidas[1]; ?> <i class="fa fa-expand" style="color:#f97352 !important;margin-right: 0px !important"></i><?php echo $arrmedidas[2]; ?>
<br>
<span style="color:#f97352;"><?php echo $precodigo;?>.<?php echo $codigo;?></span>
<br>
<span class=""><?php echo $origen;?></span>
</li>
</ul>
       
				</div>
               
               
               <?php }} ?>
                    </div>
                    <div class="col-md-12">
					<div class="clearfix"></div>
				
               <!-- LOS MAS SOFISTICADOS -->
               <h1 style="text-align:center">Los más sofisticados</h1>
    			<?php           
				$sql = "SELECT * FROM articulos LEFT JOIN proveedores ON articulos.idproveedor=proveedores.id_proveedor WHERE visible = 1 AND sofisticado = 1 ORDER BY RAND() LIMIT 5";
				
				$mysql->query($sql);
				
				// Si hay un registro hay categorias 
				if ($mysql->rowCount()>0){  
				
				while($mysql->fetchRow(2)){ 
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
						$iva = ' <span class="iva">+IVA</span>';
					} else {
						$iva = ' <span class="iva">IVA incluído</span>';
					}
					
					
					            if($mysql->fieldValue("origen") == 1){
                $origen = "IMPORTADO pack cerrado";
            }
           else if($mysql->fieldValue("origen") == 2){
               $origen = "Fabricación NACIONAL";
           }
           else if($mysql->fieldValue("origen") == 3){
               $origen = "Marca DEAKI de Uruguay";
           }
           else{
               $origen = "N/E";
           }
					$medidas = $mysql->fieldValue("medidas");
					$slugarticulo = $mysql->fieldValue("slug");
					$arrmedidas = explode(',', $medidas);
					
					$fotos = $mysql->fieldValue("fotos");
					$arrfotos = explode(',', $fotos);
					if (isset($arrfotos[0]) || $arrfotos[0] != "") { 
						$foto = $arrfotos[0];
						
						$extension = strtolower(end(explode('.',$foto)));
						$name = substr($foto,0,-(strlen($extension) + 1));
						$foto = $name."-500.jpg";
						
					} else {
						$foto = "";
					}
					$precodigo = $mysql->fieldValue("precodigo");
				?>
               
               
				<div class="col-md-3 articulo">
                                    <a href="articulo.php?<?php echo $slugarticulo;?>&ida=<?php echo $id;?>&_<?php echo $codigo;?>">
                <div class="hovereffect">
                    <img class="img-responsive" src="http://www.cdn.muebles.uy<?php echo $foto;?>" alt="">
                    <div class="overlay">
                        <h4><?php echo $titulo;?></h4>
                    </div>
                </div>
                </a>
                <div class="clearfix"></div>
                 <ul><li> <a style="color:#fff !important;" href="/<?php echo $categoria;?>/<?php echo $subcategoria;?>/<?php echo $id;?>_<?php echo $codigo;?>_<?php echo $slugarticulo;?>" title="<?php echo $titulo;?>"><span style="font-size:15px; margin-right:3px;"><strong><?php echo $precio; ?></strong></span><span  style="color:#999">Pesos</span>
<br>
 </a><i class="fa fa-arrows-v" style="color:#f97352 !important;margin-right: 0px !important;"></i><?php echo $arrmedidas[0];?> <i class="fa fa-arrows-h" style="color:#f97352 !important;margin-right: 0px !important"></i><?php echo $arrmedidas[1]; ?> <i class="fa fa-expand" style="color:#f97352 !important;margin-right: 0px !important"></i><?php echo $arrmedidas[2]; ?>
<br>
<span style="color:#f97352;"><?php echo $precodigo;?>.<?php echo $codigo;?></span>
<br>
<span class=""><?php echo $origen;?></span>
</li>
</ul>
       
				</div>
               
               
               <?php }} ?>
                    </div>
                    <div class="col-md-12">
                <!-- LOS MAS ECONOMICAS -->
                              <h1 style="text-align:center">Los más económicos</h1>
    			<?php           
				$sql2 = "SELECT * FROM articulos LEFT JOIN proveedores ON articulos.idproveedor=proveedores.id_proveedor WHERE visible = 1 AND economico = 1 ORDER BY RAND() LIMIT 5";
				
				$mysql->query($sql2);
				
				// Si hay un registro hay categorias 
				if ($mysql->rowCount()>0){  
				
				while($mysql->fetchRow(2)){ 
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
						$iva = ' <span class="iva">+IVA</span>';
					} else {
						$iva = ' <span class="iva">IVA incluído</span>';
					}
					
					
					            if($mysql->fieldValue("origen") == 1){
                $origen = "IMPORTADO pack cerrado";
            }
           else if($mysql->fieldValue("origen") == 2){
               $origen = "Fabricación NACIONAL";
           }
           else if($mysql->fieldValue("origen") == 3){
               $origen = "Marca DEAKI de Uruguay";
           }
           else{
               $origen = "N/E";
           }
					$medidas = $mysql->fieldValue("medidas");
					$slugarticulo = $mysql->fieldValue("slug");
					$arrmedidas = explode(',', $medidas);
					
					$fotos = $mysql->fieldValue("fotos");
					$arrfotos = explode(',', $fotos);
					if (isset($arrfotos[0]) || $arrfotos[0] != "") { 
						$foto = $arrfotos[0];
						
						$extension = strtolower(end(explode('.',$foto)));
						$name = substr($foto,0,-(strlen($extension) + 1));
						$foto = $name."-500.jpg";
						
					} else {
						$foto = "";
					}
					$precodigo = $mysql->fieldValue("precodigo");
				?>
               
               
				<div class="col-md-3 articulo">
                                    <a href="articulo.php?<?php echo $slugarticulo;?>&ida=<?php echo $id;?>&_<?php echo $codigo;?>">
                <div class="hovereffect">
                    <img class="img-responsive" src="http://www.cdn.muebles.uy<?php echo $foto;?>" alt="">
                    <div class="overlay">
                        <h4><?php echo $titulo;?></h4>
                    </div>
                </div>
                </a>
                <div class="clearfix"></div>
                 <ul><li> <a style="color:#fff !important;" href="/<?php echo $categoria;?>/<?php echo $subcategoria;?>/<?php echo $id;?>_<?php echo $codigo;?>_<?php echo $slugarticulo;?>" title="<?php echo $titulo;?>"><span style="font-size:15px; margin-right:3px;"><strong><?php echo $precio; ?></strong></span><span  style="color:#999">Pesos</span>
<br>
 </a><i class="fa fa-arrows-v" style="color:#f97352 !important;margin-right: 0px !important;"></i><?php echo $arrmedidas[0];?> <i class="fa fa-arrows-h" style="color:#f97352 !important;margin-right: 0px !important"></i><?php echo $arrmedidas[1]; ?> <i class="fa fa-expand" style="color:#f97352 !important;margin-right: 0px !important"></i><?php echo $arrmedidas[2]; ?>
<br>
<span style="color:#f97352;"><?php echo $precodigo;?>.<?php echo $codigo;?></span>
<br>
<span class=""><?php echo $origen;?></span>
</li>
</ul>
       
				</div>
               
               
               <?php }} ?>
               
                    </div>

                </div><!-- /.row -->
        

<?php include CLASSPATH . 'footer_clientes.php';