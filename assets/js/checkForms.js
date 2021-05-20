/**
 * Práctica - Sistemas Web | Grupo D
 * CompluCine - FDI-cines
 */

//Expresión regular para comprobar que la contraseña tiene al menos 1 mayúscula y 1 número:
const regExprPass = /^(?=\w*\d)(?=\w*[A-Z])(?=\w*[a-z])\S{4,16}$/;

$(document).ready(function() {

    //Iconos para validar el usuario:
	$("#userValid").hide();
    $("#userInvalid").hide();
    $("#userWarning").hide();

    //Iconos para validar el email:
    $("#emailValid").hide();
    $("#emailInvalid").hide();

    //Iconos para validar el password:
    $("#passValid").hide();
    $("#passInvalid").hide();
    $("#passWarning").hide();
	
    //Comprueba que el nombre de usuario introducido para el login, exista.
	$("#name").change(function(){
		var url = "../assets/php/common/checkUser.php?user=" + $("#name").val();
		$.get(url, userLoginCheck);
    });

    //Comprueba que el nombre de usuario no esté registrado en la aplicación.
	$("#new_name").change(function(){
		var url = "../assets/php/common/checkUser.php?user=" + $("#new_name").val();
		$.get(url, userCheck);
    });

    //Comprueba que el email introducido no esté registrado en la aplicación.
    $("#new_email").change(function(){
        var url = "../assets/php/common/checkEmail.php?email=" + $("#new_email").val();
		$.get(url, emailCheck);
	});

    //Comprueba que la contraseña sea válida en base a los criterios de la aplicación.
    $("#new_pass").change(function(){
		const fieldPass = $("#new_pass");
        fieldPass[0].setCustomValidity("");
        const isPassValid = fieldPass[0].checkValidity();
		
        if(fieldPass.val().length < 4){
            $("#passValid").hide();
            $("#passInvalid").hide();
            $("#passWarning").show();
			fieldPass[0].setCustomValidity("La contraseña debe contener almenos 4 caracteres.");
        }
        else if (isPassValid && passCheck(fieldPass.val())) {
            $("#passValid").show();
            $("#passInvalid").hide();
            $("#passWarning").hide();
			fieldPass[0].setCustomValidity("");
		} else {
            $("#passValid").hide();
            $("#passInvalid").show();
            $("#passWarning").hide();
            fieldPass[0].setCustomValidity("La contraseña debe contener al menos 1 mayúscula y 1 número.");
		}

    });

    //Muestra si el nombre de usuario introducido para el login existe o no.
	function userLoginCheck(data, status) {
		const fieldLogin = $("#name");
        fieldLogin[0].setCustomValidity("");

		if(data === "!avaliable") {
			fieldLogin[0].setCustomValidity("");
		} else {
			fieldLogin[0].setCustomValidity("El nombre de usuario no está registrado.");
		}
	}

    //Muestra si el nombre de usuario introducido es válido o no.
	function userCheck(data, status) {
		const fieldUser = $("#new_name");
        fieldUser[0].setCustomValidity("");

        if(fieldUser.val().length < 3){
            $("#userValid").hide();
            $("#userInvalid").hide();
            $("#userWarning").show();
			fieldUser[0].setCustomValidity("El nombre de usuario debe tener almenos 3 caracteres.");
        }
		else if(data === "avaliable") {
			$("#userValid").show();
            $("#userInvalid").hide();
            $("#userWarning").hide();
			fieldUser[0].setCustomValidity("");
		} else {
			$("#userValid").hide();
            $("#userInvalid").show();
            $("#userWarning").hide();
			fieldUser[0].setCustomValidity("El nombre de usuario ya está registrado.");
		}
	}

    //Muestra si el email introducido es válido o no.
    function emailCheck(data, status) {
        const fieldEmail = $("#new_email");
		fieldEmail[0].setCustomValidity("");
		const isEmailValid = fieldEmail[0].checkValidity();

        if(!isEmailValid){
            $("#emailValid").hide();
            $("#emailInvalid").show();
        }
		else if (data === "avaliable") {
			$("#emailValid").show();
            $("#emailInvalid").hide();
			fieldEmail[0].setCustomValidity("");
		} else {			
			$("#emailValid").hide();
            $("#emailInvalid").show();
			fieldEmail[0].setCustomValidity("El email ya está registrado."); 
		}
		
	}

    //Devuelve true si la contraseña cumple los reuqisitos de seguridad, false en caso contrario.
    function passCheck(pass) {
		return regExprPass.test(pass) ? true : false;
	}
})