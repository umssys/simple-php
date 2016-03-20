// JavaScript Document 
$(function () {
    inicializarFormulario();
    $('#personal').on('submit', function () {
        if (validarFormulario()) {
            if ($('#emp_conse').val() === '') {
                if (guardarEmpleado()) {
                    alert("Registro guardado!");
                }
            } else {
                if (editarEmpleado()) {
                    alert("Registro modificado!");
                }
            }
        }
        return false;
    });
});
var inicializarFormulario = function () {
    $('#emp_conse').hide();
    console.log('inicializar');
    //consultarEmpleado();
    $('#cmdNuevo,#cmdCancelar').on('click', function () {
        $('#personal')[0].reset();
    });
    $('#cmdEliminar').on('click', function () {
        if ($('#emp_conse').val() === '') {
            alert('Debe seleccionar un registro para poder editarlo.');
            return false;
        }
        if (!confirm("Está seguro de que desea eliminar el registro?")) {
            return false;
        }
        borrarEmpleado();
        return true;
    });
    $('#emp_fechanacimiento').on('focus', function () {
        crearFechaSelector(this);
    });
}
var consultarEmpleado = function(emp_conse = null, destino = 'tabla'){
    var args = "&accion=consultarEmpleado";
    switch (destino) {
        case "tabla":
            args += "&tipo=tabla"
            break;
        case "formulario":
            args += "&tipo=formulario";
            break;
    }
    if (emp_conse) {
        args += "&emp_conse=" + emp_conse;
    }
    $.ajax({
        type: 'post',
        data: args,
        url: 'app/controlador/c.inicio.php',
        success: function (respuesta) {
            alert(respuesta);
            switch (destino) {
                case "tabla":
                    cargarTablaEmpleado(respuesta);
                    break;
                case "formulario":
                    cargarFormularioEmpleado(respuesta);
                    break;
            }
        }
    });
};
var cargarTablaEmpleado = function (r) {
    $('#tblEmpleados tbody').empty();
    var lineas = r.split('<<<br>>>');
    var resultset = new Array();
    for (var i in lineas) {
        resultset.push(lineas[i].split('||@||'));
    }
    for (var i in resultset) {
        var tr = $('<tr>').appendTo('#tblEmpleados');
        for (var k in resultset[i]) {
            $('<td>').html(resultset[i][k]).appendTo(tr);
        }
    }
    $('#tblEmpleados tbody').find('tr').each(function () {
        var celdaID = $(this).find('td').eq(0);
        var radio = $('<input>').attr('type', 'radio').attr('name', 'tbl_emp_conse').attr('value', celdaID.html())
        radio.on('click', function () {
            $('#emp_conse').val($(this).val());
            consultarEmpleado($(this).val(), 'formulario');
        });
        celdaID.html(radio);
    });
};
var cargarFormularioEmpleado = function (r) {
    var valores = r.split('||@||');
    $('#emp_conse').val(valores[0]);
    $('#emp_nombre').val(valores[1]);
    $('#emp_apellido').val(valores[2]);
    $('#emp_documento').val(valores[3]);
    $('#emp_fechanacimiento').val(valores[4]);
    $('#emp_ciudadresidencia').val(valores[5]);
    $('#emp_profesion').val(valores[6]);
    $('#emp_genero').val(valores[7]);
    $('#emp_observacion').val(valores[8]);
    $('#emp_telefono').val(valores[10]);
    $('#emp_movil').val(valores[11]);
    $('#emp_correoelectronico').val(valores[12]);
};
var guardarEmpleado = function () {
    var args = "&accion=guardarEmpleado";
    $.ajax({
        type: 'post',
        data: $('#personal').serialize() + args,
        url: 'app/controlador/c.inicio.php',
        success: function (respuesta) {
            $('#emp_conse').val(respuesta);
            consultarEmpleado();
        }
    });
    return true;
};
var editarEmpleado = function () {
    var args = "&accion=editarEmpleado";
    $.ajax({
        type: 'post',
        data: $('#personal').serialize() + args,
        url: 'app/controlador/c.inicio.php',
        success: function (respuesta) {
            consultarEmpleado();
        }
    });
    return true;
}
var borrarEmpleado = function () {
    var args = "&accion=borrarEmpleado";
    args += '&emp_conse=' + $('#emp_conse').val();
    $.ajax({
        type: 'post',
        data: args,
        url: 'app/controlador/c.inicio.php',
        success: function (respuesta) {
            consultarEmpleado();
            $('#personal')[0].reset();
        }
    });
    return true;
};
var validarFormulario = function () {
    $('input').css({'border-color': 'initial'});
    if ($('#emp_nombre').val() === '') {
        $('#emp_nombre').css({'border-color': '#f00'});
        alert('Debe escribir el nombre del empleado');
        return false;
    }
    if ($('#emp_apellido').val() === '') {
        alert('Debe escribir el apellido del empleado');
        $('#emp_apellido').css({'border-color': '#f00'});
        return false;
    }
    if (isNaN(+$('#emp_documento').val()) || $('emp_apellido').val() === '') {
        alert('Debe escribir un numero de documento válido.');
        $('#emp_documento').css({'border-color': '#f00'});
        return false;
    }
    if ($('#emp_profesion').val() === '') {
        alert('Debe escribir la profesión del empleado');
        $('#emp_profesion').css({'border-color': '#f00'});
        return false;
    }
    if ($('#emp_correoelectronico').val() === '' || $('#emp_correoelectronico').val().indexOf('@') <= 0 || $('#emp_correoelectronico').val().indexOf('.') <= 0) {
        alert('Debe escribir un correo válido');
        $('#emp_correoelectronico').css({'border-color': '#f00'});
        return false;
    }
    return true;
};

var crearFechaSelector = function (campo) {
    $('.FechaSelector').remove();
    var cont = $('<div>').attr('class', 'FechaSelector');
    var comAnyo = $('<select>').appendTo(cont).on('change', function () {
        comMes.trigger('change');
    });
    var comMes = $('<select>').appendTo(cont).on('change', function () {
        comDia.empty();
        var v = $(this).val();
        if (v === '1' || v === '3' || v === '5' || v === '7' || v === '8' || v === '10' || v === '12') {
            for (var i = 1; i <= 31; i++) {
                $('<option>').attr('value', i).html(i).appendTo(comDia);
            }
        } else if (v === '2') {
            if (comAnyo.val() % 4 === 0) {
                for (var i = 1; i <= 29; i++) {
                    $('<option>').attr('value', i).html(i).appendTo(comDia);
                }
            } else {
                for (var i = 1; i <= 28; i++) {
                    $('<option>').attr('value', i).html(i).appendTo(comDia);
                }
            }
        } else {
            for (var i = 1; i <= 30; i++) {
                $('<option>').attr('value', i).html(i).appendTo(comDia);
            }
        }
    });
    var comDia = $('<select>').appendTo(cont);
    for (var i = 2015; i >= 1900; i--) {
        $('<option>').attr('value', i).html(i).appendTo(comAnyo);
    }
    for (var i = 1; i <= 12; i++) {
        $('<option>').attr('value', i).html(i).appendTo(comMes);
    }
    $('<button>').attr('type', 'button').html('Aceptar').appendTo(cont).on('click', function () {
        $(campo).val(comAnyo.val() + '-' + (+comMes.val() < 10 ? '0' + comMes.val() : comMes.val()) + '-' + (+comDia.val() < 10 ? '0' + comDia.val() : comDia.val()));
        cont.fadeOut({complete: function () {
                cont.remove();
            }});
    });
    $(campo).prop('readonly', true);
    comAnyo.trigger('change');
    cont.appendTo($(campo).parents('label'));
    if ($(campo).val() !== '') {
        var v = $(campo).val();
        var f = v.split('-');
        comAnyo.val('' + (+f[0]));
        comMes.val('' + (+f[1]));
        comMes.trigger('change');
        comDia.val('' + (+f[2]));
    }
};

