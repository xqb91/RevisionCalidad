function validarSesion() {
    $.ajax({
        type: 'post',
        url: 'core/SessionManager.php',
        beforeSend: function() {
            //inicializando modal que valida sesión de raulí
            $("#modalIndexTitle").text('Validando Sesión');
            $("#modalIndexCerrarVentana").hide();
            $("#modalIndexContenido").prop('align', 'center');
            $("#modalIndexContenido").html('Estamos validando que su sesión del sistema de calidad se encuentre activa<br /><img src="facade/img/loading.gif" alt="cargando" />');
            $("#modalIndexBtnCerrar").hide();
            $("#modalIndexBtnAccion").hide();
            $("#modalIndex").modal('show');
            $("#slcArea").prop('disabled', 'disabled');
            $("#slcPeriodo").prop('disabled', 'disabled');
            $("#btnComenzar").prop('disabled', 'disabled');
            $("#slcArea").hide();
            $("#slcPeriodo").hide();
            $("#btnComenzar").hide();
        },
        statusCode: {
            404: function(responseObject, textStatus, jqXHR) {
                $("#modalIndexTitle").text('Error');
                $("#modalIndexContenido").attr('align', 'left');
                $("#modalIndexCerrarVentana").show();
                $("#modalIndexContenido").html('Ha ocurrido un error al intentar procesar su solicitud. Por favor intentelo más tarde <strong>[HTTP 404]</strong>');
                $("#modalIndexBtnCerrar").hide();
                $("#modalIndexBtnCerrar").text('Cerrar');
                $("#modalIndexBtnAccion").text('Iniciar sesión nuevamente!');
                $("#modalIndexBtnAccion").show();
                return 0;
            },
            500: function(responseObject, textStatus, errorThrown) {
                $("#modalIndexTitle").text('No Autorizado');
                $("#modalIndexContenido").attr('align', 'left');
                $("#modalIndexCerrarVentana").hide();
                $("#modalIndexContenido").html('Usted no se encuentra autorizado para ingresar a este módulo <br /><strong>Código de Detención 500</strong>');
                $("#modalIndexBtnCerrar").hide();
                $("#modalIndexBtnCerrar").text('Cerrar');
                $("#modalIndexBtnAccion").text('Iniciar sesión nuevamente!');
                $("#modalIndexBtnAccion").hide();
                return 0;
            },
            401: function(responseObject, textStatus, errorThrown) {
                $("#modalIndexTitle").text('Sesión Caducada');
                $("#modalIndexContenido").attr('align', 'left');
                $("#modalIndexCerrarVentana").show();
                $("#modalIndexContenido").html('Usted ha superado el tiempo establecido de inactividad, por favor inicie sesión nuevamente para poder continuar trabajando. <strong>Código de Detención 403</strong>');
                $("#modalIndexBtnCerrar").hide();
                $("#modalIndexBtnCerrar").text('Cerrar');
                $("#modalIndexBtnAccion").text('Iniciar sesión nuevamente!');
                $("#modalIndexBtnAccion").show();
                return 0;
            },
            403: function(responseObject, textStatus, errorThrown) {
                $("#modalIndexTitle").text('No te podemos reconocer!');
                $("#modalIndexContenido").attr('align', 'left');
                $("#modalIndexCerrarVentana").show();
                $("#modalIndexContenido").html('Por alguna razón la sesión ha sido eliminada del navegador. <strong>Por favor inicia sesión nuevamente</strong>');
                $("#modalIndexBtnCerrar").hide();
                $("#modalIndexBtnCerrar").text('Cerrar');
                $("#modalIndexBtnAccion").text('Iniciar sesión nuevamente!');
                $("#modalIndexBtnAccion").show();
                return 0;
            },
            503: function(responseObject, textStatus, errorThrown) {
                $("#modalIndexTitle").text('Sesión Corrupta');
                $("#modalIndexContenido").attr('align', 'left');
                $("#modalIndexCerrarVentana").show();
                $("#modalIndexContenido").html('El sistema de calidad <strong>no ha controlado la existencia de su sesión</strong>, por favor inicie sesión nuevamente para poder comenzar a trabajar.');
                $("#modalIndexBtnCerrar").hide();
                $("#modalIndexBtnCerrar").text('Cerrar');
                $("#modalIndexBtnAccion").text('Iniciar sesión nuevamente!');
                $("#modalIndexBtnAccion").show();
                return 0;
            }, 
            200: function(responseObject, textStatus, errorThrown) {
                return 1;
            }
        }
    });
}