var Modulo = function () {
    var resultContainer = 'tblEquipo';
    var formulario = $('#equipo');
    var module = "equipo";

    this.inicializarFormulario = function () {
        $('#id').hide();
        app.consultar();
        app.consultar(null, 'liga', 'liga_id');
        new Archivero('imagen', 'public/images/equipo/', 'jpg;png', null, module);
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
        $('#imagen').val(valores[0]['imagen']);
        $('#descripcion').val(valores[0]['descripcion']);
        $('#estado').val(valores[0]['estado']);
        $('#liga_id').val(valores[0]['liga_id']);
        $('#direccion').val(valores[0]['direccion']);
    }


    this.procesarConsulta = function (r, c) {
        switch (r.returned) {
            case "data":
                app.cargarSelect(c, r);
                break;
        }
    };

    var app = new Application(this);
};

