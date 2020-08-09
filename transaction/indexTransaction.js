$(document).ready(function() {
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
                        window.close();
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
                        window.close();
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
                        window.close();
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
                        window.close();
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
                        window.close();
                    }, 
                    200: function(responseObject, textStatus, errorThrown) {
                        $.ajax({
                                type: 'post',
                                url: 'core/InfoSesionEvaluador.php',
                                beforeSend: function() {
                                    //inicializando modal que valida sesión de raulí
                                    $("#lblSaludoUser").html('Estamos cargando tu información personal.');

                                },
                                statusCode: {
                                        500: function(responseObject, textStatus, errorThrown) {
                                            $("#modalIndexTitle").text('Información de Evaluador');
                                            $("#modalIndexContenido").attr('align', 'left');
                                            $("#modalIndexCerrarVentana").show();
                                            $("#modalIndexContenido").html('No se ha podido recuperar la información del evaluador<br /><strong>ERROR JSON EMPTY</strong>');
                                            $("#modalIndexBtnCerrar").hide();
                                            $("#modalIndexBtnCerrar").text('Cerrar');
                                            $("#modalIndexBtnAccion").hide();
                                        },
                                        200: function(responseObject, textStatus, errorThrown) {
                                            var resultados = JSON.parse(responseObject);
                                            $("#lblSaludoUser").html('Hola <strong>'+resultados.nombre_evaluador+'!</strong>');
                                            $("#mensajeUsuario").html('Por favor, elige el periodo y área para comenzar a trabajar.');
                                            $.ajax({
                                                    type: 'post',
                                                    url: 'core/ListAreas.php',
                                                    beforeSend: function() {
                                                        //inicializando modal que valida sesión de raulí
                                                        $("#slcArea").show();
                                                    },
                                                    statusCode: {
                                                            500: function(responseObject, textStatus, errorThrown) {
                                                                $("#modalIndexTitle").text('Controlador de Areas');
                                                                $("#modalIndexContenido").attr('align', 'left');
                                                                $("#modalIndexCerrarVentana").show();
                                                                $("#modalIndexContenido").html('Ocurrió un error al cargar el listado de áreas disponibles<br /><strong>ERROR JSON EMPTY</strong>');
                                                                $("#modalIndexBtnCerrar").show();
                                                                $("#modalIndexBtnCerrar").text('Cerrar');
                                                                $("#modalIndexBtnAccion").hide();
                                                            },
                                                            200: function(responseObject, textStatus, errorThrown) {
                                                                var resultados = JSON.parse(responseObject);
                                                                $.each(resultados, function (index, value) {
                                                                    //dataArray.push([value["yourID"].toString(), value["yourValue"] ]);
                                                                    $("#slcArea").append('<option value="'+value.codigo_area+'">'+value.nombre_area+'</option>');
                                                                    $("#slcArea").removeAttr('disabled');
                                                                });

                                                                    $.ajax({
                                                                            type: 'post',
                                                                            url: 'core/ListPeriodosParaEvaluar.php',
                                                                            beforeSend: function() {
                                                                                //inicializando modal que valida sesión de raulí
                                                                                $("#slcPeriodo").show();
                                                                                $("#btnComenzar").show();
                                                                            },
                                                                            statusCode: {
                                                                                    404: function(responseObject, textStatus, errorThrown) {
                                                                                        $("#modalIndexTitle").text('´Problema al cargar el periodo');
                                                                                        $("#modalIndexContenido").attr('align', 'left');
                                                                                        $("#modalIndexCerrarVentana").show();
                                                                                        $("#modalIndexContenido").html('No se encontró respuesta del servidor para los periodos para trabajar<br /><strong>HTTTP 404</strong>');
                                                                                        $("#modalIndexBtnCerrar").show();
                                                                                        $("#modalIndexBtnCerrar").text('Cerrar');
                                                                                        $("#modalIndexBtnAccion").hide();
                                                                                    },
                                                                                    200: function(responseObject, textStatus, errorThrown) {
                                                                                        var resultados = JSON.parse(responseObject);
                                                                                        var i = 0;
                                                                                        $.each(resultados.periodos, function (index, value) {
                                                                                            //dataArray.push([value["yourID"].toString(), value["yourValue"] ]);
                                                                                            $("#slcPeriodo").append('<option value="'+value+'">'+value+'</option>');
                                                                                            i++;
                                                                                        });
                                                                                        $("#slcPeriodo").removeAttr('disabled');
                                                                                        $("#btnComenzar").removeAttr('disabled');
                                                                                        $("#modalIndexBtnCerrar").click();  
                                                                                    }           
                                                                                }
                                                                    });
                                                            }           
                                                        }
                                            });
                                        }           
                                    }
                        });
                    }           
                }
    });
});


$("#btnComenzar").click(function() {
    $.ajax({
        type: 'post',
        data: $("#formInit").serialize(),
        url: 'core/indexBeginWork.php',
        beforeSend: function() {
                $("#modalIndexTitle").text('Espera un momento');
                $("#modalIndexCerrarVentana").hide();
                $("#modalIndexContenido").prop('align', 'center');
                $("#modalIndexContenido").html('Estamos preparando tu ambiente de trabajo<br /><img src="facade/img/loading.gif" alt="cargando" />');
                $("#modalIndexBtnCerrar").hide();
                $("#modalIndexBtnAccion").hide();
                $("#modalIndex").modal('show');
                $("#slcArea").prop('disabled', 'disabled');
                $("#slcPeriodo").prop('disabled', 'disabled');
                $("#btnComenzar").prop('disabled', 'disabled');
        },
        statusCode: {
                404: function(responseObject, textStatus, errorThrown) {
                    $("#modalIndexTitle").text('´Problema al cargar el periodo');
                    $("#modalIndexContenido").attr('align', 'left');
                    $("#modalIndexCerrarVentana").show();
                    $("#modalIndexContenido").html('No se encontró respuesta del servidor para los periodos para trabajar<br /><strong>HTTTP 404</strong>');
                    $("#modalIndexBtnCerrar").show();
                    $("#modalIndexBtnCerrar").text('Cerrar');
                    $("#modalIndexBtnAccion").hide();
                },
                401: function(responseObject, textStatus, errorThrown) {
                    $("#modalIndexTitle").text('Ha ocurrido un problema');
                    $("#modalIndexContenido").attr('align', 'left');
                    $("#modalIndexCerrarVentana").show();
                    $("#modalIndexContenido").html('El sistema tuvo problemas al recibir un parametro básico para iniciar las tareas<br /><strong>HTTP 401: POST AREA EMPTY</strong>');
                    $("#modalIndexBtnCerrar").show();
                    $("#modalIndexBtnCerrar").text('Cerrar');
                    $("#modalIndexBtnAccion").hide();
                    $("#slcArea").removeAttr('disabled');
                    $("#slcPeriodo").removeAttr('disabled');
                    $("#btnComenzar").removeAttr('disabled');
                },
                403: function(responseObject, textStatus, errorThrown) {
                    $("#modalIndexTitle").text('Ha ocurrido un problema');
                    $("#modalIndexContenido").attr('align', 'left');
                    $("#modalIndexCerrarVentana").show();
                    $("#modalIndexContenido").html('El sistema tuvo problemas al recibir un parametro básico para iniciar las tareas<br /><strong>HTTP 403: POST PERIODO EMPTY</strong>');
                    $("#modalIndexBtnCerrar").show();
                    $("#modalIndexBtnCerrar").text('Cerrar');
                    $("#modalIndexBtnAccion").hide();
                    $("#slcArea").removeAttr('disabled');
                    $("#slcPeriodo").removeAttr('disabled');
                    $("#btnComenzar").removeAttr('disabled');
                },
                200: function(responseObject, textStatus, errorThrown) {
                    window.location.href = "home.php";                    
                }           
            }
    });
});