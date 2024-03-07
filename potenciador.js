function calcularNuevo() {

    var base = document.getElementById("base").value;

    var exponente = document.getElementById("exponente").value;

    var resultado = base ** exponente;

    $.ajax({
        type: 'POST',
        url: 'potenciador.php',
        data: 'base=' + base + '&exponente=' + exponente + '&resultado=' + resultado,
        success: function(respuesta) {
            //Mostramos la información que devuelva el servidor
            $('#log').html(respuesta);
        }
    });

    document.getElementById("resultado").innerHTML = resultado;

}




function obtenerHistorial() {

    document.getElementById("historial").innerHTML ="";

    $.ajax({
        type: 'GET',
        url: 'potenciador.php',
        dataType: 'json',
        success: function(respuesta2){
            $.each(respuesta2, function(index, item){
                $('#historial').append('<li>' + item.base + '^' + item.exponente + '=' + item.resultado + '</li>');
            });
        },
        error: function(xhr, status, error){
            console.error(xhr.responseText);
        }
    });

}


