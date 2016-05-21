var Modulo = function () {
    var resultContainer = 'tblTaquilla';
    var formulario = $('#taquilla');
    var module = "administrar_taquilla";

    this.inicializarFormulario = function () {
        $('#id').hide();
        app.consultar();
    };

    this.getResultContainer = function () {
        return resultContainer;
    };

    this.getFormulario = function () {
        return formulario;
    };

    this.getModule = function () {
        return module;
    };
    
    this.cargarFormulario = function (r) {
        var valores = r;
        $('#id').val(valores[0]['id']);
        $('#sucursal').val(valores[0].sucursal);
        $('#nombre').val(valores[0]['nombre']);
        $('#apellido').val(valores[0]['apellido']);
        $('#telefono').val(valores[0]['telefono']);
        $('#celular').val(valores[0]['celular']);
        $('#descripcion').val(valores[0]['descripcion']);
        $('#estado').val(valores[0]['estado']);
        $('#params').val(valores[0]['params']);
        $('#pais_id').val(valores[0]['pais_id']);
        $('#direccion').val(valores[0]['direccion']);
        $('#usuario').val(valores[0]['usuario']);
    }
    
    this.procesarConsulta = function(r){
        
    }

    var app = new Application(this);
};
