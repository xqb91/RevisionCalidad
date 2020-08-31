
$(document).ready(function(event) {
	$("#formAudio").tooltip('show');

	
	$("#btnForceDownload").attr('disabled', 'disabled');
	$.ajax({
	    type: 'post',
	    url: 'core/SessionManager.php',
	    statusCode: {
	        404: function(responseObject, textStatus, jqXHR) {
	            alert('Ha ocurrido un error al intentar procesar su solicitud. Por favor intentelo más tarde <strong>[HTTP 404]</strong>');
	            window.close();
	        },
	        500: function(responseObject, textStatus, errorThrown) {
	            alert('Usted no se encuentra autorizado para ingresar a este módulo <br /><strong>Código de Detención 500</strong>');
	            window.close();
	        },
	        401: function(responseObject, textStatus, errorThrown) {
	            alert('Usted ha superado el tiempo establecido de inactividad, por favor inicie sesión nuevamente para poder continuar trabajando. <strong>Código de Detención 403</strong>');
	            window.close();
	        },
	        403: function(responseObject, textStatus, errorThrown) {
	            alert('Por alguna razón la sesión ha sido eliminada del navegador. <strong>Por favor inicia sesión nuevamente</strong>');
	            window.close();
	        },
	        503: function(responseObject, textStatus, errorThrown) {
	            alert('El sistema de calidad <strong>no ha controlado la existencia de su sesión</strong>, por favor inicie sesión nuevamente para poder comenzar a trabajar.');
	            window.close();
	        }, 
	        200: function(responseObject, textStatus, errorThrown) {
	        	recuperaPDF();
	        }
	    }
	});

});



function recuperaPDF() {
	var evaluacion 	= $("#irqljob").val();
	var tipo 		= $("#irqltype").val();

	switch(tipo) {
		case "1":
			//evaluacion parcial
			//../calidad/core/pdfGenerate.php?evaluacion="+evaluacion+"&tipo=parcial&accion=descargar
			$("#pdfViewer").html('<iframe src="../../calidad/core/pdfGenerate.php?evaluacion='+evaluacion+'&tipo=parcial" width="100%" height="350" />');
			//recuperarAudio();
		break;
		
		case "2":
			//quincenal
			$("#pdfViewer").html('<iframe src="../../calidad/core/pdfGenerate.php?evaluacion='+evaluacion+'&tipo=quincenal" width="100%" height="350" />');
		break;

		case "3":
			//final
			$("#pdfViewer").html('<iframe src="../../calidad/core/pdfGenerate.php?evaluacion='+evaluacion+'&tipo=final" width="100%" height="600" />');
		break;
	}
}

