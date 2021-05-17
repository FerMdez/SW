<?php 
    //General Config File:
    require_once('../../assets/php/config.php');

    $content = '<hr />
                <section id="members_table"> 
                    <table>
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><a href="#MEP">Marco Expósito Pérez</a></td>
                                <td><a href="mailto:marcoexp@ucm.es">marcoexp@ucm.es</a></td>
                            </tr>
                            <tr>
                                <td><a href="#FMT">Fernando Méndez Torrubiano</a></td>
                                <td><a href="mailto:fernmend@ucm.es">fernmend@ucm.es</a></td>
                            </tr>
                            <tr>
                                <td><a href="#DMG">Daniel Muñoz García</a></td>
                                <td><a href="mailto:danimu03@ucm.es">danimu03@ucm.es</a></td>
                            </tr>
                            <tr>
                                <td><a href="#IMT">Ioan Marian Tulai</a></td>
                                <td><a href="mailto:ioantula@ucm.es">ioantula@ucm.es</a></td>
                            </tr>
                            <tr>
                                <td><a href="#ORP">Óscar Ruiz de Pedro</a></td>
                                <td><a href="mailto:oscarrui@ucm.es">oscarrui@ucm.es</a></td>
                            </tr>
                            <tr>
                                <td><a href="#ARN">Adrian Real del Noval</a></td>
                                <td><a href="mailto:adrireal@ucm.es">adrireal@ucm.es</td>
                            </tr>
                        </tbody>
                    </table>
                </section>';
    
    //Specific page content:
    $section = '<!-- Members -->
                <section id="members">
                    <div class="row">
                        <div class="column side">
                            <!-- Marco Esposito -->
                            <section id="MEP">
                                <div class="zoom">
                                    <div class="code">
                                        <img src="../../img/us/mep.jpg" />
                                        <p>~ Marco Expósito Pérez (marcoexp@ucm.es)</p>
                                        <div class="blockquote bio">  
                                            <p>Aficionado a todo tipo de videojuegos, principalmente la saga Zelda. Tambien me gusta leer tanto literatura fantastica como mangas y veo anime asiduamente.</p>
                                            <p>En verano suelo participar en campeonatos de pesca subacuatica y tambien me gusta bastante jugar al futbol federado, aunque hace un tiempillo ya que no hago.</p>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                        <div class="column middle">
                            <!-- Fernando Méndez -->
                            <section id="FMT">
                                <div class="zoom">
                                    <div class="code">
                                        <img src="../../img/us/fmt.jpg" />
                                        <p>~ Fernando Méndez (fernmend@ucm.es)</p>
                                        <div class="blockquote bio">  
                                            <p>Estudiante de Ingeniería de Computadores en la Universidad Complutense de Madrid.</p>
                                            <p>Presidente de la asociación Diskobolo. Colaborador de la Oficina de Sotfware Libre de la UCM y coordinador del grupo de Hacking Ético de la FDI.</p>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                        <div class="column side">
                            <!-- Daniel Muñoz -->
                            <section id="DMG">
                                <div class="zoom">
                                    <div class="code">
                                        <img src="../../img/us/dmg.jpg" />
                                        <p>~ Daniel Muñoz García (danimu03@ucm.es)</p>
                                        <div class="blockquote bio">  
                                            <p>Estudiante del grado en ingeniería informática en la Universidad Complutense de Madrid. Aficionado a la ciberseguridad y las nuevas tecnologías.</p>
                                            <p>Especializado en el diseño y gestión de bases de datos, tanto SQL como noSQL, y su desarrollo con distintos lenguajes como MongoDB o MySQL.</p>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                    <div class="row">
                        <div class="column side">
                            <!-- Ioan Marian -->
                            <section id="IMT">
                                <div class="zoom">
                                    <div class="code">
                                        <img src="../../img/us/imt.jpg" />
                                        <p>~ Ioan Marian Tulai (ioantula@ucm.es)</p>
                                        <div class="blockquote bio">  
                                            <p>Estudiante con mucha ilusion y ganas de trabajar  especialista en hardware.</p>
                                            <p>Alta experiencia programando en C, gran interés en aprender nuevos lenguajes de programación y aficionado a dibujar.</p>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                        <div class="column middle">
                            <!-- Óscar Ruiz -->
                            <section id="ORP">
                                <div class="zoom">
                                    <div class="code">
                                        <img src="../../img/us/orp.jpg" />               
                                        <p>~ Óscar Ruiz de Pedro (oscarrui@ucm.es)</p>
                                        <div class="blockquote bio">  
                                            <p>Estudiante de ingeniería de computadores en la Universidad Complutense de Madrid.</p>
                                            <p>Altas capacidades de programación en bajo nivel, me gustaría aprender más sobre el ámbito de la robótica.</p>
                                            <p>Aficionado a todo tipo de videojuegos, impresión 3D, teatro y airsoft.</p>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                        <div class="column side">
                            <!-- Adrian Real -->
                            <section id="ARN">
                                <div class="zoom">
                                    <div class="code">
                                        <img src="../../img/us/arn.jpg" />
                                        <p>~ Adrian Real del Noval (adrireal@ucm.es)</p>
                                        <div class="blockquote bio">  
                                            <p>Estudiante de 3er año de Ingeniería de Computadores en la Universidad Complutense de Madrid.</p>
                                            <p>Las áreas en las que tiene mayor interés son la electrónica, las GPUs, y los sistemas empotrados.</p>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </section>';

    //General page content:
    require RAIZ_APP.'/HTMLtemplate.php';
?>
