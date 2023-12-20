function isNumberKey(evt)
{
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;

    return true;
}

function filterFloat(evt,input)
{
    // Backspace = 8, Enter = 13, ‘0′ = 48, ‘9′ = 57, ‘.’ = 46, ‘-’ = 43
    var key = window.Event ? evt.which : evt.keyCode;
    var chark = String.fromCharCode(key);
    var tempValue = input.value+chark;
    if(key >= 48 && key <= 57){
        if(filter(tempValue)=== false){
            return false;
        }else{
            return true;
        }
    }else{
        if(key == 8 || key == 13 || key == 0) {
            return true;
        }else if(key == 46){
            if(filter(tempValue)=== false){
                return false;
            }else{
                return true;
            }
        }else{
            return false;
        }
    }
}

function filter(__val__){
    var preg = /^([0-9]+\.?[0-9]{0,2})$/;
    if(preg.test(__val__) === true){
        return true;
    }else{
        return false;
    }

}

$.datepicker.regional['es'] = {
    closeText: 'Cerrar',
    prevText: '< Ant',
    nextText: 'Sig >',
    currentText: 'Hoy',
    monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
    monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
    dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
    dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
    dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
    weekHeader: 'Sm',
    dateFormat: 'dd-mm-yy',
    firstDay: 1,
    isRTL: false,
    showMonthAfterYear: false,
    yearSuffix: ''
};
$.datepicker.setDefaults($.datepicker.regional['es']);

//Esta funcion devolvera la cantidad de dias de diferencia entre dos fechas
//Puede ser positivo o negativo el numero devuelto
function dateDiff( date_1, date_2 ){
    //De esta forma obtenemos el valor absoluto de la diferencia
    //Math.abs( parseInt( date_1.diff(date_2,'days') ) )

    var firstDate  = moment(date_1.toString(),"DD-MM-YYYY");
    var secondDate = moment(date_2.toString(),"DD-MM-YYYY");

    return parseInt( firstDate.diff(secondDate,'days') );
}


//--------- validar que solo entren numeros en los campos  -----------------
$('.input-number').on('input', function () {
    this.value = this.value.replace(/[^0-9]/g,'');
});

// Currency Separator
var commaCounter = 10;

function numberSeparator(Number) {
    Number += '';

    for (var i = 0; i < commaCounter; i++) {
        Number = Number.replace('.', '');
    }

    x = Number.split('.');
    y = x[0];
    z = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;

    while (rgx.test(y)) {
        y = y.replace(rgx, '$1' + '.' + '$2');
    }
    commaCounter++;
    return y + z;
}