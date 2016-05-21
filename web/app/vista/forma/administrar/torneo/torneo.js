var Modulo = function () {
    var resultContainer = 'tblTorneo';
    var formulario = $('#torneo');
    var module = "administrar_torneo";

    this.inicializarFormulario = function () {
        $('#id').hide();
        app.consultar();
        app.consultar(null, 'liga', 'liga_id');
        app.consultar(null, 'equipo', 'equipo_id');
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
        $('#liga_id').val(valores[0]['liga_id']);
        $('#equipo_id').val(valores[0]['liga_id']);
        $('#estado').val(valores[0]['estado']);

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

