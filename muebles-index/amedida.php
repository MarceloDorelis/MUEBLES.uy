<?php include '../config.php';?>
<!DOCTYPE html>
<html lang="en">
<head>

<?php include CLASSPATH . 'head.php';?>
</head>
<body<?php echo $body_class;?>>

<?php include CLASSPATH . 'menu-top.php';?>
    
    <div class="container-fluid">
    <div class="row panel_contenido_blanco">
    
<div class="pasos">
    <h2> Consulte por muebles "A Medida" </h2>

    <form id="amedida_form_index" action="ingresar_consulta_index.php" method="post">
        <div class="col-md-4 mcol"><div class="form-group">
                <input type="hidden" class="form-control" name="tipo_consulta" id="tipo_consulta" value="1">
                <label for="espacio"><img src="images/01.png" class="nropaso" /></span>  Selecciona el espacio:</label>
                <select class="form-control" name="asunto" id="asunto">

                    <option value="Exterior">Selecionar espacio</option>
                    <option value="Exterior">Exterior</option>
                    <option value="Sala-Estar">Sala-Estar</option>
                    <option value="Baño">Baño</option>
                    <option value="Cocina">Cocina</option>
                    <option value="Dormi-bebe">Dormi-bebe</option>
                    <option value="Dormi-Juvenil">Dormi-Juvenil</option>
                    <option value="Dormi-adulto">Dormi-adulto</option>
                    <option value="Oficina">Oficina</option>
                    <option value="Cerramiento">Cerramiento</option>
                    <option value="Decoración">Decoración</option>
                    <option value="Asiento-Sofá">Asiento-Sofá</option>
                    <option value="Especiales">Especiales</option>

                </select></div></div>

        <div class="col-md-4 mcol"><label for="descripcion"><img src="images/02.png" class="nropaso" />  Ingresa la descripci&oacute;n:</label>
            <textarea class="form-control" cols="40" rows="3" name="descripcion" id="descripcion" placeholder="Ingresa la descripci&oacute;n del art&iacute;culo, ej: Medidas, Colores, Tirador..." REQUIRED></textarea>
            <br>
            <span style="display:none"><strong>Opcional:</strong> <br> - Selecciona un archivo desde tu dispositivo <br>- Para seleccionar m&uacuteltiples archivos presione "CTRL"
            </span>
            <input type="file" name="imagen" id="imagen" class="mbtn" style="width:100%;display:none"> 
        </div>          
        <div class="col-md-4 mcol"><label for="datos"><img src="images/03.png" class="nropaso" />  Ingresa tus datos:</label>

            <div class="form-group">
                <input type="text" class="form-control mform-control" name="nombre" id="nombre" placeholder="Ingresa tu nombre" REQUIRED>
                <input type="email" class="form-control mform-control" name="mail" id="mail" placeholder="Ingresa tu e-mail" REQUIRED>
                <input type="tel" class="form-control mform-control" id="tel" name="tel" placeholder="Ingresa tu tel&eacute;fono" REQUIRED>
                <input type="text" class="form-control mform-control" name="zona" id="zona" placeholder="Ingresa la zona" REQUIRED>
                <?php $pass = substr(md5(microtime()), 1, 4); ?>
                <input type="hidden" name="pass" id="pass" value="<?php echo $pass; ?>">

                <div class="form-group">  
                    <input type="checkbox" name="terminos" id="terminos" value="1" onchange="javascript:showContent()"/>
                    <span onclick="if (this.parentNode.nextSibling.childNodes[0].style.display != '') {
                                this.parentNode.nextSibling.childNodes[0].style.display = '';
                                this.value = 'Cancelar';
                            } else {
                                this.parentNode.nextSibling.childNodes[0].style.display = 'none';
                                this.value = 'Nueva consulta';
                            }" style="color:#f97352;cursor: pointer;"> ACEPTAR TERMINOS Y CONDICIONES DE LA PÁGINA </span>

                </div><div><div style="display: none;">

                        <textarea style="width:100%; height:100px; color:#000;">
Las pautas para el uso de los servicios y la interacción de los usuarios dentro del sitio www.muebles.uy (en adelante, "el Sitio"), son dispuestas exclusivamente por La empresa MUEBLES.uy (en adelante, "MUEBLES.uy").
Consiguientemente, la utilización que un individuo haga de los servicios incluidos en el Sitio s&oacute;lo se considerar&aacute; autorizada cuando lo sea en cumplimiento de las pautas de uso impuestas, con los l&iacute;mites y alcances aqu&iacute; delineados, as&iacute; como las que surjan de disposiciones complementarias o accesorias, y/o de las diferentes normativas legales de orden nacional e internacional cuya aplicaci&oacute;n corresponda.

1. ACEPTACIÓN POR PARTE DE LOS USUARIOS 
MUEBLES.uy se reserva el derecho a exigir que cada usuario, acepte y cumpla los t&eacute;rminos aqu&iacute; incluidos como condici&oacute;n necesaria para el acceso, permanencia y utilizaci&oacute;n de los servicios y/o contenidos brindados por el Sitio.
El usuario que no acepte, no est&eacute; de acuerdo, o incumpla las disposiciones fijadas por  MUEBLES.uy en estos T&eacute;rminos y Condiciones, no contar&aacute; con autorizaci&oacute;n para el uso de los servicios y contenidos que existen o puedan existir en el Sitio, debiendo abstenerse de ingresar nuevamente al Sitio y/o utilizar cualquier servicio del mismo. En tal sentido el acceso, permanencia, y utilizaci&oacute;n de los servicios y contenidos por parte de un usuario implicar&aacute; y har&aacute; presumir la aceptaci&oacute;n, sin reservas por parte del usuario, de todas y cada una de las disposiciones dictadas por MUEBLES.uy.
MUEBLES.uy podr&aacute; en cualquier momento y sin necesidad de previo aviso modificar estos T&eacute;rminos y Condiciones. Tales modificaciones ser&aacute;n operativas a partir de su fijación en el Sitio. El usuario deber&aacute; mantenerse informado en cuanto a los t&eacute;rminos aqu&iacute; incluidos ingresando en forma peri&oacute;dica al apartado de legales de MUEBLES.uy.

2. REGISTRACI&Oacute;N DE LOS USUARIOS. 
Para valerse de los servicios prestados en el Sitio, basta la sola aceptaci&oacute;n de estos T&eacute;rminos y Condiciones. Sin embargo para la utilizaci&oacute;n de algunos servicios o el acceso a ciertos contenidos, podr&aacute; establecerse como requisito, el previo registro del usuario. Dicho registro tendr&aacute; por finalidad establecer la identidad e información de contacto del usuario.
Toda vez que para la registraci&oacute;n de un usuario le sea requerida informaci&oacute;n, la misma deber&aacute; ser fidedigna, y poseer&aacute; el car&aacute;cter de declaraci&oacute;n jurada. Cuando la informaci&oacute;n suministrada no atienda a las circunstancias reales de quien la brinda, se considerar&aacute; a tal usuario incurso en incumplimiento de estos T&eacute;rminos y Condiciones, siendo responsable por todos los perjuicios que derivaren para MUEBLES.uy o terceros como consecuencia de tal falta de veracidad o exactitud.
Ser&aacute; responsabilidad de cada usuario mantener actualizada su informaci&oacute;n personal asentada en el registro conforme resulte necesario, debiendo comunicar a MUEBLES.uy toda vez que se produzcan cambios en relaci&oacute;n a la misma.
MUEBLES.uy podr&aacute; rechazar cualquier solicitud de registraci&oacute;n o, cancelar una registraci&oacute;n previamente aceptada, sin que tal decisi&oacute;n deba ser justificada, y sin que ello genere derecho alguno en beneficio del Usuario.

3. NOTIFICACIONES Y COMUNICACIONES 
A los fines que los usuarios puedan tomar contacto con MUEBLES.uy, se considerar&aacute;n v&aacute;lidas las comunicaciones dirigidas a info@muebles.uy
Las notificaciones y comunicaciones cursadas por MUEBLES.uy a la casilla de correo electr&oacute;nico que surja como direcci&oacute;n de correo del usuario o remitente se considerar&aacute;n eficaces y plenamente v&aacute;lidas. Asimismo, se considerar&aacute;n eficaces las comunicaciones que consistan en avisos y mensajes insertos en el Sitio, o que se env&iacute;en durante la prestaci&oacute;n de un servicio, que tengan por finalidad informar a los usuarios sobre determinada circunstancia.

 4. Responsabilidades, facultades de dirección y control sobre los servicios y contenidos 
MUEBLES.uy se reserva el derecho, a su exclusiva discreción, de interrumpir, modificar, alterar el contenido y/o acceso del Sitio, así como también de excluir al usuario y/o sus datos ingresados, en cualquier momento y sin previo aviso, ya sea por motivos técnicos, de seguridad, de control, de mantenimiento, por fallos de suministro eléctrico o por cualquier otra causa.
MUEBLES.uy no se responsabiliza por las pérdidas o daños sufridos por el usuario, que surgieran o fueran el resultado de la instalación de los archivos informáticos descargados desde el Sitio por parte de los usuarios, incluyendo la pérdida o alteración de datos.
MUEBLES.uy no garantiza ni asume ningún tipo de responsabilidad por los daños y perjuicios sufridos por el acceso al Sitio por parte de terceros a través de conexiones, vínculos o links de los sitios enlazados, ni tampoco por enlaces con otros sitios que el usuario o visitante pueda realizar desde el Sitio. MUEBLES.uy tampoco será responsable por los daños y perjuicios que puedan deberse a la presencia de virus o a la presencia de otros elementos lesivos en los contenidos del Sitio, que puedan producir  alteración en los sistemas informáticos así como en los documentos o sistemas almacenados en los mismos.
El Sitio funciona "TAL CUAL ES", "CON TODOS SUS FALLOS" y según su "DISPONIBILIDAD" por lo que MUEBLES.uy no otorga garantía de ningún tipo y es el Usuario quien utiliza el Sitio bajo su propio riesgo.
Toda información personal proporcionada por los usuarios será utilizada conforme los términos de la Política de Privacidad del Sitio www.muebles.uy, la que pueden ser consultadas por los Usuarios en todo momento.

5. UTILIZACIÓN DE LOS SERVICIOS Y CONTENIDOS BRINDADOS POR EL SITIO 
El usuario del Sitio se obliga a usar el Sitio de conformidad con estos Términos y Condiciones, en forma diligente, correcta y lícita, y conforme con la moral y las buenas costumbres. El usuario o visitante responderá por los daños y perjuicios de toda naturaleza que MUEBLES.uy pueda sufrir, directa o indirectamente, como consecuencia del incumplimiento de cualquiera de las obligaciones derivadas de estos Términos y Condiciones, de los términos y condiciones de algún servicio en particular que se incluya en el Sitio o de la ley aplicable en relación con la utilización del Sitio.

 6. PROPIEDAD INTELECTUAL DE MUEBLES.uy 
Todo el contenido del Sitio, incluyendo pero no limitando a textos, gráficos, fotografías, logotipos, marcas, imágenes, bases de datos, así como el diseño gráfico, código fuente y software, son de exclusiva propiedad de MUEBLES.uy, y están sujetos a derechos de propiedad intelectual e industrial protegidos por la legislación nacional e internacional.
Queda estrictamente prohibido la utilización de todos los elementos objeto de propiedad intelectual e industrial con cualquier fin, incluyendo su reproducción, copia, distribución, modificación, alteración en forma total o parcial.

7. INTERPRETACION 
Si cualquier disposición de los Términos y Condiciones del Sitio se tuviera por nula, inválida, inoperante o inoponible, ninguna otra disposición se verá afectada como resultado de ello, y consecuentemente, las disposiciones restantes permanecerán en plena vigencia.

8. LEGISLACIÓN Y JURISDICCIÓN APLICABLES 
Los Términos y Condiciones del Sitio se regirán e interpretarán de acuerdo con las leyes de la República Oriental del Uruguay. Los jueces en lo civil y comercial de la Ciudad de Montevideo serán los tribunales exclusivamente competentes para entender en todas las controversias legales emergentes de o relacionadas con el Sitio.

POLÍTICA DE PRIVACIDAD 
Las presentes Declaraciones tienen por objeto poner en conocimiento de los usuarios los alcances de la protección integral de los datos personales asentados en archivos; registros; bancos o bases de datos; u otros medios técnicos de tratamiento de datos, en pos de un adecuado respeto al derecho a la intimidad de las personas, así como también al libre acceso a la información que sobre las mismas pueda eventualmente registrarse.
En este sentido La empresa MUEBLES.uy (en adelante, "MUEBLES.uy"),a la luz del objeto propuesto, garantiza que los datos recabados a través del sitio www.muebles.uy (en adelante "el Sitio"), serán tratados siempre de modo tal que quede resguardada la finalidad tuitiva que la legislación vigente referida a la protección de los datos personales consagra.
La confidencialidad de las comunicaciones privadas entre MUEBLES.uy y  los usuarios implicará el mantenimiento de la información en archivos, bancos o bases de datos, de modo tal que el acceso por parte de usuarios o de simples terceros que no se encuentren autorizados a tal efecto, se encuentre restringido.
Por regla general, cuando para utilizar un servicio del Sitio o acceder a cierto contenido se solicite algún Dato Personal, la entrega del mismo no será obligatoria, con excepción de aquellos casos donde específicamente se indicara que es un dato requerido para la prestación de un servicio que brinda el Sitio, en cuyo caso el usuario podrá optar libremente por no participar y/o intervenir del mismo.
La recolección y tratamiento de datos de carácter personal tiene por finalidad la prestación, gestión, administración, actualización y mejora de los de los servicios y contenidos puestos a disposición de los usuarios por parte de MUEBLES.uy.Asimismo los datos podrán ser utilizados para la participación de sorteos, promociones, ofertas, así como para el envío de comunicaciones a los usuarios, en lo referente a los servicios y contenidos brindados por MUEBLES.uy.
En los casos en que el usuario brinde a MUEBLES.uy su información personal, este reconoce estar aceptando y prestando su consentimiento libre, expreso e informado para que dicha información personal sea utilizada con las finalidades mencionadas en el párrafo anterior, y todas aquellas que puedan estar relacionadas con dichas finalidades, y autoriza a que la misma sea tratada, almacenada y/o recopilada. Asimismo, el usuario acepta y presta su consentimiento en forma libre y expresa, en un total de acuerdo con los términos de la presente.
MUEBLES.uy manifiesta que no cede ni transfiere información personal de los usuarios a ningún tercero. No obstante, algunos servicios que MUEBLES.uy pueda brindar a través del Sitio www.muebles.uy, como sorteos, promociones, etc., pueden requerir que MUEBLES.uy se encuentre en la necesidad de compartir cierta información con terceros a efectos de dar cumplimiento con las prestaciones correspondientes (ej.: adjudicación y entrega de premios, etc.). En esos casos, MUEBLES.uy deberá necesariamente ceder la información del usuario solo a los efectos del cumplimiento del objeto para el cual fue solicitado el dato, para lo cual el usuario que acepte participar de esos servicios presta su consentimiento a tal fin.
A su vez, y como consecuencia de la garantía de los derechos amparados, se expresa también como finalidad, la de permitir en todo momento el acceso a la información por parte de los titulares de los datos registrados. De este modo, el usuario podrá ejercitar los derechos de acceso, rectificación o cancelación de datos y oposición, que más adelante se mencionarán.
El ejercicio de dichos derechos podrá ser efectivizado por cada usuario mediante correo electrónico dirigido a centro@muebles.uy.
Efectuado el ingreso de los datos por los usuarios, MUEBLES.uy procederá a la rectificación, supresión o actualización de los datos personales del afectado, cuando ello fuere procedente.
La supresión de algún/nos datos no procederá cuando pudiese causar perjuicios a derechos o intereses legítimos de terceros, o cuando existiera una obligación legal de conservar los datos.
Eventualmente el Sitio puede utilizar cookies, que se instalaran en la computadora del usuario cuando este navegue por el Sitio. Las cookies tienen por finalidad facilitar la navegación por el Sitio al usuario, y proporcionar al Sitio, información que le ayudara a mejorar los sus servicios y contenidos. En ningún caso las cookies utilizadas por el Sitio proporcionarán información de carácter personal de usuario, quien en relación a las mismas mantendrá pleno anonimato, aun frente al Sitio, dado que tampoco suministran información tendiente a la individualización del usuario.
Es intención de MUEBLES.uy es poner de resalto que para navegar por el Sitio, no resulta necesario que el usuario permita la instalación de las cookies enviadas por el Sitio. Ello solo podrá requerirse en relación a ciertos servicios y/o contenidos.
El servidor puede contener enlaces o referencias a otros servidores web que se encuentra fuera de nuestro control. Por favor comprenda que no tenemos control sobre tales servidores web y nuestra Política de Privacidad no aplica en dichos servidores. Le instamos a leer las políticas de privacidad y los términos y condiciones de uso de tales servidores Web a los cuales ingresa.
MUEBLES.u , en relación a sus archivos, bases o bancos de datos que contengan información personal de los usuarios, adopta todas las medidas de seguridad lógica y física exigidas por las reglamentaciones, y las que resultan de la adecuada prudencia y diligencia en la protección de terceros que han depositado su confianza en el Sitio y/o en MUEBLES.uy.
El usuario responderá, en cualquier caso, de la veracidad de los datos facilitados, reservándose el derecho de excluir a todo usuario que haya facilitado datos falsos, sin perjuicio de iniciar las acciones legales que correspondieren.
MUEBLES.uy se reserva el derecho de brindar información a organismos de control de fronteras, autoridades de inmigración, aduanas de cualquier país y/u otras autoridades administrativas o judiciales que así lo requieran y cuando medien razones fundadas relativas a la seguridad pública, la defensa nacional o la salud pública.
                        </textarea>
                    </div>
                </div>
            </div>

            <input type="submit" id="submit" name="submit" value="Enviar" class="mbtn btn pi-btn-base pi-uppercase" style="width:100%;font-weight: 700;margin-top:5px; display: none;">
            <div class="form-group">           
                <input type="button" value="Enviar" name="btn_terminos" id="btn_terminos" class="btn pi-btn-base pi-uppercase" style="width:100%;font-weight: 700;margin-top:5px; display: block;"
                       onclick="if (this.parentNode.nextSibling.childNodes[0].style.display != '') {
                                   this.parentNode.nextSibling.childNodes[0].style.display = ''; this.value = '↑ Acepta los terminos.'; } else {
                                   this.parentNode.nextSibling.childNodes[0].style.display = 'none';
                                   this.value = '↑ Acepta los terminos.';
                               }" />

            </div><div><div style="display: none;">
                </div>
            </div>
        </div>

</form>

</div>



        </div>
        
        
    </div>
    <?php include CLASSPATH . 'foot.php';?>
</body>
</html>