<?php
include '../config.php';
include CLASSPATH . 'header.php';

$id = $_POST['art_p'];
$prov = $_POST['prov'];
$titulo = $_POST['tit_p'];
$preg = $_POST['preg'];
?>
<div class="conf_pregunta col-md-8 col-md-offset-2" style="text-align:center">
    <strong>Artículo: </strong><span><?php echo $titulo; ?></span><br>
    <strong>Tu pregunta :</strong><span> <?php echo $preg; ?></span><br>

    <?php if (isset($_COOKIE['id_clientes'])): ?>
        <form method="POST" action="http://nuevoestandar.muebles.uy/procesar_pregunta.php">
            <input type="hidden" name="art_p" id="art_p" value="<?php echo $id; ?>"/>
            <input type="hidden" name="prov" id="prov" value="<?php echo $prov; ?>"/>
            <input type="hidden" name="tit_p" id="tit_p" value="<?php echo $titulo; ?>"/>
            <input type="hidden" name="cli" id="cli" value="<?php echo $_COOKIE['id_clientes']; ?>"/>
            <input type="hidden" name="preg" id="preg" value="<?php echo $preg; ?>"/>
            <input type="hidden" name="tipo_f" id="tipo_f" value="1"/>
            <div class="col-md-6">
                <button type="submit" class="btn btn-success btn-sm btn-block">Confirmar pregunta</button>
            </div>
            <div class="col-md-6">
                <button type="submit" class="btn btn-danger btn-sm btn-block">Cancelar</button>
            </div>
        </form>
    <?php else: ?>
    <h3 style="text-align: center">Complete sus datos</h3>
        <form method="POST" action="http://nuevoestandar.muebles.uy/procesar_pregunta.php">
            <input type="hidden" name="art_p" id="art_p" value="<?php echo $id; ?>"/>
            <input type="hidden" name="prov" id="prov" value="<?php echo $prov; ?>"/>
            <input type="hidden" name="tit_p" id="tit_p" value="<?php echo $titulo; ?>"/>
            <input type="hidden" name="preg" id="preg" value="<?php echo $preg; ?>"/>
            <input type="hidden" name="tipo_f" id="tipo_f" value="2"/>
            <div class="form-group">
                <div class="col-md-8 col-md-offset-2">
                    <input type="text" class="form-control input-sm" id="nombre" name="nombre" placeholder="Ingresa tu nombre" required/>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-8 col-md-offset-2">
                    <input type="email" class="form-control input-sm" id="mail" name="mail" placeholder="Ingresa tu e-mail" required/>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-8 col-md-offset-2">
                    <input type="number" class="form-control input-sm" id="tel" name="tel" placeholder="Ingresa tu teléfono" required/>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-8 col-md-offset-2">
                    <input type="text" class="form-control input-sm" id="zona" name="zona" placeholder="Ingresa tu zona" required/>
                </div>
            </div>
            <div class="col-md-8 col-md-offset-2">
            <div class="col-md-4">
                <button type="submit" class="btn btn-success btn-sm btn-block">Enviar</button>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-danger btn-sm btn-block">Atrás</button>
            </div>
            </div>
        </form>
    <?php endif; ?>
</div>
<?php
include CLASSPATH . 'footer_clientes.php';
