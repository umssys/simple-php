var Modulo = function () {
    var resultContainer = '';
    var formulario = $('#reporte');
    var module = "reporte";

    this.inicializarFormulario = function () {
        $('#cmdReporteTickets').on('click', function(){
             app.consultar(null, 'reporteTickets', 'tblTicketReport');
        });
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
               
    }
    
    this.procesarConsulta = function(r, campo){
        app.cargarTabla(r.content, campo);
    }
    
        

    var app = new Application(this);
};
