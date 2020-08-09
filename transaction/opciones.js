quill = new Quill('#lblTextArea', {	
    theme: 'snow'
});

$(document).ready(function() {
	$("#btnAudioDownload").attr('disabled', 'disabled'); 
	$("#lblTextArea").hide();
	$("div.ql-toolbar.ql-snow").hide();
	$("#btnEjecutarProceso").hide();
	$("#entrarAProceso").hide();
	$("#entrarAProcesoLabel").hide();
	$("#btnAprobarApelacion").hide();
	$("#btnRechazarApelacion").hide();
	
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
	        	detallesEvaluacion();
	        	getObservacion();
	        	recuperarAudio();
	        	recuperarAdjunto();
	        	recuperaPDF();
	        	historialEvaluacion();
	        }
	    }
	});
});

$("#btnAudioDownload").click(function() {
	downloadFile();
});

$("#btnPDFDownloader").click(function() {
	downloadPDF();
});


$("#entrarAProceso").change(function() {
	if($(this).is(':checked')) {
		$("#lblTextArea").show();
		$("div.ql-toolbar.ql-snow").show();
		$("#btnEjecutarProceso").show();
	}else{
		$("div.ql-toolbar.ql-snow").hide();
		$("#lblTextArea").hide();
		$("#btnEjecutarProceso").hide();
	}
});


$("#btnAprobarApelacion").click(function() { 
	$("#btnEjecutarProceso").html('Aceptar');
	$("div.ql-toolbar.ql-snow").show();
	$("#btnEjecutarProceso").show();
	$("#lblTextArea").show();
	$("#btnRechazarApelacion").attr('disabled', 'disabled');
});

$("#btnRechazarApelacion").click(function() { 
	$("#btnEjecutarProceso").html('Rechazar');
	$("div.ql-toolbar.ql-snow").show();
	$("#btnEjecutarProceso").show();
	$("#lblTextArea").show();
	$("#btnAprobarApelacion").attr('disabled', 'disabled');
});

$("#btnEjecutarProceso").click(function() {
	if($("#btnEjecutarProceso").text() == 'Aceptar') {
		var evaluacion = $("#btnEjecutarProceso").attr('evaluacion');
		var tipo = $("#btnEjecutarProceso").attr('tipo_evaluacion');
		$.ajax({
		    type: 'post',
		    url: 'core/ChangeStatus.php',
		    data: {"evaluacion" : evaluacion, "tipo" : tipo, "comentario" : quill.root.innerHTML, "nuevoestado" : "aceptada"},
		    statusCode: {
		        505: function(responseObject, textStatus, jqXHR) {
		            alert('Ocurrió un error ya que no se recibió un parámetro [HTTP 505]');
		        },
		        504: function(responseObject, textStatus, jqXHR) {
		            alert('Ocurrió un error ya que no se recibió un parámetro [HTTP 504]');
		        },
		        503: function(responseObject, textStatus, jqXHR) {
		            alert('Ocurrió un error ya que no se recibió un parámetro [HTTP 503]');
		        },
		        502: function(responseObject, textStatus, jqXHR) {
		            alert('Ocurrió un error ya que no se recibió un parámetro [HTTP 502]');
		        },
		        501: function(responseObject, textStatus, jqXHR) {
		            alert('Ocurrió un error ya que no se recibió un parámetro [HTTP 501]');
		        },
		        500: function(responseObject, textStatus, errorThrown) {
		            alert('El tipo de evaluacion '+tipo+' es invalido y se ha rechazado la petición. [HTTP 500]');
		        },
		        401: function(responseObject, textStatus, errorThrown) {
					alert('La evaluación '+evaluacion+' no fue encontrada en la base de datos. Imposible proceder');
		        },
		        202: function(responseObject, textStatus, errorThrown) {
					alert('Imposible registrar el evento de cammbio de estado de la evaluación. Se rechaza la solicitud. La evaluación '+evaluacion+' mantendrá su estado actual.');
		        },
		        201: function(responseObject, textStatus, errorThrown) {
					alert('Imposible actualizar el estado de la evaluación. Se rechaza la solicitud. La evaluación '+evaluacion+' mantendrá su estado actual sin embargo, se ha registrado en el historial de cambios. Favor informe a equipo TRICOT MIS para actualización manual. Adjunte este error.');
		        },
		        200: function(responseObject, textStatus, errorThrown) {
		        	alert('Éxito: '+responseObject);	
		        	$("#lblTextArea").hide();
					$("div.ql-toolbar.ql-snow").hide();
					$("#btnEjecutarProceso").hide();
					$("#entrarAProceso").hide();
					detallesEvaluacion();
		        }
		    }
		});
	}else if($("#btnEjecutarProceso").text() == 'Rechazar') {
		var evaluacion = $("#btnEjecutarProceso").attr('evaluacion');
		var tipo = $("#btnEjecutarProceso").attr('tipo_evaluacion');
		$.ajax({
		    type: 'post',
		    url: 'core/ChangeStatus.php',
		    data: {"evaluacion" : evaluacion, "tipo" : tipo, "comentario" : quill.root.innerHTML, "nuevoestado" : "rechazado"},
		    statusCode: {
		       505: function(responseObject, textStatus, jqXHR) {
		            alert('Ocurrió un error ya que no se recibió un parámetro [HTTP 505]');
		        },
		        504: function(responseObject, textStatus, jqXHR) {
		            alert('Ocurrió un error ya que no se recibió un parámetro [HTTP 504]');
		        },
		        503: function(responseObject, textStatus, jqXHR) {
		            alert('Ocurrió un error ya que no se recibió un parámetro [HTTP 503]');
		        },
		        502: function(responseObject, textStatus, jqXHR) {
		            alert('Ocurrió un error ya que no se recibió un parámetro [HTTP 502]');
		        },
		        501: function(responseObject, textStatus, jqXHR) {
		            alert('Ocurrió un error ya que no se recibió un parámetro [HTTP 501]');
		        },
		        500: function(responseObject, textStatus, errorThrown) {
		            alert('El tipo de evaluacion '+tipo+' es invalido y se ha rechazado la petición. [HTTP 500]');
		        },
		        401: function(responseObject, textStatus, errorThrown) {
					alert('La evaluación '+evaluacion+' no fue encontrada en la base de datos. Imposible proceder');
		        },
		        202: function(responseObject, textStatus, errorThrown) {
					alert('Imposible registrar el evento de cammbio de estado de la evaluación. Se rechaza la solicitud. La evaluación '+evaluacion+' mantendrá su estado actual.');
		        },
		        201: function(responseObject, textStatus, errorThrown) {
					alert('Imposible actualizar el estado de la evaluación. Se rechaza la solicitud. La evaluación '+evaluacion+' mantendrá su estado actual sin embargo, se ha registrado en el historial de cambios. Favor informe a equipo TRICOT MIS para actualización manual. Adjunte este error.');
		        },
		        200: function(responseObject, textStatus, errorThrown) {
		        	alert('Éxito: '+responseObject);	
		        	$("#lblTextArea").hide();
					$("div.ql-toolbar.ql-snow").hide();
					$("#btnEjecutarProceso").hide();
					$("#entrarAProceso").hide();
					detallesEvaluacion();
		        }
		    }
		});
	}else if($("#btnEjecutarProceso").text() == 'Enviar a Revisión') {
		var evaluacion = $("#btnEjecutarProceso").attr('evaluacion');
		var tipo = $("#btnEjecutarProceso").attr('tipo_evaluacion');
		$.ajax({
		    type: 'post',
		    url: 'core/ChangeStatus.php',
		    data: {"evaluacion" : evaluacion, "tipo" : tipo, "comentario" : quill.root.innerHTML, "nuevoestado" : "vacio"},
		    statusCode: {
		        505: function(responseObject, textStatus, jqXHR) {
		            alert('Ocurrió un error ya que no se recibió un parámetro [HTTP 505]');
		        },
		        504: function(responseObject, textStatus, jqXHR) {
		            alert('Ocurrió un error ya que no se recibió un parámetro [HTTP 504]');
		        },
		        503: function(responseObject, textStatus, jqXHR) {
		            alert('Ocurrió un error ya que no se recibió un parámetro [HTTP 503]');
		        },
		        502: function(responseObject, textStatus, jqXHR) {
		            alert('Ocurrió un error ya que no se recibió un parámetro [HTTP 502]');
		        },
		        501: function(responseObject, textStatus, jqXHR) {
		            alert('Ocurrió un error ya que no se recibió un parámetro [HTTP 501]');
		        },
		        500: function(responseObject, textStatus, errorThrown) {
		            alert('El tipo de evaluacion '+tipo+' es invalido y se ha rechazado la petición. [HTTP 500]');
		        },
		        401: function(responseObject, textStatus, errorThrown) {
					alert('La evaluación '+evaluacion+' no fue encontrada en la base de datos. Imposible proceder');
		        },
		        202: function(responseObject, textStatus, errorThrown) {
					alert('Imposible registrar el evento de cammbio de estado de la evaluación. Se rechaza la solicitud. La evaluación '+evaluacion+' mantendrá su estado actual.');
		        },
		        201: function(responseObject, textStatus, errorThrown) {
					alert('Imposible actualizar el estado de la evaluación. Se rechaza la solicitud. La evaluación '+evaluacion+' mantendrá su estado actual sin embargo, se ha registrado en el historial de cambios. Favor informe a equipo TRICOT MIS para actualización manual. Adjunte este error.');
		        },
		        200: function(responseObject, textStatus, errorThrown) {
		        	alert('Éxito: '+responseObject);	
					$("#lblTextArea").hide();
					$("div.ql-toolbar.ql-snow").hide();
					$("#btnEjecutarProceso").hide();
					$("#entrarAProceso").hide();
					detallesEvaluacion();
		        }
		    }
		});
	}
});


//--- OK 
function getObservacion() {
	var evaluacion = $("#irqljob").val();
	var tipo 		= $("#irqltype").val();	
	if(tipo == 1) {
		$.ajax({
		    type: 'post',
		    url: 'core/parcialObservacion.php',
		    data: {"evaluacion" : evaluacion},
		    statusCode: {
		        404: function(responseObject, textStatus, jqXHR) {
		            $("#lblObservacionEvaluacion").html('Ha ocurrido un error al intentar encontrar el core que procesa su solicitud. Por favor intentelo más tarde <strong>[HTTP 404]</strong>');
		        },
		        500: function(responseObject, textStatus, errorThrown) {
		            $("#lblObservacionEvaluacion").html('El sistema no ha especificado el número de evaluación para recuperar la observación de la evaluación <strong>[HTTP 500]</strong>');
		        },
		        501: function(responseObject, textStatus, errorThrown) {
					$("#lblObservacionEvaluacion").html('El sistema no ha encontrado la evaluación porque lo mas probable es que esta evaluación haya sido eliminada del sistema. <strong>[HTTP 501]</strong>');
		        },
		        200: function(responseObject, textStatus, errorThrown) {
		        	$("#lblObservacionEvaluacion").html(responseObject);
		        }
		    }
		});
	}else if(tipo == 3) {
		$.ajax({
		    type: 'post',
		    url: 'core/finalObservacion.php',
		    data: {"evaluacion" : evaluacion},
		    statusCode: {
		        404: function(responseObject, textStatus, jqXHR) {
		            $("#lblObservacionEvaluacion").html('Ha ocurrido un error al intentar encontrar el core que procesa su solicitud. Por favor intentelo más tarde <strong>[HTTP 404]</strong>');
		        },
		        500: function(responseObject, textStatus, errorThrown) {
		            $("#lblObservacionEvaluacion").html('El sistema no ha especificado el número de evaluación para recuperar la observación de la evaluación <strong>[HTTP 500]</strong>');
		        },
		        501: function(responseObject, textStatus, errorThrown) {
					$("#lblObservacionEvaluacion").html('El sistema no ha encontrado la evaluación porque lo mas probable es que esta evaluación haya sido eliminada del sistema. <strong>[HTTP 501]</strong>');
		        },
		        200: function(responseObject, textStatus, errorThrown) {
		        	$("#lblObservacionEvaluacion").html(responseObject);
		        }
		    }
		});
	}
}

//--- OK
function recuperarAudio() {
	var evaluacion 	= $("#irqljob").val();
	var tipo 		= $("#irqltype").val();

	if(tipo == 2) {
		$("#headingTwo").hide();
		$("#headingOne").hide();
		$("#headingFive").hide();
	}else if(tipo == 3){
		$("#headingTwo").hide();
		$("#headingFive").hide();
	}else{
		$("#headingFive").hide();
		$.ajax({
		    type: 'post',
		    url: 'core/parcialAudioCargado.php',
		    data: {"evaluacion" : evaluacion},
		    statusCode: {
		        404: function(responseObject, textStatus, jqXHR) {
		            $("#btnAudioDownload").attr('disabled', 'disabled');
		            $("#lblAudioNombre").html('<strong>Archivo no encontrado</strong>');
		        	$("#lblAudioPeso").html('Peso del audio: <em>-.-- Kb</em>');
		        },
		        500: function(responseObject, textStatus, errorThrown) {
		            $("#btnAudioDownload").attr('disabled', 'disabled');
		            $("#lblAudioNombre").html('<strong>Archivo no encontrado</strong>');
		        	$("#lblAudioPeso").html('Peso del audio: <em>-.-- Kb</em>');
		        },
		        200: function(responseObject, textStatus, errorThrown) {
		        	respuesta = JSON.parse(responseObject);
		        	$("#lblAudioNombre").html('<strong>'+respuesta.nombre_fichero+'</strong>');
		        	$("#lblAudioPeso").html('Peso del audio: <em>'+respuesta.peso+'</em>');
		        	$("#btnAudioDownload").removeAttr('disabled');
		        }
		    }
		});
	}
}

//---- OK
function recuperarAdjunto() {
	var evaluacion 	= $("#irqljob").val();
	var tipo 		= $("#irqltype").val();
	if(tipo == 1) {
		$.ajax({
		    type: 'post',
		    url: 'core/parcialAdjuntoCargado.php',
		    data: {"evaluacion" : evaluacion},
		    statusCode: {
		        404: function(responseObject, textStatus, jqXHR) {
		            alert('El archivo se encuentra registrado en la base de datos pero no se encontró el fichero en el servidor');
		        },
		        500: function(responseObject, textStatus, errorThrown) {
		            alert('La evaluación no fue encontrada en la base de datos, posiblemente fue eliminada '+evaluacion);
		        },
		        501: function(responseObject, textStatus, errorThrown) {
		            $("#tablaAdjuntos tbody").empty();
		            $("#tablaAdjuntos tbody").append('<tr><th scope="row" colspan="2" style="text-align: center;">Esta evaluación no posee archivos adjuntos</th></tr>');
		        },
		        200: function(responseObject, textStatus, errorThrown) {
		        	respuesta = JSON.parse(responseObject);
		        	 $("#tablaAdjuntos tbody").empty();
		        	 $.each(respuesta.adjunto, function(i,x ) {
		        	 	$("#tablaAdjuntos tbody").append('<tr><th scope="row">'+x.nombre_fichero+'<br /><span class="badge badge-secondary">Peso '+x.peso+'</span></th><td><button type="button" id="btnDownloadAdjunto" file="'+x.url+'" original="'+x.nombre_fichero+'" class="btn btn-info btn-sm">Descargar</button></td></tr>');
		        	 });


		        	 $("button#btnDownloadAdjunto.btn.btn-info.btn-sm").click(function() {
		        	 	var url = $(this).attr('file');
		        	 	var nombre = $(this).attr('original');
		        	 	$.ajax({
						    type: 'post',
						    url: 'core/forceDownload.php',
						    data: {"evaluacion" : evaluacion},
						    statusCode: {
						        404: function(responseObject, textStatus, jqXHR) {
						            alert('El archivo se encuentra registrado en la base de datos pero no se encontró el fichero en el servidor');
						        },
						        200: function(responseObject, textStatus, errorThrown) {
						        	$("#urlAdjunto").val(url);
						        	$("#originalAdjunto").val(nombre);
						        	$("#formDownloadAdjunto").submit();
						        }
						    }
						});
		        	 })
		        }
		    }
		});
	}
}

//-- OK
function downloadFile() {
	var evaluacion 	= $("#irqljob").val();
	var tipo 		= $("#irqltype").val();

	if(tipo == 1) {
		$.ajax({
		    type: 'post',
		    url: 'core/forceDownload.php',
		    data: {"evaluacion" : evaluacion},
		    statusCode: {
		        404: function(responseObject, textStatus, jqXHR) {
		            alert('El archivo se encuentra registrado en la base de datos pero no se encontró el fichero en el servidor');
		        },
		        500: function(responseObject, textStatus, errorThrown) {
		            alert('La evaluación no posee un audio cargado :C. HTTP 500 CORE ParcialAudio EVA '+evaluacion);
		        },
		        200: function(responseObject, textStatus, errorThrown) {
		        	$("#nroEvaluacion").val(evaluacion);
		        	$("#formDownloadFile").submit();
		        }
		    }
		});
	}
}

//-- OK
function recuperaPDF() {
	var evaluacion 	= $("#irqljob").val();
	var tipo 		= $("#irqltype").val();

	switch(tipo) {
		case "1":
			//evaluacion parcial
			//../calidad/core/pdfGenerate.php?evaluacion="+evaluacion+"&tipo=parcial&accion=descargar
			$("#pdfViewer").html('<iframe src="../calidad/core/pdfGenerate.php?evaluacion='+evaluacion+'&tipo=parcial" width="100%" height="350" />');
			//recuperarAudio();
		break;
		
		case "2":
			//quincenal
			$("#pdfViewer").html('<iframe src="../calidad/core/pdfGenerate.php?evaluacion='+evaluacion+'&tipo=quincenal" width="100%" height="350" />');
		break;

		case "3":
			//final
			$("#pdfViewer").html('<iframe src="../calidad/core/pdfGenerate.php?evaluacion='+evaluacion+'&tipo=final" width="100%" height="600" />');
		break;
	}
}

//-- OK
function downloadPDF() {
	var evaluacion 	= $("#irqljob").val();
	var tipo 		= $("#irqltype").val();
	
	switch(tipo) {
		case "1":
			//evaluacion parcial
			window.location.href="../calidad/core/pdfGenerate.php?evaluacion="+evaluacion+"&tipo=parcial&accion=descargar";
		break;
		
		case "2":
			//quincenal
			window.location.href="../calidad/core/pdfGenerate.php?evaluacion="+evaluacion+"&tipo=quincenal&accion=descargar";
		break;

		case "3":
			//final
			window.location.href="../calidad/core/pdfGenerate.php?evaluacion="+evaluacion+"&tipo=final&accion=descargar";
		break;
	}
}

function historialEvaluacion() {
	var evaluacion = $("#irqljob").val();
	var tipo 		= $("#irqltype").val();
	$.ajax({
	    type: 'post',
	    url: 'core/ListHistorial.php',
	    data: {"evaluacion" : evaluacion, "tipo" : tipo},
	    statusCode: {
	        404: function(responseObject, textStatus, jqXHR) {
	        	$("#tablaHistorial tbody").empty();
	            $("#tablaHistorial tbody").append('<tr><th scope="row" colspan="3">Ha ocurrido un error al intentar encontrar el core que procesa su solicitud. Por favor intentelo más tarde <strong>[HTTP 404]</strong></th></tr>');
	        },
	        301: function(responseObject, textStatus, errorThrown) {
	           	$("#tablaHistorial tbody").empty();
	           	var cadena = '<tr><th scope="row" colspan="3">Ha ocurrido un error al recuperar la información del historial</th></tr>';
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
					cadena = cadena+'<td>'+x.autorizador+'</td>';
					cadena = cadena+'</tr>';
					$("#tablaHistorial tbody").append(cadena);
	        	});
	        }
	    }
	});
}

function cargarMotivoApelacion() {
	var evaluacion = $("#irqljob").val();
	$.ajax({
	    type: 'post',
	    url: 'core/verMotivoApelacion.php',
	    data: {"evaluacion" : evaluacion},
	    statusCode: {
	        404: function(responseObject, textStatus, jqXHR) {
	            $("#lblMotivoApelacion").html('Ha ocurrido un error al intentar encontrar el core que procesa su solicitud. Por favor intentelo más tarde <strong>[HTTP 404]</strong>');
	        },
	        500: function(responseObject, textStatus, errorThrown) {
				$("#lblMotivoApelacion").html('No se recibieron todos los parametros para procesar su solicitud.');
	        },
	        501: function(responseObject, textStatus, errorThrown) {
				alert('La evaluación solicitada posiblemente fué eliminada. <strong>[HTTP 501]</strong>');
	        },
	        200: function(responseObject, textStatus, errorThrown) {
	        	$("#lblMotivoApelacion").html(responseObject);
	        }
	    }
	});
}


// OK
function detallesEvaluacion() {
	var evaluacion = $("#irqljob").val();
	var tipo 		= $("#irqltype").val();

	if(tipo == 1) {
		$.ajax({
		    type: 'post',
		    url: 'core/ParcialInfo.php',
		    data: {"evaluacion" : evaluacion},
		    statusCode: {
		        404: function(responseObject, textStatus, jqXHR) {
		            $("#lblObservacionEvaluacion").html('Ha ocurrido un error al intentar encontrar el core que procesa su solicitud. Por favor intentelo más tarde <strong>[HTTP 404]</strong>');
		            $("#modalHomeBtnCerrar").click();
		        },
		        500: function(responseObject, textStatus, errorThrown) {
		            alert('No se ha recibido el parámetro con la evaluación parcial <strong>[HTTP 500]</strong>');
		            $("#modalHomeBtnCerrar").click();
		        },
		        501: function(responseObject, textStatus, errorThrown) {
					alert('La evaluación solicitada posiblemente fué eliminada. <strong>[HTTP 501]</strong>');
					 $("#modalHomeBtnCerrar").click();
		        },
		        200: function(responseObject, textStatus, errorThrown) {
		        	respuesta = JSON.parse(responseObject);
		        	switch(respuesta.estado) {
		        		case 1:
		        			$("#entrarAProceso").show();
							$("#entrarAProcesoLabel").show();
		        			$("#txtEstadoEvaluacion").val('1: Generada');
		        			$("#entrarAProcesoLabel").html('<strong>Enviar a revisión</strong>');
		        			$("#btnEjecutarProceso").html('Enviar a Revisión');
		        			$("#btnEjecutarProceso").attr('evaluacion', evaluacion);
							$("#btnEjecutarProceso").attr('tipo_evaluacion', tipo);
		        		break;

		        		case 2:
		        			$("#txtEstadoEvaluacion").val('2: En Revisión');
		        			$("#entrarAProceso").hide();
							$("#entrarAProcesoLabel").hide();
		        		break;

		        		case 4:
		        			$("#txtEstadoEvaluacion").val('4: Corregida');
		        			$("#entrarAProcesoLabel").html('<strong>Enviar a revisión</strong>');
		        			$("#btnEjecutarProceso").html('Enviar a Revisión');
		        			$("#entrarAProceso").show();
							$("#entrarAProcesoLabel").show();
		        		break;

		        		case 5:
		        			$("#txtEstadoEvaluacion").val('5: Disponible');
		        			$("#entrarAProceso").hide();
							$("#entrarAProcesoLabel").hide();
		        		break;

		        		case 6:
		        			cargarMotivoApelacion();
		        			$("#txtEstadoEvaluacion").val('6: Apelada');
		        			$("#btnEjecutarProceso").attr('evaluacion', evaluacion);
							$("#btnEjecutarProceso").attr('tipo_evaluacion', tipo);
							$("#headingFive").show();
							$("#btnAprobarApelacion").show();
							$("#btnRechazarApelacion").show();
		        		break;

		        		case 7:
		        			$("#txtEstadoEvaluacion").val('7: Apelación Aceptada');
		        			$("#btnEjecutarProceso").html('Rechazar Apelación');
		        			$("div.ql-toolbar.ql-snow").show();
							$("#btnEjecutarProceso").show();
		        		break;

		        		case 8:
		        			$("#txtEstadoEvaluacion").val('8: Apelación Terminada');
		        		break;

		        		case 9:
		        			$("#txtEstadoEvaluacion").val('9: Conformidad');
		        		break;
		        	}

		        	
		        }
		    }
		});
	}else if(tipo == 2){
		$.ajax({
		    type: 'post',
		    url: 'core/QuincenalInfo.php',
		    data: {"evaluacion" : evaluacion},
		    statusCode: {
		        404: function(responseObject, textStatus, jqXHR) {
		            $("#lblObservacionEvaluacion").html('Ha ocurrido un error al intentar encontrar el core que procesa su solicitud. Por favor intentelo más tarde <strong>[HTTP 404]</strong>');
		            $("#modalHomeBtnCerrar").click();
		        },
		        500: function(responseObject, textStatus, errorThrown) {
		            alert('No se ha recibido el parámetro con la evaluación parcial <strong>[HTTP 500]</strong>');
		            $("#modalHomeBtnCerrar").click();
		        },
		        501: function(responseObject, textStatus, errorThrown) {
					alert('La evaluación solicitada posiblemente fué eliminada. <strong>[HTTP 501]</strong>');
					 $("#modalHomeBtnCerrar").click();
		        },
		        200: function(responseObject, textStatus, errorThrown) {
		        	respuesta = JSON.parse(responseObject);
		        	switch(respuesta.estado) {
		        		case 1:
		        			$("#entrarAProceso").show();
							$("#entrarAProcesoLabel").show();
		        			$("#txtEstadoEvaluacion").val('1: Generada');
		        			$("#entrarAProcesoLabel").html('<strong>Enviar a revisión</strong>');
		        			$("#btnEjecutarProceso").html('Enviar a Revisión');
		        			$("#btnEjecutarProceso").attr('evaluacion', evaluacion);
							$("#btnEjecutarProceso").attr('tipo_evaluacion', tipo);
		        		break;

		        		case 2:
		        			$("#txtEstadoEvaluacion").val('2: En Revisión');
		        			$("#entrarAProceso").hide();
							$("#entrarAProcesoLabel").hide();
		        		break;

		        		case 4:
		        			$("#txtEstadoEvaluacion").val('4: Corregida');
		        			$("#entrarAProcesoLabel").html('<strong>Enviar a revisión</strong>');
		        			$("#btnEjecutarProceso").html('Enviar a Revisión');
		        			$("#entrarAProceso").show();
							$("#entrarAProcesoLabel").show();
		        		break;

		        		case 5:
		        			$("#txtEstadoEvaluacion").val('5: Disponible');
		        			$("#entrarAProceso").hide();
							$("#entrarAProcesoLabel").hide();
		        		break;

		        		case 6:
		        			cargarMotivoApelacion();
		        			$("#txtEstadoEvaluacion").val('6: Apelada');
							$("#headingFive").show();
							$("#btnAprobarApelacion").show();
							$("#btnRechazarApelacion").show();
							$("#btnEjecutarProceso").attr('evaluacion', evaluacion);
							$("#btnEjecutarProceso").attr('tipo_evaluacion', tipo);
		        		break;

		        		case 7:
		        			$("#txtEstadoEvaluacion").val('7: Apelación Aceptada');
		        			$("#btnEjecutarProceso").html('Rechazar Apelación');
		        			$("div.ql-toolbar.ql-snow").show();
							$("#btnEjecutarProceso").show();
		        		break;

		        		case 8:
		        			$("#txtEstadoEvaluacion").val('8: Apelación Terminada');
		        		break;

		        		case 9:
		        			$("#txtEstadoEvaluacion").val('9: Conformidad');
		        		break;
		        	}

		        	
		        }
		    }
		});
	}else{
		$.ajax({
		    type: 'post',
		    url: 'core/FinalInfo.php',
		    data: {"evaluacion" : evaluacion},
		    statusCode: {
		        404: function(responseObject, textStatus, jqXHR) {
		            $("#lblObservacionEvaluacion").html('Ha ocurrido un error al intentar encontrar el core que procesa su solicitud. Por favor intentelo más tarde <strong>[HTTP 404]</strong>');
		            $("#modalHomeBtnCerrar").click();
		        },
		        500: function(responseObject, textStatus, errorThrown) {
		            alert('No se ha recibido el parámetro con la evaluación parcial <strong>[HTTP 500]</strong>');
		            $("#modalHomeBtnCerrar").click();
		        },
		        501: function(responseObject, textStatus, errorThrown) {
					alert('La evaluación solicitada posiblemente fué eliminada. <strong>[HTTP 501]</strong>');
					 $("#modalHomeBtnCerrar").click();
		        },
		        200: function(responseObject, textStatus, errorThrown) {
		        	respuesta = JSON.parse(responseObject);
		        	switch(respuesta.estado) {
		        		case 1:
		        			$("#entrarAProceso").show();
							$("#entrarAProcesoLabel").show();
		        			$("#txtEstadoEvaluacion").val('1: Generada');
		        			$("#entrarAProcesoLabel").html('<strong>Enviar a revisión</strong>');
		        			$("#btnEjecutarProceso").html('Enviar a Revisión');
		        			$("#btnEjecutarProceso").attr('evaluacion', evaluacion);
							$("#btnEjecutarProceso").attr('tipo_evaluacion', tipo);
		        		break;

		        		case 2:
		        			$("#txtEstadoEvaluacion").val('2: En Revisión');
		        			$("#entrarAProceso").hide();
							$("#entrarAProcesoLabel").hide();
		        		break;

		        		case 4:
		        			$("#txtEstadoEvaluacion").val('4: Corregida');
		        			$("#entrarAProcesoLabel").html('<strong>Enviar a revisión</strong>');
		        			$("#btnEjecutarProceso").html('Enviar a Revisión');
		        			$("#entrarAProceso").show();
							$("#entrarAProcesoLabel").show();
		        		break;

		        		case 5:
		        			$("#txtEstadoEvaluacion").val('5: Disponible');
		        			$("#entrarAProceso").hide();
							$("#entrarAProcesoLabel").hide();
		        		break;

		        		case 6:
		        			cargarMotivoApelacion();
		        			$("#txtEstadoEvaluacion").val('6: Apelada');
		        			$("#btnEjecutarProceso").attr('evaluacion', evaluacion);
							$("#btnEjecutarProceso").attr('tipo_evaluacion', tipo);
							$("#headingFive").show();
							$("#btnAprobarApelacion").show();
							$("#btnRechazarApelacion").show();
		        		break;

		        		case 7:
		        			$("#txtEstadoEvaluacion").val('7: Apelación Aceptada');
		        			$("#btnEjecutarProceso").html('Rechazar Apelación');
		        			$("div.ql-toolbar.ql-snow").show();
							$("#btnEjecutarProceso").show();
		        		break;

		        		case 8:
		        			$("#txtEstadoEvaluacion").val('8: Apelación Terminada');
		        		break;

		        		case 9:
		        			$("#txtEstadoEvaluacion").val('9: Conformidad');
		        		break;
		        	}

		        	
		        }
		    }
		});
	}
}