var Modulo = function () {
    var resultContainer = 'tblPartido';
    var formulario = $('#partido');
    var module = "administrar_partido";


    this.inicializarFormulario = function () {
        $('#id').hide();
        app.consultar();
        app.consultar(null, 'liga', 'liga_id');
        cargarEventos();
    };

    var cargarEventos = function () {
        $('#liga_id').on('change', function () {
            var params = {liga_id: $(this).val()};
            app.consultar(null, 'equipo', 'equipo_local', params);
            app.consultar(null, 'equipo', 'equipo_visita', params);
        });

        $('#fechaCompromiso').on('focus', function () {
            app.crearFechaSelector(this);
        });

        $('#horaInicio').on('focus', function () {
            app.crearHoraSelector(this);
        });

        $('#horaFinal').on('focus', function () {
            app.crearHoraSelector(this);
        });
        
        $('#partidoParametro').on('submit', function () {
            if ($('input[name=tblPartido_conse]:checked').length === 0){
                alert('Debe seleccionar un partido para guardar los parámetros');
                return false;
            }
            var partido_id = $('input[name=tblPartido_conse]:checked').val();
            var addData={
                partido_id: partido_id
            };
            var paramValsLocal = $("input[name='paramValsLocal[]']").map(function(){return this;}).get();
            var paramValsVisita = $("input[name='paramValsVisita[]']").map(function(){return this;}).get();
            var paramMarcaLocal = $("input[name='paramMarcaLocal[]']").map(function(){return this;}).get();
            var paramMarcaVisita = $("input[name='paramMarcaVisita[]']").map(function(){return this;}).get();
            var paramValsLocalData = new Object();
            var paramValsVisitaData = new Object();
            var paramMarcaLocalData = new Object();
            var paramMarcaVisitaData = new Object();
            for (var i in paramValsLocal){
                var campo = paramValsLocal[i];
                paramValsLocalData[campo.id] = campo.value;
            }
            for (var i in paramValsVisita){
                var campo = paramValsVisita[i];
                paramValsVisitaData[campo.id] = campo.value;
            }
            for (var i in paramMarcaLocal){
                var campo = paramMarcaLocal[i];
                paramMarcaLocalData[campo.id] = campo.value;
            }
            for (var i in paramMarcaVisita){
                var campo = paramMarcaVisita[i];
                paramMarcaVisitaData[campo.id] = campo.value;
            }
            addData['paramLocalData'] = JSON.stringify(paramValsLocalData);
            addData['paramVisitaData'] = JSON.stringify(paramValsVisitaData);
            addData['paramLocalMarcaData'] = JSON.stringify(paramMarcaLocalData);
            addData['paramVisitaMarcaData'] = JSON.stringify(paramMarcaVisitaData);
            app.ejecutar('updateMatchParams', addData, $(this).parents('form'));
            return false;
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
        var valores = r;
        $('#id').val(valores[0]['id']);
        $('#observacion').val(valores[0]['observacion']);
        $('#marcador').val(valores[0]['marcador']);
        $('#estadio').val(valores[0]['estadio']);
        $('#estado').val(valores[0]['estado']);
        $('#equipo_local').val(valores[0]['equipo_local']);
        $('#equipo_visita').val(valores[0]['equipo_visita']);
        $('#fechaCompromiso').val(valores[0]['fechaCompromiso']);
        $('#horaInicio').val(valores[0]['horaInicio']);
        $('#horaFinal').val(valores[0]['horaFinal']);
        $('#liga_id').val(valores[0]['liga_id']);
    };


    this.procesarConsulta = function (r, c) {        
        switch (r.returned) {
            case "data":
                switch (c){
                    case "parametroSet":
                        app.cargarTabla(r.content, c);
                        break;
                    default:
                        app.cargarSelect(c, r);
                        break;
                }
                
                break;
        }
    };
    
    this.onCargaTabla = function(c) {
        switch(c){
            case "tblPartido":
                $('input[name=tblPartido_conse]').on('click',function(){
                    var params = {partido_id: $(this).val()};
                    app.consultar(null, 'parametro', 'parametroSet', params);
                });
                break;
            case "parametroSet":
                ajustarTabla_ParametroSet();
                break;
        }
    };
    
    var ajustarTabla_ParametroSet = function(){
        var tabla = $('#parametroSet');
        tabla.find('tbody').find('tr').each(function(){
            var celdaValor = $(this).find('td').eq(2);
            var valor = parseFloat(celdaValor.html());
            var parametro_id = $(this).find('input[name=parametroSet_conse]').val();
            var inputval = $('<input>').val(valor).attr('id', 'paramLocalVal_' + parametro_id).attr('name', 'paramValsLocal[]');
            celdaValor.empty();
            celdaValor.append(inputval);
            
            var celdaValor = $(this).find('td').eq(3);
            var valor = celdaValor.html();
            var parametro_id = $(this).find('input[name=parametroSet_conse]').val();
            var inputval = $('<input>').val(valor).attr('id', 'paramLocalMarca_' + parametro_id).attr('name', 'paramMarcaLocal[]').attr('maxlength', '1');
            celdaValor.empty();
            celdaValor.append(inputval);
            
            var celdaValor = $(this).find('td').eq(4);
            var valor = parseFloat(celdaValor.html());
            var parametro_id = $(this).find('input[name=parametroSet_conse]').val();
            var inputval = $('<input>').val(valor).attr('id', 'paramVisitaVal_' + parametro_id).attr('name', 'paramValsVisita[]');
            celdaValor.empty();
            celdaValor.append(inputval);
            
            var celdaValor = $(this).find('td').eq(5);
            var valor = celdaValor.html();
            var parametro_id = $(this).find('input[name=parametroSet_conse]').val();
            var inputval = $('<input>').val(valor).attr('id', 'paramVisitaMarca_' + parametro_id).attr('name', 'paramMarcaVisita[]').attr('maxlength', '1');
            celdaValor.empty();
            celdaValor.append(inputval);
            
            
            
        });
    };

    var app = new Application(this);
};

