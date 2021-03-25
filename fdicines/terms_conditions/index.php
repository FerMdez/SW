<!DOCTYPE HTML>
<?php 
    session_start(); 
    require_once('../../assets/php/template.php');
    $template = new Template();    
?>
<!--
    Práctica 2 - Sistemas Web | Grupo D
    CompluCine - FDI-cines
-->
<html lang="es">
    <!-- Head -->
    <?php
        $template->print_head();
    ?>
    <body>
        <!-- Header -->
        <?php
            $template->print_header();
        ?>

        <!-- Main -->
        <div class="main">
            <div class="image"><img src="../../img/logo_trasparente.png" /></div>
            <!-- Terminos y Condiciones -->
            <h1>Términos y Condiciones</h1>
            <div class="header">
            <p>Todo usuario que desee acceder a la compra de entradas a través del servicio, primero debe leer y aceptar los Términos y Condiciones de compra que a continuación se detallan.
        Una vez que inicie la navegación a través de esta web el internauta adquiere la condición de USUARIO, y una vez que cumplimente los pasos establecidos para la compra de
        entradas de cine, tendrá la consideración de CLIENTE. En cumplimiento de lo dispuesto en el Real Decreto 1906/99 de diecisiete de diciembre, por la que se regula la
        contratación electrónica con condiciones generales, y de la Ley de Ordenación del Comercio Minorista (Ley 7/1996 de 15 de Enero, modificada por la Ley 47/2002 de 19 de
        Diciembre) en lo aplicable a lo dispuesto sobre las ventas a distancia en los artículos 38 y siguientes, FDI-Cines (en adelante la EMPRESA) informa:</p>
            <br>
            <p>Las presentes Condiciones Generales de Contratación suponen la regulación general de los servicios prestados por
        la EMPRESA a través del portal complucine.sytes.net, constituyendo el marco jurídico que desarrolla la relación contractual. La EMPRESA ofrece como intermediario el
        servicio de venta de entradas para cines, a través de la web https://complucine.sytes.net. Las presentes Condiciones Generales, están sujetas a lo dispuesto a la Ley 7/1988,
        de 13 de abril, sobre Condiciones Generales de Contratación, a la Ley 26/1984, de 19 de julio, General para la Defensa de Consumidores y Usuarios, al Real Decreto 1906/1999,
        de 17 de diciembre de 1999, por el que se regula la Contratación Telefónica o Electrónica con condiciones generales, la Ley Orgánica 15/1999, de 13 de diciembre, de Protección
        de Datos de Carácter Personal, la Ley 7/1996, de 15 de enero de Ordenación del Comercio Minorista, y a la Ley 34/2002 de 11 de julio, de Servicios de la Sociedad de la
        Información y de Comercio Electrónico. Los servicios ofrecidos por complucine.sytes.net podrán ser contratados por cualesquiera usuarios que residan en España o en otro
        Estado miembro de la Unión Europea o del Espacio Económico Europeo y por aquellos usuarios que, residiendo en un Estado no perteneciente a la Unión Europea o al Espacio
        Económico Europea, les sea de aplicación la legislación española. Este documento es accesible en todo momento en la web de la EMPRESA y puede ser impreso y almacenado
        por el CLIENTE.</p>
            <br>
            <!-- Lista de Condiciones -->
            <ul>
                <li>
                    1. OBJETO DEL CONTRATO El contrato tiene por objeto regular las condiciones generales de prestación de los servicios ofrecidos por la EMPRESA a través de
                    complucine.sytes.net. Los servicios que la EMPRESA presta actualmente y que son objeto de este contrato son por un lado,los servicios de información, de acceso gratuito,
                    y por otro el servicio de venta de entradas para salas de cine. El servicio de venta de entradas de cine es de carácter oneroso, y el precio de cada entrada está determinado
                    en cada momento en la web. El acceso a la información concerniente a los apartados cartelera, cines, estrenos y noticias es libre, no sujeto a pago alguno.
                </li>
                <br>
                <li>
                    2. IDENTIFICACIÓN DE LAS PARTES CONTRATANTES. Las presentes condiciones generales de contratación del servicio ofrecido por la EMPRESA son suscritas, de una parte,
                    por la empresa identificada en este documento. Y, de otra parte, por el CLIENTE, cuyos datos introducidos para
                    realizar la compra de entradas o para realizar alguna sugerencia, a través del formulario establecido al efecto, son los que han sido consignados por él mismo.
                    Todos los datos incluidos en él han sido introducidos directamente por el cliente, por lo que la responsabilidad sobre la autenticidad de los mismos corresponde, directa
                    y exclusivamente, al CLIENTE. Para tener acceso al servicio de compra de entradas del portal, se requiere la cumplimentación de todos los datos no marcados como opcionales
                    solicitados para realizar la compra.
                </li>
                <br>
                <li>
                    3. OBLIGACIONES RELATIVAS AL PROCEDIMIENTO DE COMPRA El CLIENTE es el único responsable de la veracidad de los datos introducidos por él mismo en el procedimiento
                    de compra, y acepta la obligación de facilitar datos veraces, exactos y completos. Si el CLIENTE incumple esta obligación, quedará bajo su responsabilidad el responder por
                    los posibles daños y perjuicios producidos a la EMPRESA o a un tercero. 4. CONDICIONES DEL SERVICIO Las presentes condiciones son de aplicación al servicio de venta de
                    entradas de cine ofrecido por la EMPRESA a través de la web complucine.sytes.net. Las condiciones comerciales de este servicio y las ofertas que eventualmente puedan
                    llevarse a cabo por la EMPRESA siempre aparecen en la mencionada página web por lo que pueden ser consultadas, archivadas o impresas. La EMPRESA se reserva el derecho de
                    modificar en cualquier momento las presentes Condiciones Generales de Uso así como cualesquiera otras condiciones generales o particulares, reglamentos de uso o avisos que
                    resulten de aplicación. La EMPRESA podrá modificar las Condiciones Generales notificándolo a los CLIENTES con antelación suficiente, con el fin de mejorar los servicios
                    y productos ofrecidos a través de complucine.sytes.net. Mediante la modificación de las Condiciones Generales expuestas en la página Web de www.compraentradas.com, se
                    entenderá por cumplido dicho deber de notificación. En todo caso, antes de utilizar los servicios o contratar productos, se pondrán consultar las Condiciones General es.
                    Asimismo se reserva el derecho a modificar en cualquier momento la presentación, configuración y localización del Sitio Web, así como los contenidos y las condiciones
                    requeridas para utilizar los mismos. El CLIENTE formalizará su compra de entradas de cine mediante el cumplimiento de todas las fases establecidas en el apartado COMPRA
                    DIRECTA y su envío telemático. 5. USO DEL SERVICIO Y RESPONSABILIDADES La EMPRESA no será responsable de los retrasos o fallos que se produjeran en el acceso,
                    funcionamiento y operatividad de la web, o en sus servicios y/o contenidos, así como tampoco de las interrupciones, suspensiones o el mal funcionamiento de la misma,
                    cuando tuvieren su origen en averías producidas por catástrofes naturales o situaciones de fuerza mayor , o de urgencia extrema, tales como huelgas, ataques o intrusiones
                    informáticas o cualquier otra situación de fuerza mayor o causa fortuita, así como por errores en las redes telemáticas de transferencia de datos. La EMPRESA no se hace
                    responsable de la fiabilidad, veracidad y exactitud de los contenidos ofrecidos en su web. El CLIENTE se compromete a cumplir con lo establecido en el AVISO LEGAL publicado
                    por la EMPRESA en la web complucine.sytes.net en cada momento. El CLIENTE reconoce y acepta que el acceso y uso del sitio web complucine.sytes.net y de los contenidos
                    incluidos en el mismo tiene lugar de forma libre y conscientemente, bajo su exclusiva responsabilidad. El CLIENTE se compromete a hacer un uso adecuado y lícito del Sitio
                    Web y de los contenidos, de conformidad con la legislación aplicable, las presentes Condiciones Generales de Uso, la moral y buenas costumbres generalmente aceptadas y
                    el orden público.
                </li>
                <br>
                <li>
                    4. PROCEDIMIENTO DE COMPRA A través del apartado COMPRA DIRECTA el CLIENTE puede adquirir la/s entrada/s de cine telemáticamente. Los pasos a seguir son los
                    siguientes:
                    <ul>
                        <li>
                        4.1. OPCIONES PARA LA COMPRA Al pulsar sobre cualquier opción del sitio web, se cargarán las páginas que le permitirán, a través de una serie de menús,
                    seleccionar la película, cine, día y sesión a la que desea acudir. Cada menú se genera en función de la opción seleccionada en el menú anterior. Una vez completada la
                    selección podrá acceder al patio de butacas del cine y seleccionar las localidades que más le gusten.
                        </li>
                        <li>
                        4.2. SOLICITUD DE BUTACAS En el patio de butacas, las butacas en color verde representan los asientos que están disponibles. En las butacas ocupadas aparecerá el dibujo de una persona sentada. Para seleccionar
                    las localidades deseadas, pulse con el ratón sobre ellas; a medida que las pulse se pondrán de color blanco. Si se equivoca vuelva a pulsar sobre la butaca y volverá a
                    ponerse de color verde. Cuando termine de seleccionar las localidades pulse sobre el botón Solicitar y entrará en una página en la que se le pedirán los datos de la tarjeta
                    con la que desea pagar las entradas. NOTA: Las localidades han de seleccionarse juntas y en la misma fila. El máximo de localidades que se pueden solicitar es de 10.
                        </li>
                        <li>
                        4.3. ACEPTACIÓN DE LA PROPUESTA DEL CINE Una vez solicitadas las butacas, el cine respondera si aun siguen estando disponibles, en ese caso se procede al pago.
                        </li>
                        <li>
                        4.4. DATOS PARA EL PAGO En esta página debe introducirse un número de tarjeta y su caducidad; con la que abonar el importe de las entradas. Asimismo, también aparece un campo donde
                    opcionalmente-, se puede introducir un correo electrónico de contacto el cual es útil para informar al usuario en caso de que se suspendiera alguna sesión, se realizara
                    una reubicacion, etc. Tras introducir los datos para el pago, pulse sobre el botón Continuar.
                        </li>
                        <li>
                        4.5. CONFIRMACIÓN DE LA VENTA Si el proceso de compra se completa correctamente, le aparecerá una página de confirmación en la que se reflejan las características de las localidades adquiridas, así como un numero de referencia. El número de referencia
                    identifica su compra de forma única y será necesario en caso de que usted desee realizar alguna consulta. Dado que es un número de bastantes cifras si lo desea puede usted
                    sacar una copia en papel de dicha página pulsando sobre el botón imprimir o descargándolo en su ordenador.
                        </li>
                        <li>
                        4.6. DENEGACIÓN DE LA VENTA Por diversas razones como son: falta de comunicación con la entidad emisora de su tarjeta, pérdida temporal de la comunicación con el cine, etc.; puede que al sistema le resulte imposible realizar la compra.
                    En tal caso, le aparecerá una página indicándole tal circunstancia así como una referencia. Si desea realizar alguna consulta, utilice dicho número de referencia para que
                    podamos atenderle.
                        </li>
                        <li>
                        4.7. RECOGIDA DE ENTRADAS Cerca de las taquillas del cine, el CLIENTE encontrará un buzón instalado a tal efecto, en el que puede introducir la tarjeta
                    con la que realizó la compra y le emitirá sus entradas. Si tuviera alguna dificultad en localizar el buzón puede consultar al personal del cine. Si el CLIENTE tuviera algún
                    inconveniente a la hora de recoger las entradas, deberá asegurarse de haber introducido la tarjeta en la posición correcta, los buzones tienen un dibujo que muestra como.
                    Si por alguna razón el buzón no le dispensa las entradas, como por ejemplo que se haya quedado sin papel, deberá acudir a las taquillas con la tarjeta.
                        </li>
                    </ul>
                </li>
                <br>
                <li>
                    5. IDIOMA La información y contenidos ofrecidos por la EMPRESA a través de la web complucine.sytes.net se ofrecen en idioma español. La EMPRESA no se hace
                    responsable de los daños o perjuicios que pudieran ocasionar al CLIENTE por la no comprensión de los mismos.
                </li>
                <br>
                <li>
                    6. NORMAS RELATIVAS A LA FORMACIÓN Y VALIDEZ DEL CONTRATO EL CLIENTE entiende que la información contenida en la web, de información general sobre cartelera,
                    estrenos, cines, noticias, IVA, comisiones, así como las condiciones generales de contratación y perfeccionamiento del contrato, son bastantes y suficientes para la exclusión
                    de error en la formación del consentimiento. Las presentes condiciones generales de contratación, pasarán a formar parte del contrato en el momento de aceptación por parte
                    del CLIENTE, manifestada por medio de la cumplimentación y envío de los datos de compra introducidos en el apartado COMPRA DIRECTA. 9. VALIDEZ DEL PROCEDIMIENTO DE COMPRA
                    COMO PRUEBA DE ACEPTACIÓN Ambas partes declaran expresamente que la aceptación de la oferta de servicio de la EMPRESA por el CLIENTE se lleva a cabo a través del seguimiento
                    del procedimiento de compra descrito en el apartado COMPRA DIRECTA. El hecho de cumplimentar telemáticamente todos los pasos descritos para el proceso de compra de la/s
                    entrada/s por el CLIENTE supone la aceptación integra y expresa de las presentes condiciones generales. 10. PERFECCIÓN DEL CONTRATO El contrato quedará perfeccionado desde
                    la fecha en que el CLIENTE manifieste su conformidad con las presentes condiciones o, en su caso, las publicadas en el momento de realizar la compra, mediante la aportación
                    de los datos solicitados en el apartado DATOS PARA EL PAGO, de la sección COMPRA DIRECTA, y una vez que el CLIENTE confirme la compra efectuada.
                </li>
                <br>
                <li>
                    7. PAGO La EMPRESA cobrará al CLIENTE por la prestación del servicio las tarifas vigentes en cada momento en la web y que aparecerán una vez seleccionada la película,
                    cine, día y sesión, apartado éste último, en el que aparecerá el precio correspondiente a la selección efectuada y los impuestos aplicables. Una vez seleccionada/s la/s
                    butaca/s, se abrirá la sección correspondiente al pago, con la petición de introducción de los datos de la tarjeta de crédito, en la cual se detallará el precio y la comisión
                    correspondiente a cada butaca.
                </li>
                <br>
                <li>
                    8. DERECHO DE DESISTIMIENTO El CLIENTE debe asegurarse fehacientemente antes de tramitar la reserva de la exactitud y adecuación de los datos
                    introducidos, ya que no es posible la devolución de las entradas adquiridas una vez realizada la compra. No poder asistir al espectáculo o cometer un error al adquirir las
                    entradas no son motivos que permitan su devolución. Sólo podrán anularse entradas por posibles incidencias técnicas u operativas, imputables a la EMPRESA. El usuario no podrá
                    ejercitar el derecho de desistimiento o resolución previsto en el artículo 44 de la ley 47/2002 de 19 de diciembre de reforma de la Ley 7/1996, de 15 de enero, de Ordenación
                    del Comercio Minorista, al estar excluido en el artículo 45 b). Tampoco podrá ser ejercido por el usuario el derecho de Resolución previsto en el artículo 4 del R.D.
                    1906/19999, de 17 de diciembre, al estar excluido el ejercicio del mismo en el artículo 4.5. No obstante lo anterior, cuando el importe de una compra hubiese sido cargado
                    fraudulenta o indebidamente, utilizando el número de una tarjeta de pago, el titular de la misma podrá solicitar la anulación del cargo a la EMPRESA siempre y cuando se
                    acredite la previa presentación de denuncia por estos hechos. La devolución del importe de las mismas se realizará mediante reclamación por escrito, a la que deberán
                    acompañarse los documentos (denuncia) que acredite n la pérdida o robo de la tarjeta con la que se efectuó el pago. Sin embargo, si la compra hubiese sido efectivamente
                    realizada por el titular de la tarjeta y la exigencia de devolución no fuera consecuencia de haberse ejercido el derecho de desistimiento o de resolución reconocido en el
                    artículo 44 y, por tanto, hubiese exigido indebidamente la anulación del correspondiente cargo, aquel quedará obligado frente al vendedor al resarcimiento de los daños y
                    perjuicios ocasionados como consecuencia de dicha anulación. La EMPRESA pretende facilitar tanto a promotores como al público la adquisición de dichas entradas pero en ningún
                    momento la EMPRESA es la entidad promotora del espectáculo.
                </li>
                <br>
                <li>
                    9. RECLAMACIONES Para cualquier aclaración sobre las presentes condición es generales o para realizar cualquier
                    reclamación relativa a su compra, el CLIENTE tiene a su disposición las direcciones especificadas al principio de este documento.
                </li>
                <br>
                <li>
                    10. DURACIÓN Y TERMINACIÓN La prestación del servicio de la web complucine.sytes.net tiene una duración indefinida. No obstante,la EMPRESA está autorizada para
                    dar por terminada o suspender la prestación del servicio en cualquier momento, sin perjuicio de lo que se hubiere dispuesto al respecto en las correspondientes condiciones
                    generales. Cuando ello sea razonablemente posible, la EMPRESA advertirá previamente la terminación o suspensión de la prestación del servicio.
                </li>
                <br>
                <li>
                    11. PROPIEDAD INTELECTUAL E INDUSTRIAL El CLIENTE acepta que todos los derechos de propiedad industrial e intelectual sobre los contenidos y cualesquiera otros
                    elementos insertados en la web complucine.sytes.net pertenecen a la EMPRESA. La EMPRESA es titular de los elementos que integran el diseño gráfico de su página web, los
                    menús, botones de navegación, el código HTML, los textos, imágenes, texturas, gráficos y cualquier otro contenido de la página web o, en cualquier caso, dispone de la
                    correspondiente autorización para la utilización de dichos elementos. El contenido de la web no podrá ser reproducido ni en todo ni en parte, ni transmitido, ni registrado
                    por ningún sistema de recuperación de información, en ninguna forma ni en ningún medio, a menos que se cuente con la autorización previa, por escrito, de la citada Entidad.
                    Asimismo queda prohibido suprimir, eludir o manipular el copyright y demás datos identificativos de los derechos de la EMPRESA, así como los dispositivos técnicos de
                    protección, o cualquiera mecanismos de información que pudieren contener los contenidos.
                </li>
                <br>
                <li>
                    12. PROTECCIÓN DE DATOS DE CARÁCTER PERSONAL La EMPRESA ha adoptado las medidas y niveles de seguridad de protección de los datos personales exigidos por la Ley
                    Orgánica 15/1999, de 13 de diciembre, de Protección de Datos de Carácter Personal y sus reglamentos de desarrollo. Los datos personales recabados a través de
                    complucine.sytes.net son objeto de tratamiento automatizado y se incorporan a un fichero titularidad de la EMPRESA, que es a su vez la responsable del mencionado fichero.
                    La cumplimentación de los datos correspondientes a la compra de entradas o del formulario de sugerencias en el sitio web www.cinentradas.com implica el consentimiento expreso
                    del CLIENTE a la inclusión de sus datos de carácter personal en el referido fichero automatizado de la EMPRESA. El Cliente titular de los datos puede ejercitar gratuitamente
                    sus derechos de acceso, rectificación, cancelación y oposición con arreglo a lo previsto en la Ley Orgánica 15/1999, de 13 de diciembre, de Protección de Datos de Carácter
                    Personal y demás normativa aplicable al efecto, mediante el envio de un correo electrónico a la dirección MARKETING@complucine.sytes.net, o bien mediante carta dirigida a la
                    dirección de la EMPRESA especificada al inicio de este documento. Ya sea por correo electrónico o postal, debera constar claramente la
                    identidad del titular de los datos de forma que permita reconocer la identidad del CLIENTE que ejercita cualquiera de los anteriores derechos, debiendo indicar asimismo la
                    dirección a la que EMPRESA deberá hacer llegar la respuesta.El citado fichero figura inscrito en el Registro General de la Agencia Española de Protección de Datos. La
                    finalidad de la recogida de datos no es otra que la de poder ofrecer al CLIENTE los servicios de venta de entradas, así como la de atender las sugerencias realizadas por
                    los mismos.
                </li>
                <br>
                <li>
                    13. NULIDAD PARCIAL Si cualquier parte de estas condiciones de servicio fuera contraria a Derecho y, por tanto, inválida, ello no afectará a las otras disposiciones
                    conformes a Derecho. Las partes se comprometen a renegociar aquellas partes de las condiciones de servicio que resultaran nulas y a incorporarlas al resto de las condiciones
                    de servicio.
                </li>
                <br>
                <li>
                    14. LEY APLICABLE Y JURISDICCIÓN COMPETENTE. El CLIENTE se somete, con renuncia expresa a cualquier otro fuero, a los juzgados y tribunales de la ciudad de
                    Madrid (España). Estas Condiciones Generales se rigen por la ley española. Ambas partes reconocen que la legislación aplicable al presente contrato, y a todas las relaciones
                    jurídicas dimanantes del mismo, será la española, por expresa aplicación de lo dispuesto en el artículo 1.262 del Código Civil, en relación a lo dispuesto en el Capítulo IV,
                    del Título Preliminar del mismo cuerpo legal.
                </li>
                <br>
            </ul>
            </div>
        </div>

        <!-- Footer -->
        <?php
            $template->print_footer();
        ?>

    </body>

</html>
