var Modulo = function () {
    var resultContainer = 'tblTicket';
    var formulario = $('#ticket');
    var module = "ticket";
    var ticket;

    this.inicializarFormulario = function () {
        $('head link').prop('href', 'app/vista/css/estilo.ticket.css');
        $('nav,h1').remove();
        cargarTicket();
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


    this.procesarConsulta = function (r) {

    }

    this.postConsulta = function (llenar, campo, _conse, r) {
        switch (llenar) {
            case "ticket_info":
                cargarTicketInfo(r.content);
                break;
            case "apuesta_partido":
                cargarPartidos(r.content);
                break;
            case "apuesta_partido_parametros":
                cargarParametros(r.content);
                break;
        }
    };

    var cargarTicket = function () {
        var search = window.location.search.split('&');
        ticket = search[1].split('=')[1];
        var params = {
            ticket_number: ticket
        }
        app.consultar(null, 'ticket_info', null, params);
        app.consultar(null, 'apuesta_partido', null, params);
    };

    var cargarTicketInfo = function (r) {
        $('#ticketNumber').html(r[0].numero);
        $('#ticketDate').html(r[0].fecha);
        $('#ticketAmount').html('$' + "<span class='valorapuesta'>" + parseFloat(r[0].valor) + "</span>").appendTo(fila);
        $('#ticketSeller').html(r[0].sucursal);
    };

    var cargarPartidos = function (r) {
        var tabla = $('#apuesta .partidos');
        for (var i in r) {
            var html = '<strong>' + r[i].equipo_local + "</strong> vs <strong>" + r[i].equipo_visita + '<strong>';
            var htmlval = $('<div>').html(html);
            $('<table>').attr('id', 'apuesta_' + r[i].apuesta).attr('class', 'apuesta_row').appendTo(htmlval).append('<tbody>');
            var fila = $('<tr>');
            $('<td>').html(htmlval).appendTo(fila);
            fila.appendTo(tabla);
        }
        var params = {
            ticket_number: ticket
        };
        app.consultar(null, 'apuesta_partido_parametros', null, params);

    };

    var cargarParametros = function (r) {
        for (var i in r) {
            var fila = $('<tr>');
            $('<td>').attr('width', '50%').html(r[i].descripcion + '(' + r[i].equipo_apuesta + ')').appendTo(fila);
            $('<td>').attr('width', '50%').html("<span class='valorlinea'>" + parseFloat(r[i].valorGanar) + "</span>").appendTo(fila);
var marca='';
if (r[i].marca && r[i].marca !== ''){
marca='[' + r[i].marca + ']';
}
            $('<td>').attr('width', '50%').html(marca + "(" + r[i].factor + ")").appendTo(fila);
            fila.appendTo($('#apuesta_' + r[i].apuesta));
        }

        var apuesta = +$('.valorapuesta').html();
        var ganancia = 0;
        $('.valorlinea').each(function () {
            ganancia += +$(this).html();
        });
        var pago = apuesta + ganancia;

        $("#apuestaval").html($("#apuestaval").html() + '$' +apuesta);
        $("#gananciaval").html($("#gananciaval").html() + '$' + ganancia);
        $("#pagoval").html($("#pagoval").html() + '$' + pago);

        setTimeout(function () {
            window.print();
        }, 3000);
    };

    var app = new Application(this);
};
