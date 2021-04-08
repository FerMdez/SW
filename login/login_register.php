<?php
    $isLogin = setLogin(true);

    if(array_key_exists('register',$_POST)){
        $isLogin = setLogin(false);
    }
    else if(array_key_exists('login',$_POST)){
        $isLogin = setLogin(true);
    }

    function setLogin($set){
       return $set;
    }
    

    $register = '<!-- Register -->
                <div class="column left">
                    <h2>Registro</h2>
                    <form method="post" action="">
                        <div class="row">
                            <fieldset id="datos_personales">
                                <legend>Datos personales</legend>
                                <div class="_name">
                                    <input type="text" name="name" id="name" value="" placeholder="Nombre" required/>
                                </div>
                                <div class="_email">
                                    <input type="email" name="email" id="email" value="" placeholder="Email" required/>
                                </div>
                                <div class="_passwd">
                                    <input type="password" name="pass" id="pass" value="" placeholder="Contraseña" required/>
                                </div>
                                <div class="_passwd">
                                    <input type="password" name="repass" id="repass" value="" placeholder="Repita la contraseña" required/>
                                </div>
                            </fieldset>
                            <div class="verify">
                                <input type="checkbox" id="checkbox" name="terms" required>
                                <label for="terms">Marque esta casilla para verificar que ha leído nuestros términos y condiciones del servicio.</label>
                            </div>
                            <div class="actions"> 
                                <input type="submit" id="submit" value="Registrarse" class="primary" />
                                <input type="reset" id="reset" value="Borrar" />       
                            </div>
                        </div>
                    </form>
                </div>
                <div class="column right">
                    <div class="code info">
                        <h2>¿Ya estás registrado?</h2>
                        <hr />
                        <p>Si dispones de una cuenta de usuario, no es necesario que rellenes este formulario nuevamente</p>
                        <p>Haz click en el botón para iniciar sesión.</p>
                        <form method="post">
                            <button type="submit" name="login" id="login">Inicia Sesión</button>
                        </form>
                    </div>
                </div>'."\n";

    $login = '<!-- Login -->
                <div class="column left">
                    <div class="code info">
                        <h2>¿No tienes una cuenta?</h2>
                        <hr />
                        <p>Para crear una cuenta de usuario es necesario haber rellenado el formulario de registro previamente</p>
                        <p>Haz click en el botón para registrate.</p>
                        <form method="post">
                            <button type="submit" name="register" id="register">Registrate</button>
                        </form>
                    </div>
                </div>
                <div class="column right">
                    <h2>Iniciar Sesión</h2>
                    <form method="post" action="validate.php">
                        <div class="row">
                            <fieldset id="datos_personales">
                                <legend>Datos personales</legend>
                                <div class="_name">
                                    <input type="text" name="name" id="name" value="" placeholder="Nombre" required/>
                                </div>
                                <!--
                                <div class="_email">
                                    <input type="email" name="email" id="email" value="" placeholder="Email" required/>
                                </div>
                                -->
                                <div class="_passwd">
                                    <input type="password" name="pass" id="pass" value="" placeholder="Contraseña" required/>
                                </div>
                            </fieldset>
                            <div class="actions"> 
                                <input type="submit" id="submit" value="Iniciar Sesión" class="primary" />
                                <input type="reset" id="reset" value="Borrar" />       
                            </div>
                        </div>
                    </form>
                </div>'."\n";
?>