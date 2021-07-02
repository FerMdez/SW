/**
 * Práctica - Sistemas Web | Grupo D
 * CompluCine - FDI-cines
 */

 //Expresión regular para validar nombre y apellidos:
const regExpr = /^([A-Za-zÁÉÍÓÚñáéíóúÑ]{0}?[A-Za-zÁÉÍÓÚñáéíóúÑ\']+[\s])+([A-Za-zÁÉÍÓÚñáéíóúÑ]{0}?[A-Za-zÁÉÍÓÚñáéíóúÑ\'])+[\s]?([A-Za-zÁÉÍÓÚñáéíóúÑ]{0}?[A-Za-zÁÉÍÓÚñáéíóúÑ\'])?$/g;

//Expresión regular para validar un código promocional:
const regExprCode = /^0?[xX]?[0-9a-fA-F]*$/;

//Fecha acutal:
const fecha = new Date();

$(document).ready(function() {

    //Iconos para validar el titular de la tarjeta:
	$("#cardNameValid").hide();
    $("#cardNameInvalid").hide();

    //Iconos para validar el número de tarjeta:
    $("#carNumberValid").hide();
    $("#cardNumerInvalid").hide();

    //Iconos para validar el CVV:
    $("#cvvValid").hide();
    $("#cvvInvalid").hide();

    //Iconos para validar el código promocional:
    $("#codeValid").hide();
    $("#codeInvalid").hide();

    //Iconos para validar el mes y año de expiración de la tarjeta:
    $("#dateValid").hide();
    $("#dateInvalid").hide();

	
    //Comprueba que el titular de la tarjeta es válido.
	$("#card-holder").change(function(){
        const cardHolder = $("#card-holder");
        cardHolder[0].setCustomValidity("");

		if(cardHolder.val().length > 5 && !holderCheck(cardHolder.val())){
            $("#cardNameValid").show();
            $("#cardNameInvalid").hide();
            cardHolder[0].setCustomValidity("");
        } else {
            $("#cardNameValid").hide();
            $("#cardNameInvalid").show();
            cardHolder[0].setCustomValidity("El titular de la tarjeta no es válido.");
        }
    });

    //Comprueba que el NÚMERO de la tarjeta es válido.
    $("#card-number-0").change(function(){
        const cardNumber0 = $("#card-number-0");
        cardNumber0[0].setCustomValidity("");

        if(cardNumber0.val().length === 4){
            $("#carNumberValid").show();
            $("#cardNumerInvalid").hide();
            cardNumber0[0].setCustomValidity("");
        } else {
            $("#carNumberValid").hide();
            $("#cardNumerInvalid").show();
            cardNumber0[0].setCustomValidity("El número de tarjeta debe tener 16 dígitos.");
        }
    });
    $("#card-number-1").change(function(){
        const cardNumber1 = $("#card-number-1");
        cardNumber1[0].setCustomValidity("");

        if(cardNumber1.val().length === 4){
            $("#carNumberValid").show();
            $("#cardNumerInvalid").hide();
            cardNumber1[0].setCustomValidity("");
        } else {
            $("#carNumberValid").hide();
            $("#cardNumerInvalid").show();
            cardNumber1[0].setCustomValidity("El número de tarjeta debe tener 16 dígitos.");
        }
    });
    $("#card-number-2").change(function(){
        const cardNumber2 = $("#card-number-2");
        cardNumber2[0].setCustomValidity("");

        if(cardNumber2.val().length === 4){
            $("#carNumberValid").show();
            $("#cardNumerInvalid").hide();
            cardNumber2[0].setCustomValidity("");
        } else {
            $("#carNumberValid").hide();
            $("#cardNumerInvalid").show();
            cardNumber2[0].setCustomValidity("El número de tarjeta debe tener 16 dígitos.");
        }
    });
    $("#card-number-3").change(function(){
        const cardNumber3 = $("#card-number-3");
        cardNumber3[0].setCustomValidity("");

        if(cardNumber3.val().length === 4){
            $("#carNumberValid").show();
            $("#cardNumerInvalid").hide();
            cardNumber3[0].setCustomValidity("");
        } else {
            $("#carNumberValid").hide();
            $("#cardNumerInvalid").show();
            cardNumber3[0].setCustomValidity("El número de tarjeta debe tener 16 dígitos.");
        }
    });


    //Comprueba que el CVV de la tarjeta es válido.
	$("#card-cvv").change(function(){
        const cvv = $("#card-cvv");
        cvv[0].setCustomValidity("");

		if(cvv.val().length === 3){
            $("#cvvValid").show();
            $("#cvvInvalid").hide();
            cvv[0].setCustomValidity("");
        } else {
            $("#cvvValid").hide();
            $("#cvvInvalid").show();
            cvv[0].setCustomValidity("El CVV debe tener 3 dígitos.");
        }
    });

    //Comprueba que el mes de expiración de la tarjeta es válido.
	$("#card-expiration-month").change(function(){
        const month = $("#card-expiration-month");
        month[0].setCustomValidity("");

		if(parseInt(month.val()) > parseInt(fecha.getMonth())){
            $("#dateValid").show();
            $("#dateInvalid").hide();
            month[0].setCustomValidity("");
        } else {
            $("#dateValid").hide();
            $("#dateInvalid").show();
            month[0].setCustomValidity("El mes de expiración no es válido.");
        }
    });
    //Comprueba que el mes de expiración de la tarjeta es válido.
	$("#card-expiration-year").change(function(){
        const year = $("#card-expiration-year");
        year[0].setCustomValidity("");

		if(parseInt(year.val()) >= parseInt(fecha.getFullYear())){
            $("#dateValid").show();
            $("#dateInvalid").hide();
            year[0].setCustomValidity("");
        } else {
            $("#dateValid").hide();
            $("#dateInvalid").show();
            year[0].setCustomValidity("El año de expiración no es válido.");
        }
    });

    //Comprueba el código promocional introducido:
    $("#code").change(function(){
        var url = "../assets/php/common/checkPromo.php?code=" + $("#code").val();
		$.get(url, codeCheck);
    });


    //Devuelve true si el nombre y apellidos del titular son válidos, false en caso contrario.
    function holderCheck(name) {
		return regExpr.test(name) ? true : false;
	}

    //Devuelve true si el código promocional es válido, false en caso contrario.
    function holderCheck(code) {
		return regExprCode.test(code) ? true : false;
	}

    //Muestra si el código promocional introducido existe o no.
	function codeCheck(data, status) {
        const code = $("#code");
        code[0].setCustomValidity("");

        if(code.val().length === 8 && data === "avaliable"){
            $("#codeValid").show();
            $("#codeInvalid").hide();
            code[0].setCustomValidity("");
        } else if(code.val().length > 0 && data === "!avaliable" ){
            $("#codeValid").hide();
            $("#codeInvalid").show();
            code[0].setCustomValidity("El código promocional no es válido.");
        } else if(code.val().length === 0 ){
            $("#codeValid").hide();
            $("#codeInvalid").hide();
            code[0].setCustomValidity("");
        }
	}
});