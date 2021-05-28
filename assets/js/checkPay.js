/**
 * Práctica - Sistemas Web | Grupo D
 * CompluCine - FDI-cines
 */

 //Expresión regular para validar nombre y apellidos:
const regExpr = /^([A-Za-zÁÉÍÓÚñáéíóúÑ]{0}?[A-Za-zÁÉÍÓÚñáéíóúÑ\']+[\s])+([A-Za-zÁÉÍÓÚñáéíóúÑ]{0}?[A-Za-zÁÉÍÓÚñáéíóúÑ\'])+[\s]?([A-Za-zÁÉÍÓÚñáéíóúÑ]{0}?[A-Za-zÁÉÍÓÚñáéíóúÑ\'])?$/g;

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

	
    //Comprueba que el titular de la tarjeta es válido.
	$("#card-holder").change(function(){
        const cardHolder = $("#card-holder");
        cardHolder[0].setCustomValidity("");

		if(cardHolder.val().length > 5 && holderCheck(cardHolder.val())){
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
        $("#card-number-1").change(function(){
            const cardNumber1 = $("#card-number-1");
            cardNumber1[0].setCustomValidity("");
            $("#card-number-2").change(function(){
                const cardNumber2 = $("#card-number-2");
                cardNumber2[0].setCustomValidity("");
                $("#card-number-3").change(function(){                  
                    const cardNumber3 = $("#card-number-3");
                    cardNumber3[0].setCustomValidity("");

                    if( (cardNumber0.val().length + cardNumber1.val().length + cardNumber2.val().length +cardNumber3.val().length) === 16 ){
                        $("#carNumberValid").show();
                        $("#cardNumerInvalid").hide();
                        cardNumber0[0].setCustomValidity("");
                    } else {
                        $("#carNumberValid").hide();
                        $("#cardNumerInvalid").show();
                        cardNumber0[0].setCustomValidity("El número de tarjeta debe tener 16 dígitos.");
                    }
                });
            });
        });
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
            $("#carcvvValiddNameValid").hide();
            $("#cvvInvalid").show();
            cvv[0].setCustomValidity("El CVV debe tener 3 dígitos.");
        }
    });

    //Devuelve true si el nombre y apellidos del titular son válidos, false en caso contrario.
    function holderCheck(name) {
		return regExpr.test(name) ? true : false;
	}
})