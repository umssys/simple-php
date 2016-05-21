var Modulo = function () {
    var resultContainer = 'tblPais';
    var formulario = $('#pais');
    var module = "ciudad";

    this.inicializarFormulario = function () {
        $('#id').hide();
        app.consultar();
        new Archivero('imagen', 'public/images/pais/', 'jpg;png', null, module);
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
    
    this.postConsulta = function(llenar, campo, _conse){
        switch(llenar){
            case "activo":
                $('#' + resultContainer).find('tbody tr').each(function(){
                    var celda = $(this).find('td').eq(2);
                    var imagen = $('<img>').attr('src', 'public/images/pais/' + celda.html()).attr('class','mini');
                    celda.html(imagen)
                });
                break;
        }
    }
    

    var app = new Application(this);
};
