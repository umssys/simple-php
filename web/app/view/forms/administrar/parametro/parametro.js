var Modulo = function () {
    var resultContainer = 'tblParametro';
    var formulario = $('#parametro');
    var module = "parametro";

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
        $('#nombre').val(valores[0]['nombre']);        
    }
    
    this.procesarConsulta = function(r){
        
    }

    var app = new Application(this);
};
