
//$.playSound('facade/media/revision.mp3');
//lblRevisionesCounter
//
$(document).ready(function() {
	$.ajax({
		url: 'core/ListNotificaciones.php',
		type: 'post',
		error: function(XMLHttpRequest, textStatus, errorThrown) {
		    if (XMLHttpRequest.readyState == 0) {
		    	$.playSound('facade/media/error.mp3');
				$("#lblApelacionesCounter").html('<i class="fas fa-unlink"></i>');
				var cadena = "";
				cadena = cadena +'<a class="dropdown-item d-flex align-items-center" href="#">';
        		cadena = cadena +'<div class="mr-3">';
        		cadena = cadena +'<div class="icon-circle bg-danger">';
        		cadena = cadena +'<i class="far fa-tired text-white"></i>';
        		cadena = cadena +'</div>';
        		cadena = cadena +'</div>';
        		cadena = cadena +'<div>';
        		cadena = cadena +'<div class="small text-gray-500">Sin conexión a Internet</div>';
        		cadena = cadena +'<span class="font-weight-bold">Verifique su conexión a internet.</span>'
        		cadena = cadena +'</div>';
        		cadena = cadena +'</a>';
        		$("#lblNotificacionesList").html(cadena);
		    }
		},
		beforeSend: function() {
			$("#lblApelacionesCounter").html('<img src="facade/img/loading2.gif" />');
		},
		statusCode : {
			404: function(responseObject, textStatus, errorThrown) {
				$.playSound('facade/media/error.mp3');
				$("#lblApelacionesCounter").html('<i class="fas fa-exclamation-triangle"></i>');
				var cadena = "";
				cadena = cadena +'<a class="dropdown-item d-flex align-items-center" href="#">';
        		cadena = cadena +'<div class="mr-3">';
        		cadena = cadena +'<div class="icon-circle bg-danger">';
        		cadena = cadena +'<i class="far fa-tired text-white"></i>';
        		cadena = cadena +'</div>';
        		cadena = cadena +'</div>';
        		cadena = cadena +'<div>';
        		cadena = cadena +'<div class="small text-gray-500">No se pudo atender su solicitud</div>';
        		cadena = cadena +'<span class="font-weight-bold">El CORE que procesa las solicitudes no ha sido encontrado y por lo tanto su solicitud no ha sido procesada.</span>'
        		cadena = cadena +'</div>';
        		cadena = cadena +'</a>';
        		$("#lblNotificacionesList").html(cadena);
			},
			401: function(responseObject, textStatus, errorThrown) {
				$("#lblApelacionesCounter").html('0');
				var cadena = "";
				cadena = cadena +'<a class="dropdown-item d-flex align-items-center" href="#">';
        		cadena = cadena +'<div class="mr-3">';
        		cadena = cadena +'<div class="icon-circle bg-success">';
        		cadena = cadena +'<i class="fas fa-check text-white"></i>';
        		cadena = cadena +'</div>';
        		cadena = cadena +'</div>';
        		cadena = cadena +'<div>';
        		cadena = cadena +'<div class="small text-gray-500">Felicidades!</div>';
        		cadena = cadena +'<span class="font-weight-bold">No tienes notificaciones pendientes.</span>'
        		cadena = cadena +'</div>';
        		cadena = cadena +'</a>';
        		$("#lblNotificacionesList").html(cadena);
			},
			200: function(responseObject, textStatus, errorThrown) { 
				var respuesta = JSON.parse(responseObject);
				if(respuesta.length > 0) {
	            	$.playSound('facade/media/notificacion.mp3');
	            	$("#lblApelacionesCounter").html(respuesta.length);
	            	cambiarTituloRevisiones(respuesta.length);
	            	
	            	var cadena = "";
	            	$.each(respuesta, function(i, v) {
	            		console.log(v);
						cadena = cadena +'<a class="dropdown-item d-flex align-items-center" href="#" id="permalink" evaluacion="'+v.evaluacion+'" tipo="'+v.tipo+'">';
		        		cadena = cadena +'<div class="mr-3">';
		        		cadena = cadena +'<div class="icon-circle bg-success">';
		        		cadena = cadena +'<i class="fas fa-check text-white"></i>';
		        		cadena = cadena +'</div>';
		        		cadena = cadena +'</div>';
		        		cadena = cadena +'<div>';
		        		if(v.tipo == 1) {
							cadena = cadena +'<div class="small text-gray-500">Evaluación Parcial #'+v.evaluacion+'!</div>';
		        		}else if(v.tipo == 2) {
		        			cadena = cadena +'<div class="small text-gray-500">Evaluación Quincenal #'+v.evaluacion+'!</div>';
		        		}else{
		        			cadena = cadena +'<div class="small text-gray-500">Evaluación Final #'+v.evaluacion+'!</div>';
		        		}
		        		cadena = cadena +'<span class="font-weight-bold">La apelación de '+v.nombre_ejecutivo+' ha terminado, haga clic aquí para revisar el historial de la evaluación.</span>';
		        		cadena = cadena +'</div>';
		        		cadena = cadena +'</a>';
	            	});
	            	$("#lblNotificacionesList").html(cadena);


	            	///reacción al hacer click en 
	            	$("a#permalink.dropdown-item.d-flex.align-items-center").click(function() {
	            		var evaluacion 	= $(this).attr('evaluacion');
	            		var tipo 		= $(this).attr('tipo');

	            		$("#modalHomeConfig").attr('class', 'modal-dialog modal-xl');
						$("#modalHome").modal('show');
					    $("#modalHomeTitle").html('Historial de la evaluación  '+evaluacion+'');
					    $("#modalHomeContenido").attr('align', 'left');
					    $("#modalHomeCerrarVentana").show();
					    $("#modalHomeContenido").load('historial.php?evaluacion='+evaluacion+'&tipo='+tipo);
					    $("#modalHomeBtnCerrar").show();
					    $("#modalHomeBtnCerrar").text('Cerrar');
					    $("#modalHomeBtnAccion").hide();	
	            	});
	            }
	        }
	    }
	});
});

function cambiarTituloRevisiones(cantidad) {
	setTimeout(function(){ 
		document.title = 'Sistema de Evaluación de Calidad';
		$("#faviconico").attr("href","facade/favicon/favicon.ico");
		$("#faviconpng").attr("href","facade/favicon/favicon.png");
	    setTimeout(function(){
	    	if(cantidad > 1) {
	    		document.title = cantidad+' evaluaciones terminadas';
	    	}else{
	    		document.title = cantidad+' evaluación terminada';
	    	}
	      $("#faviconico").attr("href","facade/favicon/warning.ico");
	      $("#faviconpng").attr("href","facade/favicon/warning.png");
	      cambiarTituloRevisiones(cantidad);
	   	},2000);
	 },2000);
};

