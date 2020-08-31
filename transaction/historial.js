$(document).ready(function() {
	
	$.ajax({
	    type: 'post',
	    url: 'core/SessionManager.php',
	    beforeSend: function() {

	    },
	    statusCode: {
	        404: function(responseObject, textStatus, jqXHR) {
	            $("#modalHomeTitle").text('Error');
	            $("#modalHomeContenido").attr('align', 'left');
	            $("#modalHomeCerrarVentana").show();
	            $("#modalHomeContenido").html('Ha ocurrido un error al intentar procesar su solicitud. Por favor intentelo más tarde <strong>[HTTP 404]</strong>');
	            $("#modalHomeBtnCerrar").hide();
	            $("#modalHomeBtnCerrar").text('Cerrar');
	            $("#modalHomeBtnAccion").text('Iniciar sesión nuevamente!');
	            $("#modalHomeBtnAccion").show();
	            return 0;
	        },
	        500: function(responseObject, textStatus, errorThrown) {
	            $("#modalHomeTitle").text('No Autorizado');
	            $("#modalHomeContenido").attr('align', 'left');
	            $("#modalHomeCerrarVentana").hide();
	            $("#modalHomeContenido").html('Usted no se encuentra autorizado para ingresar a este módulo <br /><strong>Código de Detención 500</strong>');
	            $("#modalHomeBtnCerrar").hide();
	            $("#modalHomeBtnCerrar").text('Cerrar');
	            $("#modalHomeBtnAccion").text('Iniciar sesión nuevamente!');
	            $("#modalHomeBtnAccion").hide();
	            return 0;
	        },
	        401: function(responseObject, textStatus, errorThrown) {
	            $("#modalHomeTitle").text('Sesión Caducada');
	            $("#modalHomeContenido").attr('align', 'left');
	            $("#modalHomeCerrarVentana").show();
	            $("#modalHomeContenido").html('Usted ha superado el tiempo establecido de inactividad, por favor inicie sesión nuevamente para poder continuar trabajando. <strong>Código de Detención 403</strong>');
	            $("#modalHomeBtnCerrar").hide();
	            $("#modalHomeBtnCerrar").text('Cerrar');
	            $("#modalHomeBtnAccion").text('Iniciar sesión nuevamente!');
	            $("#modalHomeBtnAccion").show();
	            return 0;
	        },
	        403: function(responseObject, textStatus, errorThrown) {
	            $("#modalHomeTitle").text('No te podemos reconocer!');
	            $("#modalHomeContenido").attr('align', 'left');
	            $("#modalHomeCerrarVentana").show();
	            $("#modalHomeContenido").html('Por alguna razón la sesión ha sido eliminada del navegador. <strong>Por favor inicia sesión nuevamente</strong>');
	            $("#modalHomeBtnCerrar").hide();
	            $("#modalHomeBtnCerrar").text('Cerrar');
	            $("#modalHomeBtnAccion").text('Iniciar sesión nuevamente!');
	            $("#modalHomeBtnAccion").show();
	            return 0;
	        },
	        503: function(responseObject, textStatus, errorThrown) {
	            $("#modalHomeTitle").text('Sesión Corrupta');
	            $("#modalHomeContenido").attr('align', 'left');
	            $("#modalHomeCerrarVentana").show();
	            $("#modalHomeContenido").html('El sistema de calidad <strong>no ha controlado la existencia de su sesión</strong>, por favor inicie sesión nuevamente para poder comenzar a trabajar.');
	            $("#modalHomeBtnCerrar").hide();
	            $("#modalHomeBtnCerrar").text('Cerrar');
	            $("#modalHomeBtnAccion").text('Iniciar sesión nuevamente!');
	            $("#modalHomeBtnAccion").show();
	            return 0;
	        }, 
	        200: function(responseObject, textStatus, errorThrown) {
	        	historialEvaluacion();
	        }
	    }
	});
});


function historialEvaluacion() {
	var evaluacion = $("#irqljob").val();
	var tipo 		= $("#irqltype").val();
	$.ajax({
	    type: 'post',
	    url: 'core/ListHistorial.php',
	    data: {"evaluacion" : evaluacion, "tipo" : tipo},
	    statusCode: {
	        404: function(responseObject, textStatus, jqXHR) {
	            $("#lblObservacionEvaluacion").html('Ha ocurrido un error al intentar encontrar el core que procesa su solicitud. Por favor intentelo más tarde <strong>[HTTP 404]</strong>');
	            $("#modalHomeBtnCerrar").click();
	        },
	        301: function(responseObject, textStatus, errorThrown) {
	           	$("#tablaHistorial tbody").empty();
	           	var cadena = '<tr><th scope="row" colspan="4">Ha ocurrido un error al recuperar la información del historial</th></tr>';
				$("#tablaHistorial tbody").append(cadena);
	        },
	        501: function(responseObject, textStatus, errorThrown) {
				alert('La evaluación solicitada posiblemente fué eliminada. <strong>[HTTP 501]</strong>');
				 $("#modalHomeBtnCerrar").click();
	        },
	        200: function(responseObject, textStatus, errorThrown) {
	        	var respuesta = JSON.parse(responseObject);
	        	$("#tablaHistorial tbody").empty();
	        	$.each(respuesta, function(i,x) {
	        		var cadena = '<tr>';
					cadena = cadena+'<th scope="row">'+x.fecha+'</th>';
					cadena = cadena+'<td>'+x.status+'</td>';
					cadena = cadena+'<td style = "text-transform:capitalize;">'+x.autorizador+'</td>';
					var aux = $('<textarea />').html(x.detalle).text();
					cadena = cadena+'<td>'+aux+'</td>';
					cadena = cadena+'</tr>';
					$("#tablaHistorial tbody").append(cadena);
	        	});
	        }
	    }
	});
}