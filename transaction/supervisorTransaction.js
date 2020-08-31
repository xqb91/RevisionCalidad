var tablaEjecutivos;
$(document).ready(function() {

	$('.dropdown-menu').click(function(e) {
	    e.stopPropagation();
	    if ($(e.target).is('[data-toggle=modal]')) {
	        $($(e.target).data('target')).modal()
	    }
	});

	$("#btnAprobar").attr('disabled', 'disabled');
	$("#btnDescargaMasiva").attr('disabled', 'disabled');

	$.ajax({
	    type: 'post',
	    url: 'core/SessionManager.php',
	    beforeSend: function() {
	        //inicializando modal que valida sesión de raulí
	        $("#modalHome").prop('class','modal fade bd-example-modal-sm');
	        $("#modalHomeTitle").text('Espere un momento...');
	        $("#modalHomeCerrarVentana").hide();
	        $("#modalHomeContenido").prop('align', 'center');
	        $("#modalHomeContenido").html('Estamos validando que su sesión del sistema de calidad se encuentre activa<br /><img src="facade/img/loading.gif" alt="cargando" />');
	        $("#modalHomeBtnCerrar").hide();
	        $("#modalHomeBtnAccion").hide();
	        $("#modalHome").modal('show');
	        $("#slcArea").prop('disabled', 'disabled');
	        $("#slcPeriodo").prop('disabled', 'disabled');
	        $("#btnComenzar").prop('disabled', 'disabled');
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

				$("#slcArea").attr('disabled', 'disabled');
				$("#slcPeriodo").attr('disabled', 'disabled');

				//información de evaluador logueado
				$.ajax({
			        type: 'post',
			        url: 'core/InfoSesionEvaluador.php',
			        beforeSend: function() {
						$("#modalHome").modal('show');
			            //inicializando modal que valida sesión de raulí
			            $("#lblEvaluadorLogin").html('<img src="facade/img/loading2.gif" alt="cargando" />');

			        },
			        statusCode: {
			            500: function(responseObject, textStatus, errorThrown) {
			                $("#modalHomeTitle").text('´Problema al cargar el periodo');
			                $("#modalHomeContenido").attr('align', 'left');
			                $("#modalHomeCerrarVentana").show();
			                $("#modalHomeContenido").html('No se encontró respuesta del servidor para los periodos a trabajar<br /><strong>HTTP 404</strong>');
			                $("#modalHomeBtnCerrar").show();
			                $("#modalHomeBtnCerrar").text('Cerrar');
			                $("#modalHomeBtnAccion").hide();
			            },
			            200: function(responseObject, textStatus, errorThrown) {
			                var resultados = JSON.parse(responseObject);
			                $("#lblEvaluadorLogin").html('Hola <strong>'+resultados.nombre_evaluador+'!</strong>');
			                //$("#lblMensajeUsuario").html('Por favor, elige el periodo y área para comenzar a trabajar.');

			                var infoEvaluador = resultados;

							$.ajax({
							    type: 'post',
							    url: 'core/HomeReceiveAreaFromIndex.php',
							    beforeSend: function() {
							        //inicializando modal que valida sesión de raulí
							        $("#modalHomeConfig").attr('class', 'modal-dialog');
							        $("#modalHome").modal('show');
									$("#modalHomeTitle").text('Espere un momento');
									$("#modalHomeBtnCerrar").hide();
									$("#modalHomeCerrarVentana").hide();
									$("#modalHomeBtnAccion").hide();
									$("#modalHomeContenido").html('<img src="facade/img/loading2.gif" /> Recibiendo información...');
							    },
							    statusCode: {
						            404: function(responseObject, textStatus, errorThrown) {
						            	$("#modalHome").modal('show');
						                $("#modalHomeTitle").text('Problema al cargar el periodo');
						                $("#modalHomeContenido").attr('align', 'left');
						                $("#modalHomeCerrarVentana").show();
						                $("#modalHomeContenido").html('No se encontró respuesta del servidor para los periodos a trabajar<br /><strong>HTTP 404</strong>');
						                $("#modalHomeBtnCerrar").show();
						                $("#modalHomeBtnCerrar").text('Cerrar');
						                $("#modalHomeBtnAccion").hide();
						            },
						            200: function(responseObject, textStatus, errorThrown) {
						                var resultados = JSON.parse(responseObject);
						               	$("#slcArea").append('<option value="'+resultados.codigo_area+'">'+resultados.nombre_area+'</option>');
							               	
						               	///************************** obtener el periodo que ejecutivo seleccionó para trabajar ****************************************
										$.ajax({
										    type: 'post',
										    url: 'core/HomeReceivePeriodoFromIndex.php',
										    beforeSend: function() {
										        //inicializando modal que valida sesión de raulí
										        $("#modalHomeContenido").html('<img src="facade/img/loading2.gif" /> Recibiendo información...');
										    },
										    statusCode: {
									            404: function(responseObject, textStatus, errorThrown) {
									            	$("#modalHome").modal('show');
									                $("#modalHomeTitle").text('Problema al cargar el periodo');
									                $("#modalHomeContenido").attr('align', 'left');
									                $("#modalHomeCerrarVentana").show();
									                $("#modalHomeContenido").html('No se encontró respuesta del servidor para los periodos a trabajar<br /><strong>HTTP 404</strong>');
									                $("#modalHomeBtnCerrar").show();
									                $("#modalHomeBtnCerrar").text('Cerrar');
									                $("#modalHomeBtnAccion").hide();
									            },
									            200: function(responseObject, textStatus, errorThrown) {
									                var resultados = JSON.parse(responseObject);
									               
									                 $.each(resultados.periodos, function (index, value) {
									                    //dataArray.push([value["yourID"].toString(), value["yourValue"] ]);
									                    $("#slcPeriodo").append('<option value="'+value+'">'+value+'</option>');
									                }); 

												    // ---- carga de periodos (INIT) -------------- ORIGINAL
												   	$.ajax({
													    type: 'post',
													    url: 'core/ListPeriodosParaEvaluar.php',
													    beforeSend: function() {
													        //inicializando modal que valida sesión de raulí
													        $("#modalHomeContenido").html('<img src="facade/img/loading2.gif" /> Obteniendo periodos válidos para trabajar...');
													    },
													    statusCode: {
												            404: function(responseObject, textStatus, errorThrown) {
												            	$("#modalHome").modal('show');
												                $("#modalHomeTitle").text('Problema al cargar el periodo');
												                $("#modalHomeContenido").attr('align', 'left');
												                $("#modalHomeCerrarVentana").show();
												                $("#modalHomeContenido").html('No se encontró respuesta del servidor para los periodos a trabajar<br /><strong>HTTP 404</strong>');
												                $("#modalHomeBtnCerrar").show();
												                $("#modalHomeBtnCerrar").text('Cerrar');
												                $("#modalHomeBtnAccion").hide();
												            },
												            200: function(responseObject, textStatus, errorThrown) {
												                var resultados = JSON.parse(responseObject);
												               
												                 $.each(resultados.periodos, function (index, value) {
												                    if($("#slcPeriodo :selected").text() != value) {
												                    	$("#slcPeriodo").append('<option value="'+value+'">'+value+'</option>');
												                    }
												                }); 
																$("#slcPeriodo").removeAttr('disabled');

																/// ---- carga de areas (INIT)
													            $.ajax({
																    type: 'post',
																    url: 'core/ListAreas.php',
																    beforeSend: function() {
																        //inicializando modal que valida sesión de raulí
																        $("#modalHomeContenido").html('<img src="facade/img/loading2.gif" /> Recuperando áreas del sistema...');
																    },
																    statusCode: {
															            404: function(responseObject, textStatus, errorThrown) {
															            	$("#modalHome").modal('show');
															                $("#modalHomeTitle").text('Problema al cargar las áreas');
															                $("#modalHomeContenido").attr('align', 'left');
															                $("#modalHomeCerrarVentana").show();
															                $("#modalHomeContenido").html('No se encontró respuesta del servidor para las áreas disponibles para trabajar<br /><strong>HTTP 404</strong>');
															                $("#modalHomeBtnCerrar").show();
															                $("#modalHomeBtnCerrar").text('Cerrar');
															                $("#modalHomeBtnAccion").hide();
															            },
															            200: function(responseObject, textStatus, errorThrown) {
															                var resultados = JSON.parse(responseObject);
															                 $.each(resultados, function (index, value) {
															                   if(infoEvaluador.area == value.codigo_area && $("#slcArea :selected").text() != value.nombre_area) {
		                                                                            $("#slcArea").append('<option value="'+value.codigo_area+'">'+value.nombre_area+'</option>');
		                                                                        }
															                });
															                $("#slcArea").removeAttr('disabled');
															                $("#modalHomeCerrarVentana").hide();
															                actualizarCentroApelaciones();
															                actualizarEstadisticas();

																			$("#slcEjecutivo").attr('style', 'text-transform: capitalize;');
															                $.each(resultados, function (index, value) {
															                    $("#slcEvaluador").append('<option value="'+value.rut+'">'+value.nombre+'</option>');
															                });
															                 //desbloqueando campo evaluador
															                $("#slcEvaluador").removeAttr('disabled');
															                //limpiando campo de ejecutivos diponibles
															                $("#slcEjecutivo").empty();
						                									$("#slcEjecutivo").append('<option value="*">Todos</option>');
														                	var evaluador 	= '*';
																			var periodo 	= $("#slcPeriodo").val();
																			var area 		= $("#slcArea").val();
																			actualizarListadoEjecutivos(periodo, area);
															                setTimeout(function () { refrescarTabla(); $("#modalHomeBtnCerrar").click(); }, 3000);

															            }
															        }
															    });
															}
														}
													});

													///-------- END ORIGINAL --------------------------------
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

	//cambios 
	$("#slcEjecutivo").change(function() {
		var evaluador 	= $("#slcEjecutivo :selected").val();
		var periodo 	= $("#slcPeriodo :selected").val();
		var area 		= $("#slcArea :selected").val();
		refrescarTabla();
		actualizarEstadisticas();
	});

	$("#slcEstado").change(function() {
		var evaluador 	= $("#slcEjecutivo :selected").val();
		var periodo 	= $("#slcPeriodo :selected").val();
		var area 		= $("#slcArea :selected").val();
		refrescarTabla();
		actualizarEstadisticas();
	})
});

function actualizarListadoEjecutivos(periodo, area) {
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
	        	$.ajax({
				    type: 'post',
				    url: 'core/ListEjecutivosEvaluados.php',
				    data: {"periodo" : periodo,  "area" : area},
				    beforeSend: function() {
				    },
				    statusCode: {
			            404: function(responseObject, textStatus, errorThrown) {
			            	$("#modalHome").modal('show');
			                $("#modalHomeTitle").text('Problema al cargar las áreas');
			                $("#modalHomeContenido").attr('align', 'left');
			                $("#modalHomeCerrarVentana").show();
			                $("#modalHomeContenido").html('No se encontró respuesta del servidor para las áreas disponibles para trabajar<br /><strong>HTTP 404</strong>');
			                $("#modalHomeBtnCerrar").show();
			                $("#modalHomeBtnCerrar").text('Cerrar');
			                $("#modalHomeBtnAccion").hide();
			            },
			            301: function(responseObject, textStatus, errorThrown) {
							$("#tablaEvaluaciones tbody").empty();
			               	$("#tablaEvaluaciones tbody").append('<td style="font-size: 12px; text-align:center;" colspan="6"><i class="fas fa-exclamation-triangle"></i> <strong>No se han encontrado evaluaciones para los filtros aplicados en el periodo '+$("#slcPeriodo :selected").val()+'.</strong></td>');
			            },
			            200: function(responseObject, textStatus, errorThrown) {
			                var resultados = JSON.parse(responseObject);
			                $("#slcEjecutivo").empty();
			                $("#slcEjecutivo").append('<option value="*" style="text-transform: capitalize;">Todos</option>');
			                 $.each(resultados, function (index, value) {
			                    $("#slcEjecutivo").append('<option value="'+value.rut+'" style="text-transform: capitalize;">'+value.nombre+'</option>');
			                });
			                $("#slcEjecutivo").removeAttr('disabled');
			            }
			        }
			    });
	        }
	    }
	});
}

function refrescarTabla() {
	var evaluador 	= $("#slcEvaluador").val();
	var periodo 	= $("#slcPeriodo").val();
	var area 		= $("#slcArea").val();
	var ejecutivo   = $("#slcEjecutivo").val();
	var estado 		= $("#slcEstado").val();

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
	        	$.ajax({
				    type: 'post',
				    url: 'core/ListEvaluaciones.php',
				    data: {"periodo" : periodo, "evaluador" : evaluador, "area" : area, "ejecutivo" : ejecutivo, "estado" : estado },
				    beforeSend: function() {
				        //inicializando modal que valida sesión de raulí
				    },
				    statusCode: {
			            404: function(responseObject, textStatus, errorThrown) {
			            	$("#modalHome").modal('show');
			                $("#modalHomeTitle").text('Problema al cargar las áreas');
			                $("#modalHomeContenido").attr('align', 'left');
			                $("#modalHomeCerrarVentana").show();
			                $("#modalHomeContenido").html('No se encontró respuesta del servidor para las áreas disponibles para trabajar<br /><strong>HTTP 404</strong>');
			                $("#modalHomeBtnCerrar").show();
			                $("#modalHomeBtnCerrar").text('Cerrar');
			                $("#modalHomeBtnAccion").hide();
			                $("#btnAprobar").attr('disabled', 'disabled');
							$("#btnDescargaMasiva").attr('disabled', 'disabled');
							$("#btnAprobar").html('<i class="fas fa-vote-yea"></i> <strong>Aprobar Evaluaciones</strong>');
			            },
			            301: function(responseObject, textStatus, errorThrown) {
			                $("#tablaEvaluaciones tbody").empty();
			               	$("#tablaEvaluaciones tbody").append('<td style="font-size: 12px; text-align:center;" colspan="6"><i class="fas fa-exclamation-triangle"></i> <strong>No hay evaluaciones diponibles con los filtros utilizados</strong></td>');
			               	$("#btnAprobar").attr('disabled', 'disabled');
							$("#btnDescargaMasiva").attr('disabled', 'disabled');
							$("#btnAprobar").html('<i class="fas fa-vote-yea"></i> <strong>Aprobar Evaluaciones</strong>');
			            },
			            200: function(responseObject, textStatus, errorThrown) {
			                var resultados = JSON.parse(responseObject);
			                if($("#slcEjecutivo :selected").val() == '*') {
	        					$("#btnAprobar").attr('disabled', 'disabled');
								$("#btnDescargaMasiva").attr('disabled', 'disabled');
	        				}else{
				                $("#btnAprobar").removeAttr('disabled');
								$("#btnDescargaMasiva").removeAttr('disabled');
							}
			                $("#tablaEvaluaciones tbody").empty();

			                var auxCountQuincenal 	= 0;
			                var auxCountFinal 		= 0;
			                var lockBloqueoAprobar  = 1;

			                $.each(resultados, function(i,x) {
			                	var color = "";
			                	if(x.estado == 1) {
		                			color = color + 'class="table"';
		                		}if(x.estado == 2) {
		                			color = color + 'class="table-warning">';
		                		}if(x.estado == 4) {
		                			color = color + 'class="table-success">';
		                		}if(x.estado == 5) {
		                			color = color + 'class="table-primary">';
		                		}if(x.estado == 6) {
		                			color = color + 'class="table-danger">';
		                		}if(x.estado == 7) {
		                			color = color + 'class="table-dark">';
		                		}if(x.estado == 8) {
		                			color = color + 'class="table-danger">';
		                		}if(x.estado == 9) {
		                			color = color + 'class="table-info">';
		                		}
			                	var cadena = '<tr '+color+' style="font-size: 12px;">';
			                	cadena = cadena + '';
			                	
			                	// Tipo de Evaluación
			                	if(x.tipo == 3) { 
			                		cadena = cadena + '<td>Evaluación Final<br /><span class="badge badge-secondary" style = "text-transform:capitalize;"><i class="fas fa-user"></i> '+x.nombre_ejecutivo+'</span>';
			                		if(x.estado == 1) {
			                			cadena = cadena + '<span class="badge badge-primary">Generada</span>';
			                		}if(x.estado == 2) {
			                			cadena = cadena + '<span class="badge badge-warning">En Revisión</span>';
			                		}if(x.estado == 4) {
			                			cadena = cadena + '<span class="badge badge-success">Corregida</span>';
			                		}if(x.estado == 5) {
			                			cadena = cadena + '<span class="badge badge-light">Disponible</span>';
			                		}if(x.estado == 6) {
			                			cadena = cadena + '<span class="badge badge-danger">Apelada</span>';
			                		}if(x.estado == 7) {
			                			cadena = cadena + '<span class="badge badge-dark">Apelación Aceptada</span>';
			                		}if(x.estado == 8) {
			                			cadena = cadena + '<span class="badge badge-danger">Apelación Terminada</span>';
			                		}if(x.estado == 9) {
			                			cadena = cadena + '<span class="badge badge-info">Conformidad</span>';
			                		}
			                		cadena = cadena + '</td>'; 
			                	}else if(x.tipo == 2) { 
			                		cadena = cadena + '<td style="font-size: 12px;">Evaluación Quincenal<br /><span class="badge badge-secondary" style = "text-transform:capitalize;"><i class="fas fa-user"></i> '+x.nombre_ejecutivo+'</span>';
			                		if(x.estado == 1) {
			                			cadena = cadena + '<span class="badge badge-primary">Generada</span>';
			                		}if(x.estado == 2) {
			                			cadena = cadena + '<span class="badge badge-warning">En Revisión</span>';
			                		}if(x.estado == 4) {
			                			cadena = cadena + '<span class="badge badge-success">Corregida</span>';
			                		}if(x.estado == 5) {
			                			cadena = cadena + '<span class="badge badge-light">Disponible</span>';
			                		}if(x.estado == 6) {
			                			cadena = cadena + '<span class="badge badge-danger">Apelada</span>';
			                		}if(x.estado == 7) {
			                			cadena = cadena + '<span class="badge badge-dark">Apelación Aceptada</span>';
			                		}if(x.estado == 8) {
			                			cadena = cadena + '<span class="badge badge-danger">Apelación Terminada</span>';
			                		}if(x.estado == 9) {
			                			cadena = cadena + '<span class="badge badge-info">Conformidad</span>';
			                		}
			                		cadena = cadena + '</td>'; 
			                	}else{ 
			                		cadena = cadena + '<td style="font-size: 12px;">Evaluación Parcial<br /><span class="badge badge-secondary" style = "text-transform:capitalize;"><i class="fas fa-user"></i> '+x.nombre_ejecutivo+'</span>';
			                		if(x.estado == 1) {
			                			cadena = cadena + '<span class="badge badge-primary">Generada</span>';
			                		}if(x.estado == 2) {
			                			cadena = cadena + '<span class="badge badge-warning">En Revisión</span>';
			                		}if(x.estado == 4) {
			                			cadena = cadena + '<span class="badge badge-success">Corregida</span>';
			                		}if(x.estado == 5) {
			                			cadena = cadena + '<span class="badge badge-light">Disponible</span>';
			                		}if(x.estado == 6) {
			                			cadena = cadena + '<span class="badge badge-danger">Apelada</span>';
			                		}if(x.estado == 7) {
			                			cadena = cadena + '<span class="badge badge-dark">Apelación Aceptada</span>';
			                		}if(x.estado == 8) {
			                			cadena = cadena + '<span class="badge badge-danger">Apelación Terminada</span>';
			                		}if(x.estado == 9) {
			                			cadena = cadena + '<span class="badge badge-info">Conformidad</span>';
			                		}
			                		cadena = cadena + '</td>';  
			                	}
			                    // Detalle de la evaluación
			                    if(x.entrega == 'quincenal') {
		                    		auxCountQuincenal = 1;
		                    	}else if(x.entrega == 'final') {
		                    		auxCountFinal = 1;
		                    	}

			                    if(x.orden == -1) {
			                    	cadena = cadena + '<td style="font-size: 12px;">Evaluación <strong>'+x.evaluacion+'</strong><br /><span class="badge badge-primary"><i class="fas fa-user-tie"></i> Creada el '+x.fecha_creacion+' por '+x.nombre_evaluador+' para el periodo: '+x.periodo+'</span></td>';	
			                    }else{
			                    	cadena = cadena + '<td style="font-size: 12px;"><strong>'+x.orden+'° Evaluación</strong> (# '+x.evaluacion+')<br /><span class="badge badge-primary"><i class="fas fa-user-tie"></i> Creada el '+x.fecha_creacion+' por '+x.nombre_evaluador+' para el periodo: '+x.periodo+'</span></td>';
			                    }
			                    
			                    //bloqueo de boton de aprobación
			                    if(x.tipo == 3 && x.estado != 9 && $("#slcEjecutivo :selected").val() != '*') {
			                    	lockBloqueoAprobar = 0;
			                    	$("#btnAprobar").removeAttr('disabled');
			                    }

			                    cadena = cadena + '<td style="font-size: 12px;">'+x.nota.toFixed(2)+'</td>';
			                    cadena = cadena + '<td style="font-size: 12px;">'+x.periodo+'</td>';
			                    if(x.estado == 9) {
			                    	if(lockBloqueoAprobar == 1) {
			                    		$("#btnAprobar").prop('disabled', 'disabled');
			                    	}
			                    	cadena = cadena + '<td><div class="btn-group btn-group-sm" role="group" aria-label="Basic example"><button type="button" id="btnDetalle" evaluacion="'+x.evaluacion+'" tipo="'+x.tipo+'" class="btn btn-secondary" title="Ver PDF"><i class="far fa-eye"></i></button><button type="button" id="btnHistorial" evaluacion="'+x.evaluacion+'" tipo="'+x.tipo+'" class="btn btn-secondary" title="Historial de la Evaluación"><i class="fas fa-history"></i></button><button type="button" disabled="disabled" id="btnOpciones" evaluacion="'+x.evaluacion+'" tipo="'+x.tipo+'" class="btn btn-danger" title="Apelar Evaluación"><i class="fas fa-angry"></i></button><button type="button" id="btnPDF" evaluacion="'+x.evaluacion+'"  tipo="'+x.tipo+'" class="btn btn-secondary"><i class="fas fa-download"></i> PDF</button></div></td>';
			                    }else{
			                    	cadena = cadena + '<td><div class="btn-group btn-group-sm" role="group" aria-label="Basic example"><button type="button" id="btnDetalle" evaluacion="'+x.evaluacion+'" tipo="'+x.tipo+'" class="btn btn-secondary" title="Detalles de la evaluación como audio y PDF"><i class="far fa-eye"></i></button><button type="button" id="btnHistorial" evaluacion="'+x.evaluacion+'" tipo="'+x.tipo+'" class="btn btn-secondary" title="Historial de la Evaluación"><i class="fas fa-history"></i></button><button type="button" id="btnOpciones" evaluacion="'+x.evaluacion+'" tipo="'+x.tipo+'" class="btn btn-danger" title="Apelar Evaluación"><i class="fas fa-angry"></i></button><button type="button" id="btnPDF" evaluacion="'+x.evaluacion+'"  tipo="'+x.tipo+'" class="btn btn-secondary"><i class="fas fa-download"></i> PDF</button></div></td>';
			                    }
			                    cadena = cadena + '</tr>';
			                    $("#tablaEvaluaciones tbody").append(cadena);
			                });
							
							if($("#slcEjecutivo :selected").val() == '*') {
								$("#btnAprobar").html('<i class="fas fa-vote-yea"></i> <strong>Aprobar Evaluaciones</strong>');
							}else{
								if(auxCountFinal== 1 && !$("#btnAprobar").is('disabled')) {
									$("#btnAprobar").html('<i class="fas fa-vote-yea"></i> <strong>Aprobar a nivel final</strong>');
								}else if(auxCountQuincenal == 1 && !$("#btnAprobar").is('disabled')) {
									$("#btnAprobar").html('<i class="fas fa-vote-yea"></i> <strong>Aprobar a nivel quincenal</strong>');
								}else{
									$("#btnAprobar").html('<i class="fas fa-vote-yea"></i> <strong>Aprobar Evaluaciones</strong>');
								}
							}

							$("button#btnDetalle.btn.btn-secondary").click(function() {
								if($(this).attr('tipo')== 1) {
									detallesEvaluacion($(this).attr('evaluacion'), 1);
								}else if($(this).attr('tipo')== 2) {
									detallesEvaluacion($(this).attr('evaluacion'), 2);
								}else{
									detallesEvaluacion($(this).attr('evaluacion'), 3);
								}
							});

							$("button#btnHistorial.btn.btn-secondary").click(function() {
								if($(this).attr('tipo')== 1) {
									historial($(this).attr('evaluacion'), 1);
								}else if($(this).attr('tipo')== 2) {
									historial($(this).attr('evaluacion'), 2);
								}else{
									historial($(this).attr('evaluacion'), 3);
								}
							});

							$("button#btnOpciones.btn.btn-danger").click(function() {
								if($(this).attr('tipo')== 1) {
									opcionesEvaluacion($(this).attr('evaluacion'), 1);
								}else if($(this).attr('tipo')== 2) {
									opcionesEvaluacion($(this).attr('evaluacion'), 2);
								}else{
									opcionesEvaluacion($(this).attr('evaluacion'), 3);
								}
							});


							$("button#btnPDF.btn.btn-secondary").click(function() {
								if($(this).attr('tipo')== 1) {
									descargarPDF($(this).attr('evaluacion'), 1);
								}else if($(this).attr('tipo')== 2) {
									descargarPDF($(this).attr('evaluacion'), 2);
								}else{
									descargarPDF($(this).attr('evaluacion'), 3);
								}
							});

			            }
			        }
			    });
	        }
	    }
	});
}

function detallesEvaluacion(evaluacion, tipo) {
	$("#modalHomeConfig").attr('class', 'modal-dialog modal-xl');
	$("#modalHome").modal('show');
    $("#modalHomeTitle").html('Detalles de la Evaluación '+evaluacion+'');
    $("#modalHomeContenido").attr('align', 'left');
    $("#modalHomeCerrarVentana").show();
    $("#modalHomeContenido").load('detalle.php?evaluacion='+evaluacion+'&tipo='+tipo);
    $("#modalHomeBtnCerrar").show();
    $("#modalHomeBtnCerrar").text('Cerrar');
    $("#modalHomeBtnAccion").hide();
}

function historial(evaluacion, tipo) {
	$("#modalHomeConfig").attr('class', 'modal-dialog modal-xl');
	$("#modalHome").modal('show');
    $("#modalHomeTitle").html('Historial de la evaluación  '+evaluacion+'');
    $("#modalHomeContenido").attr('align', 'left');
    $("#modalHomeCerrarVentana").show();
    $("#modalHomeContenido").load('historial.php?evaluacion='+evaluacion+'&tipo='+tipo);
    $("#modalHomeBtnCerrar").show();
    $("#modalHomeBtnCerrar").text('Cerrar');
    $("#modalHomeBtnAccion").hide();	
}

function opcionesEvaluacion(evaluacion, tipo) {
	$("#modalHomeConfig").attr('class', 'modal-dialog modal-xl');
	$("#modalHome").modal('show');
    $("#modalHomeTitle").html('Apelar la Evaluación '+evaluacion+'');
    $("#modalHomeContenido").attr('align', 'left');
    $("#modalHomeCerrarVentana").show();
    $("#modalHomeContenido").load('apelar.php?evaluacion='+evaluacion+'&tipo='+tipo);
    $("#modalHomeBtnCerrar").show();
    $("#modalHomeBtnCerrar").text('Cerrar');
    $("#modalHomeBtnAccion").hide();
}

function descargarPDF(evaluacion, tipo) {
	switch(tipo) {
		case 1:
			//evaluacion parcial
			window.location.href="../../calidad/core/pdfGenerate.php?evaluacion="+evaluacion+"&tipo=parcial&accion=descargar";
		break;
		
		case 2:
			//quincenal
			window.location.href="../../calidad/core/pdfGenerate.php?evaluacion="+evaluacion+"&tipo=quincenal&accion=descargar";
		break;

		case 3:
			//final
			window.location.href="../../calidad/core/pdfGenerate.php?evaluacion="+evaluacion+"&tipo=final&accion=descargar";
		break;
	}
}

function actualizarEstadisticas() {
	$.ajax({
        type: 'post',
        url: 'core/ListEstadisticas.php',
		error: function(XMLHttpRequest, textStatus, errorThrown) {
		    if (XMLHttpRequest.readyState == 0) {
				$("#modalHomeConfig").attr('class', 'modal-dialog');
				$("#modalHomeTitle").text('Verifique su conexión a internet');
				$("#modalHomeContenido").attr('align', 'left');
				$("#modalHomeCerrarVentana").show();
				$("#modalHomeContenido").html('No se pudo establecer una conexión con el servidor del sistema de calidad y por lo tanto su solicitud no pudo ser procesada. <br /><strong>Por favor, verifique que la conexión de su ordenador se encuentre en orden, si usted se conecta vía Wi-Fi intente acercase al router para aumentar la señal o valique estar conectado a su red. Si ya ha intentado todo lo anterior, solicite ayuda llamando a la mesa de ayuda de tricot al anexo 616 o desde celulares al 2 2350 3616</strong>');
				$("#modalHomeBtnCerrar").show();
				$("#modalHomeBtnCerrar").text('Cerrar');
				$("#modalHomeBtnAccion").hide();
		    }
		},
        statusCode: {
            200: function(responseObject, textStatus, errorThrown) {
            	var respuesta = JSON.parse(responseObject);

            	$.each(respuesta, function(i,x ) {
            		switch(x.item) {
            			case 'ejecutivos':
            				$("#lblTotalEnProceso").html(x.total);
            			break;

            			case 'disponibles':
            				$("#lblTotalEnRevision").html(x.total);
            			break;

            			case 'aceptadas':
            				$("#lblTotalCorregidas").html(x.total);
            			break;

            			case 'terminadas':
            				$("#lblTotalApeladas").html(x.total);
            			break;

            			case 'cerradas':
            				cerradas = x.total;
            			break;
            		}
            	});
            	$("#lblTotalCerradas").html(cerradas+'%');
            	$("#lblTotalEnProcesoBar").attr('style', 'width: '+parseInt(cerradas)+'%');
            	
            }
        }
    });
}

function actualizarCentroApelaciones() {
	$.ajax({
        type: 'post',
        url: 'core/ListApelaciones.php',
        beforeSend: function() {
        },
		error: function(XMLHttpRequest, textStatus, errorThrown) {
		    if (XMLHttpRequest.readyState == 0) {
				$("#modalHomeConfig").attr('class', 'modal-dialog');
				$("#modalHomeTitle").text('Verifique su conexión a internet');
				$("#modalHomeContenido").attr('align', 'left');
				$("#modalHomeCerrarVentana").show();
				$("#modalHomeContenido").html('No se pudo establecer una conexión con el servidor del sistema de calidad y por lo tanto su solicitud no pudo ser procesada. <br /><strong>Por favor, verifique que la conexión de su ordenador se encuentre en orden, si usted se conecta vía Wi-Fi intente acercase al router para aumentar la señal o valique estar conectado a su red. Si ya ha intentado todo lo anterior, solicite ayuda llamando a la mesa de ayuda de tricot al anexo 616 o desde celulares al 2 2350 3616</strong>');
				$("#modalHomeBtnCerrar").show();
				$("#modalHomeBtnCerrar").text('Cerrar');
				$("#modalHomeBtnAccion").hide();
		    }
		},
        statusCode: {
            200: function(responseObject, textStatus, errorThrown) {
            	var respuesta = JSON.parse(responseObject);
            	$("#lblApelacionesCounter").html(respuesta.length);
            	var cadena = "";
            	$.each(respuesta, function(i,x) {
            		cadena = cadena +'<a class="dropdown-item d-flex align-items-center" href="#">';
            		cadena = cadena +'<div class="mr-3">';
            		cadena = cadena +'<div class="icon-circle bg-primary">';
            		cadena = cadena +'<i class="fas fa-comment-dots"></i>';
            		cadena = cadena +'</div>';
            		cadena = cadena +'</div>';
            		cadena = cadena +'<div>';
            		cadena = cadena +'<div class="small text-gray-500">Creada el '+x.fecha+' (Periodo: '+x.periodo+')</div>';
            		if(x.tipo == 1) {
            			cadena = cadena +'<span class="font-weight-bold">Evaluación Parcial #'+x.evaluacion+' de '+x.nombre_ejecutivo+'</span>';
            		}else if(x.tipo == 2) {
						cadena = cadena +'<span class="font-weight-bold">Evaluación Quincenal #'+x.evaluacion+' de '+x.nombre_ejecutivo+'</span>';
            		}else{
            			cadena = cadena +'<span class="font-weight-bold">Evaluación Final #'+x.evaluacion+' de '+x.nombre_ejecutivo+'</span>';
            		}

            		cadena = cadena +'</div>';
            		cadena = cadena +'</a>';
            	});
            	$("#lblCentroNotificaciones").html(cadena);
            }
        }
    });
}

$("#modalHomeBtnAccion").click(function() {
	if ($("#modalHomeBtnAccion").text() == "Iniciar Sesión") {
		window.location.href="index.php";
	}else if ($("#modalHomeBtnAccion").text() == "Iniciar sesión nuevamente!") {
		window.location.href="index.php";
	}else if ($("#modalHomeBtnAccion").text() == "Aprobar Quincenales") {
		var evaluador 	= $("#slcEvaluador").val();
		var periodo 	= $("#slcPeriodo").val();
		var area 		= $("#slcArea").val();
		var ejecutivo   = $("#slcEjecutivo").val();
		var estado 		= $("#slcEstado").val();
		$.ajax({
		    type: 'post',
		    url: 'core/SessionManager.php',
		    beforeSend: function() {
		    	$("#modalHome").modal('show');
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
		        	$.ajax({
					    type: 'post',
					    url: 'core/AprobacionStatus.php',
					    data: {'ejecutivo' : ejecutivo, 'periodo' : periodo, 'tipo' : 'quincenal'},
					    beforeSend: function() {

					    },
					    statusCode: {
					        500: function(responseObject, textStatus, jqXHR) {
					            $("#modalHomeTitle").text('Error');
					            $("#modalHomeContenido").attr('align', 'left');
					            $("#modalHomeCerrarVentana").show();
					            $("#modalHomeContenido").html('El sistema no encontró las evaluaciones parciales asociadas al ejecutivo');
					            $("#modalHomeBtnCerrar").hide();
					            $("#modalHomeBtnCerrar").text('Cerrar');
					            $("#modalHomeBtnAccion").text('Iniciar sesión nuevamente!');
					            $("#modalHomeBtnAccion").hide();
					            return 0;
					        },
					        501: function(responseObject, textStatus, errorThrown) {
					            $("#modalHomeTitle").text('Error');
					            $("#modalHomeContenido").attr('align', 'left');
					            $("#modalHomeCerrarVentana").hide();
					            $("#modalHomeContenido").html('El sistema no encontró las evaluaciones quincenales asociadas al ejecutivo');
					            $("#modalHomeBtnCerrar").hide();
					            $("#modalHomeBtnCerrar").text('Cerrar');
					            $("#modalHomeBtnAccion").text('Iniciar sesión nuevamente!');
					            $("#modalHomeBtnAccion").hide();
					            return 0;
					        },
					        502: function(responseObject, textStatus, errorThrown) {
					            $("#modalHomeTitle").text('Error');
					            $("#modalHomeContenido").attr('align', 'left');
					            $("#modalHomeCerrarVentana").show();
					            $("#modalHomeContenido").html('El sistema no encontró las evaluaciones finales asociadas al ejecutivo');
					            $("#modalHomeBtnCerrar").hide();
					            $("#modalHomeBtnCerrar").text('Cerrar');
					            $("#modalHomeBtnAccion").text('Iniciar sesión nuevamente!');
					            $("#modalHomeBtnAccion").hide();
					            return 0;
					        },
					        400: function(responseObject, textStatus, errorThrown) {
					            $("#modalHomeTitle").text('Tenemos un problema!');
					            $("#modalHomeContenido").attr('align', 'left');
					            $("#modalHomeCerrarVentana").show();
					            $("#modalHomeContenido").html('Existe una o varias evaluaciones parciales que se encuentran en revisión e impiden la aprobación de las evaluaciones');
					            $("#modalHomeBtnCerrar").hide();
					            $("#modalHomeBtnCerrar").text('Cerrar');
					            $("#modalHomeBtnAccion").text('Iniciar sesión nuevamente!');
					            $("#modalHomeBtnAccion").hide();
					            return 0;
					        },
					        401: function(responseObject, textStatus, errorThrown) {
					            $("#modalHomeTitle").text('Tenemos un problema!');
					            $("#modalHomeContenido").attr('align', 'left');
					            $("#modalHomeCerrarVentana").show();
					            $("#modalHomeContenido").html('Existe una o varias evaluaciones parciales que se encuentran en proceso de apelación e impiden la aprobación de las evaluaciones');
					            $("#modalHomeBtnCerrar").hide();
					            $("#modalHomeBtnCerrar").text('Cerrar');
					            $("#modalHomeBtnAccion").text('Iniciar sesión nuevamente!');
					            $("#modalHomeBtnAccion").hide();
					            return 0;
					        },
					        402: function(responseObject, textStatus, errorThrown) {
					            $("#modalHomeTitle").text('Tenemos un problema!');
					            $("#modalHomeContenido").attr('align', 'left');
					            $("#modalHomeCerrarVentana").show();
					            $("#modalHomeContenido").html('Existe una o varias evaluaciones parciales que ya se cerradas. <strong>No se pueden cerrar evaluaciones que ya estan cerradas.</strong>');
					            $("#modalHomeBtnCerrar").hide();
					            $("#modalHomeBtnCerrar").text('Cerrar');
					            $("#modalHomeBtnAccion").text('Iniciar sesión nuevamente!');
					            $("#modalHomeBtnAccion").hide();
					            return 0;
					        },
					        403: function(responseObject, textStatus, errorThrown) {
					            $("#modalHomeTitle").text('Tenemos un problema!');
					            $("#modalHomeContenido").attr('align', 'left');
					            $("#modalHomeCerrarVentana").show();
					           	$("#modalHomeContenido").html('La evaluación quincenal se encuentra en revisión e impide la aprobación de las evaluaciones');
					            $("#modalHomeBtnCerrar").hide();
					            $("#modalHomeBtnCerrar").text('Cerrar');
					            $("#modalHomeBtnAccion").text('Iniciar sesión nuevamente!');
					            $("#modalHomeBtnAccion").hide();
					            return 0;
					        },
					        404: function(responseObject, textStatus, errorThrown) {
					            $("#modalHomeTitle").text('Tenemos un problema!');
					            $("#modalHomeContenido").attr('align', 'left');
					            $("#modalHomeCerrarVentana").show();
					            $("#modalHomeContenido").html('La evaluación quincenal se encuentra en proceso de apelación e impide la aprobación de las evaluaciones');
					            $("#modalHomeBtnCerrar").hide();
					            $("#modalHomeBtnCerrar").text('Cerrar');
					            $("#modalHomeBtnAccion").text('Iniciar sesión nuevamente!');
					            $("#modalHomeBtnAccion").hide();
					            return 0;
					        },
					        405: function(responseObject, textStatus, errorThrown) {
					            $("#modalHomeTitle").text('Tenemos un problema!');
					            $("#modalHomeContenido").attr('align', 'left');
					            $("#modalHomeCerrarVentana").show();
					            $("#modalHomeContenido").html('La evaluación quincenal ya esta cerrada. <strong>No se pueden cerrar evaluaciones que ya estan cerradas.</strong>');
					            $("#modalHomeBtnCerrar").hide();
					            $("#modalHomeBtnCerrar").text('Cerrar');
					            $("#modalHomeBtnAccion").text('Iniciar sesión nuevamente!');
					            $("#modalHomeBtnAccion").hide();
					            return 0;
					        },
					        406: function(responseObject, textStatus, errorThrown) {
					            $("#modalHomeTitle").text('Tenemos un problema!');
					            $("#modalHomeContenido").attr('align', 'left');
					            $("#modalHomeCerrarVentana").show();
					            $("#modalHomeContenido").html('La evaluación final se encuentra en revisión e impide la aprobación de las evaluaciones');
					            $("#modalHomeBtnCerrar").hide();
					            $("#modalHomeBtnCerrar").text('Cerrar');
					            $("#modalHomeBtnAccion").text('Iniciar sesión nuevamente!');
					            $("#modalHomeBtnAccion").hide();
					            return 0;
					        },
					        407: function(responseObject, textStatus, errorThrown) {
					            $("#modalHomeTitle").text('Tenemos un problema!');
					            $("#modalHomeContenido").attr('align', 'left');
					            $("#modalHomeCerrarVentana").show();
					            $("#modalHomeContenido").html('La evaluación final se encuentra en proceso de apelación e impide la aprobación de las evaluaciones');
					            $("#modalHomeBtnCerrar").hide();
					            $("#modalHomeBtnCerrar").text('Cerrar');
					            $("#modalHomeBtnAccion").text('Iniciar sesión nuevamente!');
					            $("#modalHomeBtnAccion").hide();
					            return 0;
					        },
					        408: function(responseObject, textStatus, errorThrown) {
					            $("#modalHomeTitle").text('Tenemos un problema!');
					            $("#modalHomeContenido").attr('align', 'left');
					            $("#modalHomeCerrarVentana").show();
					            $("#modalHomeContenido").html('La evaluación final ya esta cerrada. <strong>No se pueden cerrar evaluaciones que ya estan cerradas.</strong>');
					            $("#modalHomeBtnCerrar").hide();
					            $("#modalHomeBtnCerrar").text('Cerrar');
					            $("#modalHomeBtnAccion").text('Iniciar sesión nuevamente!');
					            $("#modalHomeBtnAccion").hide();
					            return 0;
					        },
					        206: function(responseObject, textStatus, errorThrown) {
					        	$.ajax({
								    type: 'post',
								    url: 'core/AprobacionEvaluacion.php',
								    data: {'ejecutivo' : ejecutivo, 'periodo' : periodo, 'tipo' : 'quincenal'},
								    beforeSend: function() {

								    },
								    statusCode: {
								        500: function(responseObject, textStatus, jqXHR) {
								            $("#modalHomeTitle").text('Error');
								            $("#modalHomeContenido").attr('align', 'left');
								            $("#modalHomeCerrarVentana").show();
								            $("#modalHomeContenido").html('El sistema no encontró las evaluaciones parciales asociadas al ejecutivo');
								            $("#modalHomeBtnCerrar").hide();
								            $("#modalHomeBtnCerrar").text('Cerrar');
								            $("#modalHomeBtnAccion").text('Iniciar sesión nuevamente!');
								            $("#modalHomeBtnAccion").hide();
								            return 0;
								        },
								        501: function(responseObject, textStatus, errorThrown) {
								            $("#modalHomeTitle").text('Error');
								            $("#modalHomeContenido").attr('align', 'left');
								            $("#modalHomeCerrarVentana").hide();
								            $("#modalHomeContenido").html('El sistema no encontró las evaluaciones quincenales asociadas al ejecutivo');
								            $("#modalHomeBtnCerrar").hide();
								            $("#modalHomeBtnCerrar").text('Cerrar');
								            $("#modalHomeBtnAccion").text('Iniciar sesión nuevamente!');
								            $("#modalHomeBtnAccion").hide();
								            return 0;
								        },
								        502: function(responseObject, textStatus, errorThrown) {
								            $("#modalHomeTitle").text('Error');
								            $("#modalHomeContenido").attr('align', 'left');
								            $("#modalHomeCerrarVentana").show();
								            $("#modalHomeContenido").html('El sistema no encontró las evaluaciones finales asociadas al ejecutivo');
								            $("#modalHomeBtnCerrar").hide();
								            $("#modalHomeBtnCerrar").text('Cerrar');
								            $("#modalHomeBtnAccion").text('Iniciar sesión nuevamente!');
								            $("#modalHomeBtnAccion").hide();
								            return 0;
								        },
								        400: function(responseObject, textStatus, errorThrown) {
								            $("#modalHomeTitle").text('Tenemos un problema!');
								            $("#modalHomeContenido").attr('align', 'left');
								            $("#modalHomeCerrarVentana").show();
								            $("#modalHomeContenido").html('Existe una o varias evaluaciones parciales que se encuentran en revisión e impiden la aprobación de las evaluaciones');
								            $("#modalHomeBtnCerrar").hide();
								            $("#modalHomeBtnCerrar").text('Cerrar');
								            $("#modalHomeBtnAccion").text('Iniciar sesión nuevamente!');
								            $("#modalHomeBtnAccion").hide();
								            return 0;
								        },
								        401: function(responseObject, textStatus, errorThrown) {
								            $("#modalHomeTitle").text('Tenemos un problema!');
								            $("#modalHomeContenido").attr('align', 'left');
								            $("#modalHomeCerrarVentana").show();
								            $("#modalHomeContenido").html('Existe una o varias evaluaciones parciales que se encuentran en proceso de apelación e impiden la aprobación de las evaluaciones');
								            $("#modalHomeBtnCerrar").hide();
								            $("#modalHomeBtnCerrar").text('Cerrar');
								            $("#modalHomeBtnAccion").text('Iniciar sesión nuevamente!');
								            $("#modalHomeBtnAccion").hide();
								            return 0;
								        },
								        402: function(responseObject, textStatus, errorThrown) {
								            $("#modalHomeTitle").text('Tenemos un problema!');
								            $("#modalHomeContenido").attr('align', 'left');
								            $("#modalHomeCerrarVentana").show();
								            $("#modalHomeContenido").html('Existe una o varias evaluaciones parciales que ya se cerradas. <strong>No se pueden cerrar evaluaciones que ya estan cerradas.</strong>');
								            $("#modalHomeBtnCerrar").hide();
								            $("#modalHomeBtnCerrar").text('Cerrar');
								            $("#modalHomeBtnAccion").text('Iniciar sesión nuevamente!');
								            $("#modalHomeBtnAccion").hide();
								            return 0;
								        },
								        403: function(responseObject, textStatus, errorThrown) {
								            $("#modalHomeTitle").text('Tenemos un problema!');
								            $("#modalHomeContenido").attr('align', 'left');
								            $("#modalHomeCerrarVentana").show();
								           	$("#modalHomeContenido").html('La evaluación quincenal se encuentra en revisión e impide la aprobación de las evaluaciones');
								            $("#modalHomeBtnCerrar").hide();
								            $("#modalHomeBtnCerrar").text('Cerrar');
								            $("#modalHomeBtnAccion").text('Iniciar sesión nuevamente!');
								            $("#modalHomeBtnAccion").hide();
								            return 0;
								        },
								        404: function(responseObject, textStatus, errorThrown) {
								            $("#modalHomeTitle").text('Tenemos un problema!');
								            $("#modalHomeContenido").attr('align', 'left');
								            $("#modalHomeCerrarVentana").show();
								            $("#modalHomeContenido").html('La evaluación quincenal se encuentra en proceso de apelación e impide la aprobación de las evaluaciones');
								            $("#modalHomeBtnCerrar").hide();
								            $("#modalHomeBtnCerrar").text('Cerrar');
								            $("#modalHomeBtnAccion").text('Iniciar sesión nuevamente!');
								            $("#modalHomeBtnAccion").hide();
								            return 0;
								        },
								        405: function(responseObject, textStatus, errorThrown) {
								            $("#modalHomeTitle").text('Tenemos un problema!');
								            $("#modalHomeContenido").attr('align', 'left');
								            $("#modalHomeCerrarVentana").show();
								            $("#modalHomeContenido").html('La evaluación quincenal ya esta cerrada. <strong>No se pueden cerrar evaluaciones que ya estan cerradas.</strong>');
								            $("#modalHomeBtnCerrar").hide();
								            $("#modalHomeBtnCerrar").text('Cerrar');
								            $("#modalHomeBtnAccion").text('Iniciar sesión nuevamente!');
								            $("#modalHomeBtnAccion").hide();
								            return 0;
								        },
								        406: function(responseObject, textStatus, errorThrown) {
								            $("#modalHomeTitle").text('Tenemos un problema!');
								            $("#modalHomeContenido").attr('align', 'left');
								            $("#modalHomeCerrarVentana").show();
								            $("#modalHomeContenido").html('La evaluación final se encuentra en revisión e impide la aprobación de las evaluaciones');
								            $("#modalHomeBtnCerrar").hide();
								            $("#modalHomeBtnCerrar").text('Cerrar');
								            $("#modalHomeBtnAccion").text('Iniciar sesión nuevamente!');
								            $("#modalHomeBtnAccion").hide();
								            return 0;
								        },
								        407: function(responseObject, textStatus, errorThrown) {
								            $("#modalHomeTitle").text('Tenemos un problema!');
								            $("#modalHomeContenido").attr('align', 'left');
								            $("#modalHomeCerrarVentana").show();
								            $("#modalHomeContenido").html('La evaluación final se encuentra en proceso de apelación e impide la aprobación de las evaluaciones');
								            $("#modalHomeBtnCerrar").hide();
								            $("#modalHomeBtnCerrar").text('Cerrar');
								            $("#modalHomeBtnAccion").text('Iniciar sesión nuevamente!');
								            $("#modalHomeBtnAccion").hide();
								            return 0;
								        },
								        408: function(responseObject, textStatus, errorThrown) {
								            $("#modalHomeTitle").text('Tenemos un problema!');
								            $("#modalHomeContenido").attr('align', 'left');
								            $("#modalHomeCerrarVentana").show();
								            $("#modalHomeContenido").html('La evaluación final ya esta cerrada. <strong>No se pueden cerrar evaluaciones que ya estan cerradas.</strong>');
								            $("#modalHomeBtnCerrar").hide();
								            $("#modalHomeBtnCerrar").text('Cerrar');
								            $("#modalHomeBtnAccion").text('Iniciar sesión nuevamente!');
								            $("#modalHomeBtnAccion").hide();
								            return 0;
								        },
								        301: function(responseObject, textStatus, errorThrown) {
								        	$("#modalHomeTitle").text('Error al cerrar evaluaciones');
								            $("#modalHomeContenido").attr('align', 'left');
								            $("#modalHomeCerrarVentana").show();
								            $("#modalHomeContenido").html('Un error desconocido ha sucedido al intentar cerrar las evaluaciones. Envíe el siguiente error en un pantallazo o correo electrónico: <em>HTTP 301 CORE APROBACIONEVALUACION TRY CATCH ERROR CONTROLLED</em>');
								            $("#modalHomeBtnCerrar").hide();
								            $("#modalHomeBtnCerrar").text('Cerrar');
								            $("#modalHomeBtnAccion").text('Iniciar sesión nuevamente!');
								            $("#modalHomeBtnAccion").hide();
								        },
								        202: function(responseObject, textStatus, errorThrown) {
								        	$("#modalHomeTitle").text('Evaluaciones Cerradas');
								            $("#modalHomeContenido").attr('align', 'left');
								            $("#modalHomeCerrarVentana").show();
								            $("#modalHomeContenido").html('Evaluaciones del ejecutivo cerradas con éxito');
								            $("#modalHomeBtnCerrar").hide();
								            refrescarTabla(); 
								            $("#modalHomeBtnCerrar").text('Cerrar');
								            $("#modalHomeBtnAccion").text('Iniciar sesión nuevamente!');
								            $("#modalHomeBtnAccion").hide();
								            $("#btnAprobar").prop('disabled', 'disabled');
								        }
								    }
								});
					        }
					    }
					});
		        }
		    }
		});
	}else if ($("#modalHomeBtnAccion").text() == "Aprobar y cerrar periodo") {
		var evaluador 	= $("#slcEvaluador").val();
		var periodo 	= $("#slcPeriodo").val();
		var area 		= $("#slcArea").val();
		var ejecutivo   = $("#slcEjecutivo").val();
		var estado 		= $("#slcEstado").val();

		$.ajax({
		    type: 'post',
		    url: 'core/SessionManager.php',
		    beforeSend: function() {
		    	$("#modalHome").modal('show');
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
		        	$.ajax({
					    type: 'post',
					    url: 'core/AprobacionStatus.php',
					    data: {'ejecutivo' : ejecutivo, 'periodo' : periodo, 'tipo' : 'final'},
					    beforeSend: function() {

					    },
					    statusCode: {
					        500: function(responseObject, textStatus, jqXHR) {
					            $("#modalHomeTitle").text('Error');
					            $("#modalHomeContenido").attr('align', 'left');
					            $("#modalHomeCerrarVentana").show();
					            $("#modalHomeContenido").html('El sistema no encontró las evaluaciones parciales asociadas al ejecutivo');
					            $("#modalHomeBtnCerrar").hide();
					            $("#modalHomeBtnCerrar").text('Cerrar');
					            $("#modalHomeBtnAccion").text('Iniciar sesión nuevamente!');
					            $("#modalHomeBtnAccion").hide();
					            return 0;
					        },
					        501: function(responseObject, textStatus, errorThrown) {
					            $("#modalHomeTitle").text('Error');
					            $("#modalHomeContenido").attr('align', 'left');
					            $("#modalHomeCerrarVentana").hide();
					            $("#modalHomeContenido").html('El sistema no encontró las evaluaciones quincenales asociadas al ejecutivo');
					            $("#modalHomeBtnCerrar").hide();
					            $("#modalHomeBtnCerrar").text('Cerrar');
					            $("#modalHomeBtnAccion").text('Iniciar sesión nuevamente!');
					            $("#modalHomeBtnAccion").hide();
					            return 0;
					        },
					        502: function(responseObject, textStatus, errorThrown) {
					            $("#modalHomeTitle").text('Error');
					            $("#modalHomeContenido").attr('align', 'left');
					            $("#modalHomeCerrarVentana").show();
					            $("#modalHomeContenido").html('El sistema no encontró las evaluaciones finales asociadas al ejecutivo');
					            $("#modalHomeBtnCerrar").hide();
					            $("#modalHomeBtnCerrar").text('Cerrar');
					            $("#modalHomeBtnAccion").text('Iniciar sesión nuevamente!');
					            $("#modalHomeBtnAccion").hide();
					            return 0;
					        },
					        400: function(responseObject, textStatus, errorThrown) {
					            $("#modalHomeTitle").text('Tenemos un problema!');
					            $("#modalHomeContenido").attr('align', 'left');
					            $("#modalHomeCerrarVentana").show();
					            $("#modalHomeContenido").html('Existe una o varias evaluaciones parciales que se encuentran en revisión e impiden la aprobación de las evaluaciones');
					            $("#modalHomeBtnCerrar").hide();
					            $("#modalHomeBtnCerrar").text('Cerrar');
					            $("#modalHomeBtnAccion").text('Iniciar sesión nuevamente!');
					            $("#modalHomeBtnAccion").hide();
					            return 0;
					        },
					        401: function(responseObject, textStatus, errorThrown) {
					            $("#modalHomeTitle").text('Tenemos un problema!');
					            $("#modalHomeContenido").attr('align', 'left');
					            $("#modalHomeCerrarVentana").show();
					            $("#modalHomeContenido").html('Existe una o varias evaluaciones parciales que se encuentran en proceso de apelación e impiden la aprobación de las evaluaciones');
					            $("#modalHomeBtnCerrar").hide();
					            $("#modalHomeBtnCerrar").text('Cerrar');
					            $("#modalHomeBtnAccion").text('Iniciar sesión nuevamente!');
					            $("#modalHomeBtnAccion").hide();
					            return 0;
					        },
					        402: function(responseObject, textStatus, errorThrown) {
					            $("#modalHomeTitle").text('Tenemos un problema!');
					            $("#modalHomeContenido").attr('align', 'left');
					            $("#modalHomeCerrarVentana").show();
					            $("#modalHomeContenido").html('Existe una o varias evaluaciones parciales que ya se cerradas. <strong>No se pueden cerrar evaluaciones que ya estan cerradas.</strong>');
					            $("#modalHomeBtnCerrar").hide();
					            $("#modalHomeBtnCerrar").text('Cerrar');
					            $("#modalHomeBtnAccion").text('Iniciar sesión nuevamente!');
					            $("#modalHomeBtnAccion").hide();
					            return 0;
					        },
					        403: function(responseObject, textStatus, errorThrown) {
					            $("#modalHomeTitle").text('Tenemos un problema!');
					            $("#modalHomeContenido").attr('align', 'left');
					            $("#modalHomeCerrarVentana").show();
					           	$("#modalHomeContenido").html('La evaluación quincenal se encuentra en revisión e impide la aprobación de las evaluaciones');
					            $("#modalHomeBtnCerrar").hide();
					            $("#modalHomeBtnCerrar").text('Cerrar');
					            $("#modalHomeBtnAccion").text('Iniciar sesión nuevamente!');
					            $("#modalHomeBtnAccion").hide();
					            return 0;
					        },
					        404: function(responseObject, textStatus, errorThrown) {
					            $("#modalHomeTitle").text('Tenemos un problema!');
					            $("#modalHomeContenido").attr('align', 'left');
					            $("#modalHomeCerrarVentana").show();
					            $("#modalHomeContenido").html('La evaluación quincenal se encuentra en proceso de apelación e impide la aprobación de las evaluaciones');
					            $("#modalHomeBtnCerrar").hide();
					            $("#modalHomeBtnCerrar").text('Cerrar');
					            $("#modalHomeBtnAccion").text('Iniciar sesión nuevamente!');
					            $("#modalHomeBtnAccion").hide();
					            return 0;
					        },
					        405: function(responseObject, textStatus, errorThrown) {
					            $("#modalHomeTitle").text('Tenemos un problema!');
					            $("#modalHomeContenido").attr('align', 'left');
					            $("#modalHomeCerrarVentana").show();
					            $("#modalHomeContenido").html('La evaluación quincenal ya esta cerrada. <strong>No se pueden cerrar evaluaciones que ya estan cerradas.</strong>');
					            $("#modalHomeBtnCerrar").hide();
					            $("#modalHomeBtnCerrar").text('Cerrar');
					            $("#modalHomeBtnAccion").text('Iniciar sesión nuevamente!');
					            $("#modalHomeBtnAccion").hide();
					            return 0;
					        },
					        406: function(responseObject, textStatus, errorThrown) {
					            $("#modalHomeTitle").text('Tenemos un problema!');
					            $("#modalHomeContenido").attr('align', 'left');
					            $("#modalHomeCerrarVentana").show();
					            $("#modalHomeContenido").html('La evaluación final se encuentra en revisión e impide la aprobación de las evaluaciones');
					            $("#modalHomeBtnCerrar").hide();
					            $("#modalHomeBtnCerrar").text('Cerrar');
					            $("#modalHomeBtnAccion").text('Iniciar sesión nuevamente!');
					            $("#modalHomeBtnAccion").hide();
					            return 0;
					        },
					        407: function(responseObject, textStatus, errorThrown) {
					            $("#modalHomeTitle").text('Tenemos un problema!');
					            $("#modalHomeContenido").attr('align', 'left');
					            $("#modalHomeCerrarVentana").show();
					            $("#modalHomeContenido").html('La evaluación final se encuentra en proceso de apelación e impide la aprobación de las evaluaciones');
					            $("#modalHomeBtnCerrar").hide();
					            $("#modalHomeBtnCerrar").text('Cerrar');
					            $("#modalHomeBtnAccion").text('Iniciar sesión nuevamente!');
					            $("#modalHomeBtnAccion").hide();
					            return 0;
					        },
					        408: function(responseObject, textStatus, errorThrown) {
					            $("#modalHomeTitle").text('Tenemos un problema!');
					            $("#modalHomeContenido").attr('align', 'left');
					            $("#modalHomeCerrarVentana").show();
					            $("#modalHomeContenido").html('La evaluación final ya esta cerrada. <strong>No se pueden cerrar evaluaciones que ya estan cerradas.</strong>');
					            $("#modalHomeBtnCerrar").hide();
					            $("#modalHomeBtnCerrar").text('Cerrar');
					            $("#modalHomeBtnAccion").text('Iniciar sesión nuevamente!');
					            $("#modalHomeBtnAccion").hide();
					            return 0;
					        },
					        206: function(responseObject, textStatus, errorThrown) {
					        	$.ajax({
								    type: 'post',
								    url: 'core/AprobacionEvaluacion.php',
								    data: {'ejecutivo' : ejecutivo, 'periodo' : periodo, 'tipo' : 'final'},
								    beforeSend: function() {

								    },
								    statusCode: {
								        500: function(responseObject, textStatus, jqXHR) {
								            $("#modalHomeTitle").text('Error');
								            $("#modalHomeContenido").attr('align', 'left');
								            $("#modalHomeCerrarVentana").show();
								            $("#modalHomeContenido").html('El sistema no encontró las evaluaciones parciales asociadas al ejecutivo');
								            $("#modalHomeBtnCerrar").hide();
								            $("#modalHomeBtnCerrar").text('Cerrar');
								            $("#modalHomeBtnAccion").text('Iniciar sesión nuevamente!');
								            $("#modalHomeBtnAccion").hide();
								            return 0;
								        },
								        501: function(responseObject, textStatus, errorThrown) {
								            $("#modalHomeTitle").text('Error');
								            $("#modalHomeContenido").attr('align', 'left');
								            $("#modalHomeCerrarVentana").hide();
								            $("#modalHomeContenido").html('El sistema no encontró las evaluaciones quincenales asociadas al ejecutivo');
								            $("#modalHomeBtnCerrar").hide();
								            $("#modalHomeBtnCerrar").text('Cerrar');
								            $("#modalHomeBtnAccion").text('Iniciar sesión nuevamente!');
								            $("#modalHomeBtnAccion").hide();
								            return 0;
								        },
								        502: function(responseObject, textStatus, errorThrown) {
								            $("#modalHomeTitle").text('Error');
								            $("#modalHomeContenido").attr('align', 'left');
								            $("#modalHomeCerrarVentana").show();
								            $("#modalHomeContenido").html('El sistema no encontró las evaluaciones finales asociadas al ejecutivo');
								            $("#modalHomeBtnCerrar").hide();
								            $("#modalHomeBtnCerrar").text('Cerrar');
								            $("#modalHomeBtnAccion").text('Iniciar sesión nuevamente!');
								            $("#modalHomeBtnAccion").hide();
								            return 0;
								        },
								        400: function(responseObject, textStatus, errorThrown) {
								            $("#modalHomeTitle").text('Tenemos un problema!');
								            $("#modalHomeContenido").attr('align', 'left');
								            $("#modalHomeCerrarVentana").show();
								            $("#modalHomeContenido").html('Existe una o varias evaluaciones parciales que se encuentran en revisión e impiden la aprobación de las evaluaciones');
								            $("#modalHomeBtnCerrar").hide();
								            $("#modalHomeBtnCerrar").text('Cerrar');
								            $("#modalHomeBtnAccion").text('Iniciar sesión nuevamente!');
								            $("#modalHomeBtnAccion").hide();
								            return 0;
								        },
								        401: function(responseObject, textStatus, errorThrown) {
								            $("#modalHomeTitle").text('Tenemos un problema!');
								            $("#modalHomeContenido").attr('align', 'left');
								            $("#modalHomeCerrarVentana").show();
								            $("#modalHomeContenido").html('Existe una o varias evaluaciones parciales que se encuentran en proceso de apelación e impiden la aprobación de las evaluaciones');
								            $("#modalHomeBtnCerrar").hide();
								            $("#modalHomeBtnCerrar").text('Cerrar');
								            $("#modalHomeBtnAccion").text('Iniciar sesión nuevamente!');
								            $("#modalHomeBtnAccion").hide();
								            return 0;
								        },
								        402: function(responseObject, textStatus, errorThrown) {
								            $("#modalHomeTitle").text('Tenemos un problema!');
								            $("#modalHomeContenido").attr('align', 'left');
								            $("#modalHomeCerrarVentana").show();
								            $("#modalHomeContenido").html('Existe una o varias evaluaciones parciales que ya se cerradas. <strong>No se pueden cerrar evaluaciones que ya estan cerradas.</strong>');
								            $("#modalHomeBtnCerrar").hide();
								            $("#modalHomeBtnCerrar").text('Cerrar');
								            $("#modalHomeBtnAccion").text('Iniciar sesión nuevamente!');
								            $("#modalHomeBtnAccion").hide();
								            return 0;
								        },
								        403: function(responseObject, textStatus, errorThrown) {
								            $("#modalHomeTitle").text('Tenemos un problema!');
								            $("#modalHomeContenido").attr('align', 'left');
								            $("#modalHomeCerrarVentana").show();
								           	$("#modalHomeContenido").html('La evaluación quincenal se encuentra en revisión e impide la aprobación de las evaluaciones');
								            $("#modalHomeBtnCerrar").hide();
								            $("#modalHomeBtnCerrar").text('Cerrar');
								            $("#modalHomeBtnAccion").text('Iniciar sesión nuevamente!');
								            $("#modalHomeBtnAccion").hide();
								            return 0;
								        },
								        404: function(responseObject, textStatus, errorThrown) {
								            $("#modalHomeTitle").text('Tenemos un problema!');
								            $("#modalHomeContenido").attr('align', 'left');
								            $("#modalHomeCerrarVentana").show();
								            $("#modalHomeContenido").html('La evaluación quincenal se encuentra en proceso de apelación e impide la aprobación de las evaluaciones');
								            $("#modalHomeBtnCerrar").hide();
								            $("#modalHomeBtnCerrar").text('Cerrar');
								            $("#modalHomeBtnAccion").text('Iniciar sesión nuevamente!');
								            $("#modalHomeBtnAccion").hide();
								            return 0;
								        },
								        405: function(responseObject, textStatus, errorThrown) {
								            $("#modalHomeTitle").text('Tenemos un problema!');
								            $("#modalHomeContenido").attr('align', 'left');
								            $("#modalHomeCerrarVentana").show();
								            $("#modalHomeContenido").html('La evaluación quincenal ya esta cerrada. <strong>No se pueden cerrar evaluaciones que ya estan cerradas.</strong>');
								            $("#modalHomeBtnCerrar").hide();
								            $("#modalHomeBtnCerrar").text('Cerrar');
								            $("#modalHomeBtnAccion").text('Iniciar sesión nuevamente!');
								            $("#modalHomeBtnAccion").hide();
								            return 0;
								        },
								        406: function(responseObject, textStatus, errorThrown) {
								            $("#modalHomeTitle").text('Tenemos un problema!');
								            $("#modalHomeContenido").attr('align', 'left');
								            $("#modalHomeCerrarVentana").show();
								            $("#modalHomeContenido").html('La evaluación final se encuentra en revisión e impide la aprobación de las evaluaciones');
								            $("#modalHomeBtnCerrar").hide();
								            $("#modalHomeBtnCerrar").text('Cerrar');
								            $("#modalHomeBtnAccion").text('Iniciar sesión nuevamente!');
								            $("#modalHomeBtnAccion").hide();
								            return 0;
								        },
								        407: function(responseObject, textStatus, errorThrown) {
								            $("#modalHomeTitle").text('Tenemos un problema!');
								            $("#modalHomeContenido").attr('align', 'left');
								            $("#modalHomeCerrarVentana").show();
								            $("#modalHomeContenido").html('La evaluación final se encuentra en proceso de apelación e impide la aprobación de las evaluaciones');
								            $("#modalHomeBtnCerrar").hide();
								            $("#modalHomeBtnCerrar").text('Cerrar');
								            $("#modalHomeBtnAccion").text('Iniciar sesión nuevamente!');
								            $("#modalHomeBtnAccion").hide();
								            return 0;
								        },
								        408: function(responseObject, textStatus, errorThrown) {
								            $("#modalHomeTitle").text('Tenemos un problema!');
								            $("#modalHomeContenido").attr('align', 'left');
								            $("#modalHomeCerrarVentana").show();
								            $("#modalHomeContenido").html('La evaluación final ya esta cerrada. <strong>No se pueden cerrar evaluaciones que ya estan cerradas.</strong>');
								            $("#modalHomeBtnCerrar").hide();
								            $("#modalHomeBtnCerrar").text('Cerrar');
								            $("#modalHomeBtnAccion").text('Iniciar sesión nuevamente!');
								            $("#modalHomeBtnAccion").hide();
								            return 0;
								        },
								        301: function(responseObject, textStatus, errorThrown) {
								        	$("#modalHomeTitle").text('Error al cerrar evaluaciones');
								            $("#modalHomeContenido").attr('align', 'left');
								            $("#modalHomeCerrarVentana").show();
								            $("#modalHomeContenido").html('Un error desconocido ha sucedido al intentar cerrar las evaluaciones. Envíe el siguiente error en un pantallazo o correo electrónico: <em>HTTP 301 CORE APROBACIONEVALUACION TRY CATCH ERROR CONTROLLED</em>');
								            $("#modalHomeBtnCerrar").hide();
								            $("#modalHomeBtnCerrar").text('Cerrar');
								            $("#modalHomeBtnAccion").text('Iniciar sesión nuevamente!');
								            $("#modalHomeBtnAccion").hide();
								        },
								        202: function(responseObject, textStatus, errorThrown) {
								        	$("#modalHomeTitle").text('Evaluaciones Cerradas');
								            $("#modalHomeContenido").attr('align', 'left');
								            $("#modalHomeCerrarVentana").show();
								            $("#modalHomeContenido").html('Evaluaciones del ejecutivo cerradas con éxito');
								            $("#modalHomeBtnCerrar").hide();
								            refrescarTabla(); 
								            $("#modalHomeBtnCerrar").text('Cerrar');
								            $("#modalHomeBtnAccion").text('Iniciar sesión nuevamente!');
								            $("#modalHomeBtnAccion").hide();
								            $("#btnAprobar").prop('disabled', 'disabled');
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
});

$("#slcPeriodo").change(function() {
	var area 	= $('#slcArea :selected').val();
	var periodo = $('#slcPeriodo :selected').val();

	$.ajax({
		type: 'get', 
		url: 'core/SessionManager.php',
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			if (XMLHttpRequest.readyState == 0) {
				$("#modalHomeConfig").attr('class', 'modal-dialog');
				$("#modalHomeTitle").text('Verifique su conexión a internet');
				$("#modalHomeContenido").attr('align', 'left');
				$("#modalHomeCerrarVentana").show();
				$("#modalHomeContenido").html('No se pudo establecer una conexión con el servidor del sistema de calidad y por lo tanto los últimos cambios de su evaluación no pudieron ser guardadas. <strong>Pero calma... que no panda el cúnico!</strong>, Las calificaciones, audio y adjuntos que has seleccionado para esta evaluación han sido guardados de forma automática y lo mas probable es que solo hayas perdido la observación de la interacción telefónica. <br /><strong>Por favor, verifique que la conexión de su ordenador se encuentre en orden, si usted se conecta vía Wi-Fi intente acercase al router para aumentar la señal o valique estar conectado a su red. Si ya ha intentado todo lo anterior, solicite ayuda llamando a la mesa de ayuda de tricot al anexo 616 o desde celulares al 2 2350 3616</strong>');
				$("#modalHomeBtnCerrar").show();
				$("#modalHomeBtnCerrar").text('Cerrar');
				$("#modalHomeBtnAccion").hide();
				$("#modalHome").modal('show');
			}
		},
		beforeSend: function() {
		},
		statusCode : {
			401: function(responseObject, textStatus, errorThrown) {
				$("#modalHomeConfig").attr('class', 'modal-dialog');
				$("#modalHomeTitle").text('Identifiquese nuevamente');
				$("#modalHomeContenido").attr('align', 'left');
				$("#modalHomeCerrarVentana").show();
				$("#modalHomeContenido").html('<strong>Ha permanecido demasiado tiempo inactivo</strong> Por favor inicie sesión nuevamente');
				$("#modalHomeBtnCerrar").hide();
				$("#modalHomeBtnCerrar").text('Cerrar');
				$("#modalHomeBtnAccion").text('Iniciar Sesión');
				$("#modalHomeBtnAccion").show();
				$("#modalHome").modal('show');
			},
			403: function(responseObject, textStatus, errorThrown) {
				$("#modalHomeConfig").attr('class', 'modal-dialog');
				$("#modalHomeTitle").text('Identifiquese nuevamente');
				$("#modalHomeContenido").attr('align', 'left');
				$("#modalHomeCerrarVentana").show();
				$("#modalHomeContenido").html('<strong>No se ha encontrado la variable de usuario y tiempo de actividad del sistema</strong> (CORE SESSIONMANAGER HTTP 403)');
				$("#modalHomeBtnCerrar").hide();
				$("#modalHomeBtnCerrar").text('Cerrar');
				$("#modalHomeBtnAccion").text('Iniciar Sesión');
				$("#modalHomeBtnAccion").show();
				$("#modalHome").modal('show');
			},
			500: function(responseObject, textStatus, errorThrown) {
				$("#modalHomeConfig").attr('class', 'modal-dialog');
				$("#modalHomeTitle").text('Acceso Restringido');
				$("#modalHomeContenido").attr('align', 'left');
				$("#modalHomeCerrarVentana").show();
				$("#modalHomeContenido").html('<strong>Usted no cuenta con los privilegios para acceder al sistema</strong> (CORE SESSIONMANAGER HTTP 500)');
				$("#modalHomeBtnCerrar").hide();
				$("#modalHomeBtnCerrar").text('Cerrar');
				$("#modalHomeBtnAccion").text('Iniciar Sesión');
				$("#modalHomeBtnAccion").show();
				$("#modalHome").modal('show');
			},
			503: function(responseObject, textStatus, errorThrown) {
				$("#modalHomeConfig").attr('class', 'modal-dialog');
				$("#modalHomeTitle").text('Error Crítico');
				$("#modalHomeContenido").attr('align', 'left');
				$("#modalHomeCerrarVentana").show();
				$("#modalHomeContenido").html('<strong>El sistema de evaluaciones huesped no ha sido encontrado definida la sesión del sistema hospedador. Inicie sesión nuevamente, si el problema persiste por favor comuníquese con el desarollador.</strong> (Información técnica: RAULI NO ENTREGA VARIABLE DE SESION A SISTEMA HTTP 503 CORE SESSION MANAGER)');
				$("#modalHomeBtnCerrar").hide();
				$("#modalHomeBtnCerrar").text('Cerrar');
				$("#modalHomeBtnAccion").text('Iniciar Sesión');
				$("#modalHomeBtnAccion").show();
				$("#modalHome").modal('show');
			},
			200: function(responseObject, textStatus, errorThrown) {
			    $("#modalHomeConfig").attr('class', 'modal-dialog');
			    $("#modalHome").modal('show');
				$("#modalHomeTitle").html('Por Favor Espere');
				$("#modalHomeBtnCerrar").hide();
				$("#modalHomeBtnCerrar").text('');
				$("#modalHomeCerrarVentana").hide();
				$("#modalHomeBtnAccion").hide();
				$("#modalHomeBtnAccion").text('');
				$("#modalHomeContenido").html('<img src="facade/img/loading2.gif" /> Recibiendo su solicitud...');


				$.ajax({
			        type: 'post',
			        url: 'core/cambiarPeriodoyArea.php',
			        data: 'slcArea='+area+'&slcPeriodo='+periodo,
			        beforeSend: function() {
			        },
					error: function(XMLHttpRequest, textStatus, errorThrown) {
					    if (XMLHttpRequest.readyState == 0) {
							$("#modalHomeConfig").attr('class', 'modal-dialog');
							$("#modalHomeTitle").text('Verifique su conexión a internet');
							$("#modalHomeContenido").attr('align', 'left');
							$("#modalHomeCerrarVentana").show();
							$("#modalHomeContenido").html('No se pudo establecer una conexión con el servidor del sistema de calidad y por lo tanto su solicitud no pudo ser procesada. <br /><strong>Por favor, verifique que la conexión de su ordenador se encuentre en orden, si usted se conecta vía Wi-Fi intente acercase al router para aumentar la señal o valique estar conectado a su red. Si ya ha intentado todo lo anterior, solicite ayuda llamando a la mesa de ayuda de tricot al anexo 616 o desde celulares al 2 2350 3616</strong>');
							$("#modalHomeBtnCerrar").show();
							$("#modalHomeBtnCerrar").text('Cerrar');
							$("#modalHomeBtnAccion").hide();
					    }
					},
			        statusCode: {
			            401: function(responseObject, textStatus, errorThrown) {
			                $("#modalIndexTitle").text('Información de Evaluador');
			                $("#modalIndexContenido").attr('align', 'left');
			                $("#modalIndexCerrarVentana").show();
							$("#modalHomeContenido").html('No se recibió la suficiente información para completar el listado de evaluadores<br /><strong>PHP CORE CAMBIARPERIODOYAREA INPUT AREA EMPTY</strong>');
			                $("#modalIndexBtnCerrar").hide();
			                $("#modalIndexBtnCerrar").text('Cerrar');
			                $("#modalIndexBtnAccion").hide();
			            },
			            403: function(responseObject, textStatus, errorThrown) {
			                $("#modalIndexTitle").text('Información de Evaluador');
			                $("#modalIndexContenido").attr('align', 'left');
			                $("#modalIndexCerrarVentana").show();
							$("#modalHomeContenido").html('No se recibió la suficiente información para completar el listado de evaluadores<br /><strong>PHP CORE CAMBIARPERIODOYAREA INPUT AREA EMPTY</strong>');
			                $("#modalIndexBtnCerrar").hide();
			                $("#modalIndexBtnCerrar").text('Cerrar');
			                $("#modalIndexBtnAccion").hide();
			            },
			            200: function(responseObject, textStatus, errorThrown) {
			                //INICIO DE RELLENO DE DATOS DE NUEVA ÁREA SELECCIONADA
			                //eliminando valores existentes

							$.ajax({
							    type: 'post',
							    url: 'core/HomeReceivePeriodoFromIndex.php',
							    beforeSend: function() {
							    },
							    error: function(XMLHttpRequest, textStatus, errorThrown) {
								    if (XMLHttpRequest.readyState == 0) {
										$("#modalHomeConfig").attr('class', 'modal-dialog');
										$("#modalHomeTitle").text('Verifique su conexión a internet');
										$("#modalHomeContenido").attr('align', 'left');
										$("#modalHomeCerrarVentana").show();
										$("#modalHomeContenido").html('No se pudo establecer una conexión con el servidor del sistema de calidad y por lo tanto su solicitud no pudo ser procesada. <br /><strong>Por favor, verifique que la conexión de su ordenador se encuentre en orden, si usted se conecta vía Wi-Fi intente acercase al router para aumentar la señal o valique estar conectado a su red. Si ya ha intentado todo lo anterior, solicite ayuda llamando a la mesa de ayuda de tricot al anexo 616 o desde celulares al 2 2350 3616</strong>');
										$("#modalHomeBtnCerrar").show();
										$("#modalHomeBtnCerrar").text('Cerrar');
										$("#modalHomeBtnAccion").hide();
								    }
								},
							    statusCode: {
						            404: function(responseObject, textStatus, errorThrown) {
						            	$("#modalHome").modal('show');
						                $("#modalHomeTitle").text('´Problema al cargar el periodo');
						                $("#modalHomeContenido").attr('align', 'left');
						                $("#modalHomeCerrarVentana").show();
						                $("#modalHomeContenido").html('No se encontró respuesta del servidor para los periodos a trabajar<br /><strong>HTTP 404</strong>');
						                $("#modalHomeBtnCerrar").show();
						                $("#modalHomeBtnCerrar").text('Cerrar');
						                $("#modalHomeBtnAccion").hide();
						            },
						            200: function(responseObject, textStatus, errorThrown) {
						                var resultados = JSON.parse(responseObject);
						                
						                //eliminando valores existentes
						                $.each($("#slcPeriodo option"),function(i,v){
											value = v.value;
											$("#slcPeriodo option[value="+value+"]").remove();
										});

						                 $.each(resultados.periodos, function (index, value) {
						                    $("#slcPeriodo").append('<option value="'+value+'">'+value+'</option>');
						                });


										$.ajax({
										    type: 'post',
										    url: 'core/ListPeriodosParaEvaluar.php',
										    beforeSend: function() {
										    },
										    error: function(XMLHttpRequest, textStatus, errorThrown) {
											    if (XMLHttpRequest.readyState == 0) {
													$("#modalHomeConfig").attr('class', 'modal-dialog');
													$("#modalHomeTitle").text('Verifique su conexión a internet');
													$("#modalHomeContenido").attr('align', 'left');
													$("#modalHomeCerrarVentana").show();
													$("#modalHomeContenido").html('No se pudo establecer una conexión con el servidor del sistema de calidad y por lo tanto su solicitud no pudo ser procesada. <br /><strong>Por favor, verifique que la conexión de su ordenador se encuentre en orden, si usted se conecta vía Wi-Fi intente acercase al router para aumentar la señal o valique estar conectado a su red. Si ya ha intentado todo lo anterior, solicite ayuda llamando a la mesa de ayuda de tricot al anexo 616 o desde celulares al 2 2350 3616</strong>');
													$("#modalHomeBtnCerrar").show();
													$("#modalHomeBtnCerrar").text('Cerrar');
													$("#modalHomeBtnAccion").hide();
											    }
											},
										    statusCode: {
										        404: function(responseObject, textStatus, errorThrown) {
										        	$("#modalHome").modal('show');
										            $("#modalHomeTitle").text('´Problema al cargar el periodo');
										            $("#modalHomeContenido").attr('align', 'left');
										            $("#modalHomeCerrarVentana").show();
										            $("#modalHomeContenido").html('No se encontró respuesta del servidor para los periodos a trabajar<br /><strong>HTTP 404</strong>');
										            $("#modalHomeBtnCerrar").show();
										            $("#modalHomeBtnCerrar").text('Cerrar');
										            $("#modalHomeBtnAccion").hide();
										        },
										        200: function(responseObject, textStatus, errorThrown) {
										            var resultados = JSON.parse(responseObject);
										           
										             $.each(resultados.periodos, function (index, value) {
										                if($("#slcPeriodo :selected").text() != value) {
										                	$("#slcPeriodo").append('<option value="'+value+'">'+value+'</option>');
										                }
										            });
						                			
						                			$("#modalHomeBtnCerrar").click();
						                			var evaluador 	= $("#slcEvaluador :selected").val();
													var periodo 	= $("#slcPeriodo :selected").val();
													var area 		= $("#slcArea :selected").val();
													actualizarListadoEjecutivos(periodo, area);
													refrescarTabla();
													actualizarEstadisticas();
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

$("#slcArea").change(function(){
	var area 	= $('#slcArea :selected').val();
	var periodo = $('#slcPeriodo :selected').val();
	$.ajax({
		type: 'get', 
		url: 'core/SessionManager.php',
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			if (XMLHttpRequest.readyState == 0) {
				$("#modalHomeConfig").attr('class', 'modal-dialog');
				$("#modalHomeTitle").text('Verifique su conexión a internet');
				$("#modalHomeContenido").attr('align', 'left');
				$("#modalHomeCerrarVentana").show();
				$("#modalHomeContenido").html('No se pudo establecer una conexión con el servidor del sistema de calidad y por lo tanto los últimos cambios de su evaluación no pudieron ser guardadas. <strong>Pero calma... que no panda el cúnico!</strong>, Las calificaciones, audio y adjuntos que has seleccionado para esta evaluación han sido guardados de forma automática y lo mas probable es que solo hayas perdido la observación de la interacción telefónica. <br /><strong>Por favor, verifique que la conexión de su ordenador se encuentre en orden, si usted se conecta vía Wi-Fi intente acercase al router para aumentar la señal o valique estar conectado a su red. Si ya ha intentado todo lo anterior, solicite ayuda llamando a la mesa de ayuda de tricot al anexo 616 o desde celulares al 2 2350 3616</strong>');
				$("#modalHomeBtnCerrar").show();
				$("#modalHomeBtnCerrar").text('Cerrar');
				$("#modalHomeBtnAccion").hide();
				$("#modalHome").modal('show');
			}
		},
		beforeSend: function() {
		},
		statusCode : {
			401: function(responseObject, textStatus, errorThrown) {
				$("#modalHomeConfig").attr('class', 'modal-dialog');
				$("#modalHomeTitle").text('Identifiquese nuevamente');
				$("#modalHomeContenido").attr('align', 'left');
				$("#modalHomeCerrarVentana").show();
				$("#modalHomeContenido").html('<strong>Ha permanecido demasiado tiempo inactivo</strong> Por favor inicie sesión nuevamente');
				$("#modalHomeBtnCerrar").hide();
				$("#modalHomeBtnCerrar").text('Cerrar');
				$("#modalHomeBtnAccion").text('Iniciar Sesión');
				$("#modalHomeBtnAccion").show();
				$("#modalHome").modal('show');
			},
			403: function(responseObject, textStatus, errorThrown) {
				$("#modalHomeConfig").attr('class', 'modal-dialog');
				$("#modalHomeTitle").text('Identifiquese nuevamente');
				$("#modalHomeContenido").attr('align', 'left');
				$("#modalHomeCerrarVentana").show();
				$("#modalHomeContenido").html('<strong>No se ha encontrado la variable de usuario y tiempo de actividad del sistema</strong> (CORE SESSIONMANAGER HTTP 403)');
				$("#modalHomeBtnCerrar").hide();
				$("#modalHomeBtnCerrar").text('Cerrar');
				$("#modalHomeBtnAccion").text('Iniciar Sesión');
				$("#modalHomeBtnAccion").show();
				$("#modalHome").modal('show');
			},
			500: function(responseObject, textStatus, errorThrown) {
				$("#modalHomeConfig").attr('class', 'modal-dialog');
				$("#modalHomeTitle").text('Acceso Restringido');
				$("#modalHomeContenido").attr('align', 'left');
				$("#modalHomeCerrarVentana").show();
				$("#modalHomeContenido").html('<strong>Usted no cuenta con los privilegios para acceder al sistema</strong> (CORE SESSIONMANAGER HTTP 500)');
				$("#modalHomeBtnCerrar").hide();
				$("#modalHomeBtnCerrar").text('Cerrar');
				$("#modalHomeBtnAccion").text('Iniciar Sesión');
				$("#modalHomeBtnAccion").show();
				$("#modalHome").modal('show');
			},
			503: function(responseObject, textStatus, errorThrown) {
				$("#modalHomeConfig").attr('class', 'modal-dialog');
				$("#modalHomeTitle").text('Error Crítico');
				$("#modalHomeContenido").attr('align', 'left');
				$("#modalHomeCerrarVentana").show();
				$("#modalHomeContenido").html('<strong>El sistema de evaluaciones huesped no ha sido encontrado definida la sesión del sistema hospedador. Inicie sesión nuevamente, si el problema persiste por favor comuníquese con el desarollador.</strong> (Información técnica: RAULI NO ENTREGA VARIABLE DE SESION A SISTEMA HTTP 503 CORE SESSION MANAGER)');
				$("#modalHomeBtnCerrar").hide();
				$("#modalHomeBtnCerrar").text('Cerrar');
				$("#modalHomeBtnAccion").text('Iniciar Sesión');
				$("#modalHomeBtnAccion").show();
				$("#modalHome").modal('show');
			},
			200: function(responseObject, textStatus, errorThrown) {

				    $("#modalHomeConfig").attr('class', 'modal-dialog');
				    $("#modalHome").modal('show');
					$("#modalHomeTitle").html('Por Favor Espere');
					$("#modalHomeBtnCerrar").hide();
					$("#modalHomeBtnCerrar").text('');
					$("#modalHomeCerrarVentana").hide();
					$("#modalHomeBtnAccion").hide();
					$("#modalHomeBtnAccion").text('');
					$("#modalHomeContenido").html('<img src="facade/img/loading2.gif" /> Recibiendo su solicitud...');

					$.ajax({
				        type: 'post',
				        url: 'core/cambiarPeriodoyArea.php',
				        data: 'slcArea='+area+'&slcPeriodo='+periodo,
				        beforeSend: function() {
				        },
						error: function(XMLHttpRequest, textStatus, errorThrown) {
						    if (XMLHttpRequest.readyState == 0) {
								$("#modalHomeConfig").attr('class', 'modal-dialog');
								$("#modalHomeTitle").text('Verifique su conexión a internet');
								$("#modalHomeContenido").attr('align', 'left');
								$("#modalHomeCerrarVentana").show();
								$("#modalHomeContenido").html('No se pudo establecer una conexión con el servidor del sistema de calidad y por lo tanto su solicitud no pudo ser procesada. <br /><strong>Por favor, verifique que la conexión de su ordenador se encuentre en orden, si usted se conecta vía Wi-Fi intente acercase al router para aumentar la señal o valique estar conectado a su red. Si ya ha intentado todo lo anterior, solicite ayuda llamando a la mesa de ayuda de tricot al anexo 616 o desde celulares al 2 2350 3616</strong>');
								$("#modalHomeBtnCerrar").show();
								$("#modalHomeBtnCerrar").text('Cerrar');
								$("#modalHomeBtnAccion").hide();
						    }
						},
				        statusCode: {
				            401: function(responseObject, textStatus, errorThrown) {
				                $("#modalIndexTitle").text('Información de Evaluador');
				                $("#modalIndexContenido").attr('align', 'left');
				                $("#modalIndexCerrarVentana").show();
								$("#modalHomeContenido").html('No se recibió la suficiente información para completar el listado de evaluadores<br /><strong>PHP CORE CAMBIARPERIODOYAREA INPUT AREA EMPTY</strong>');
				                $("#modalIndexBtnCerrar").hide();
				                $("#modalIndexBtnCerrar").text('Cerrar');
				                $("#modalIndexBtnAccion").hide();
				            },
				            403: function(responseObject, textStatus, errorThrown) {
				                $("#modalIndexTitle").text('Información de Evaluador');
				                $("#modalIndexContenido").attr('align', 'left');
				                $("#modalIndexCerrarVentana").show();
								$("#modalHomeContenido").html('No se recibió la suficiente información para completar el listado de evaluadores<br /><strong>PHP CORE CAMBIARPERIODOYAREA INPUT AREA EMPTY</strong>');
				                $("#modalIndexBtnCerrar").hide();
				                $("#modalIndexBtnCerrar").text('Cerrar');
				                $("#modalIndexBtnAccion").hide();
				            },
				            200: function(responseObject, textStatus, errorThrown) {
				                //INICIO DE RELLENO DE DATOS DE NUEVA ÁREA SELECCIONADA
				                //eliminando valores existentes
				                $.each($("#slcArea option"),function(i,v){
									value = v.value;
									$("#slcArea option[value="+value+"]").remove();
								});
								$.ajax({
								    type: 'post',
								    url: 'core/HomeReceiveAreaFromIndex.php',
								    beforeSend: function() {
								    },
									error: function(XMLHttpRequest, textStatus, errorThrown) {
									    if (XMLHttpRequest.readyState == 0) {
											$("#modalHomeConfig").attr('class', 'modal-dialog');
											$("#modalHomeTitle").text('Verifique su conexión a internet');
											$("#modalHomeContenido").attr('align', 'left');
											$("#modalHomeCerrarVentana").show();
											$("#modalHomeContenido").html('No se pudo establecer una conexión con el servidor del sistema de calidad y por lo tanto su solicitud no pudo ser procesada. <br /><strong>Por favor, verifique que la conexión de su ordenador se encuentre en orden, si usted se conecta vía Wi-Fi intente acercase al router para aumentar la señal o valique estar conectado a su red. Si ya ha intentado todo lo anterior, solicite ayuda llamando a la mesa de ayuda de tricot al anexo 616 o desde celulares al 2 2350 3616</strong>');
											$("#modalHomeBtnCerrar").show();
											$("#modalHomeBtnCerrar").text('Cerrar');
											$("#modalHomeBtnAccion").hide();
									    }
									},
								    statusCode: {
							            404: function(responseObject, textStatus, errorThrown) {
							            	$("#modalHome").modal('show');
							                $("#modalHomeTitle").text('´Problema al cargar el periodo');
							                $("#modalHomeContenido").attr('align', 'left');
							                $("#modalHomeCerrarVentana").show();
							                $("#modalHomeContenido").html('No se encontró respuesta del servidor para los periodos a trabajar<br /><strong>HTTP 404</strong>');
							                $("#modalHomeBtnCerrar").show();
							                $("#modalHomeBtnCerrar").text('Cerrar');
							                $("#modalHomeBtnAccion").hide();
							            },
							            200: function(responseObject, textStatus, errorThrown) {
							                var resultados = JSON.parse(responseObject);
							               	$("#slcArea").append('<option value="'+resultados.codigo_area+'">'+resultados.nombre_area+'</option>');


						               	///************************** obtener el periodo que ejecutivo seleccionó para trabajar ****************************************
											$.ajax({
											    type: 'post',
											    url: 'core/HomeReceivePeriodoFromIndex.php',
											    beforeSend: function() {
											    },
											    error: function(XMLHttpRequest, textStatus, errorThrown) {
												    if (XMLHttpRequest.readyState == 0) {
														$("#modalHomeConfig").attr('class', 'modal-dialog');
														$("#modalHomeTitle").text('Verifique su conexión a internet');
														$("#modalHomeContenido").attr('align', 'left');
														$("#modalHomeCerrarVentana").show();
														$("#modalHomeContenido").html('No se pudo establecer una conexión con el servidor del sistema de calidad y por lo tanto su solicitud no pudo ser procesada. <br /><strong>Por favor, verifique que la conexión de su ordenador se encuentre en orden, si usted se conecta vía Wi-Fi intente acercase al router para aumentar la señal o valique estar conectado a su red. Si ya ha intentado todo lo anterior, solicite ayuda llamando a la mesa de ayuda de tricot al anexo 616 o desde celulares al 2 2350 3616</strong>');
														$("#modalHomeBtnCerrar").show();
														$("#modalHomeBtnCerrar").text('Cerrar');
														$("#modalHomeBtnAccion").hide();
												    }
												},
											    statusCode: {
										            404: function(responseObject, textStatus, errorThrown) {
										            	$("#modalHome").modal('show');
										                $("#modalHomeTitle").text('´Problema al cargar el periodo');
										                $("#modalHomeContenido").attr('align', 'left');
										                $("#modalHomeCerrarVentana").show();
										                $("#modalHomeContenido").html('No se encontró respuesta del servidor para los periodos a trabajar<br /><strong>HTTP 404</strong>');
										                $("#modalHomeBtnCerrar").show();
										                $("#modalHomeBtnCerrar").text('Cerrar');
										                $("#modalHomeBtnAccion").hide();
										            },
										            200: function(responseObject, textStatus, errorThrown) {
										                var resultados = JSON.parse(responseObject);
										                
										                //eliminando valores existentes
										                $.each($("#slcPeriodo option"),function(i,v){
															value = v.value;
															$("#slcPeriodo option[value="+value+"]").remove();
														});

										                 $.each(resultados.periodos, function (index, value) {
										                    $("#slcPeriodo").append('<option value="'+value+'">'+value+'</option>');
										                 	
										                }); 


														/// CARGAR RESTO DE AREAS ******************************************************************************************
														$.ajax({
														    type: 'post',
														    url: 'core/ListAreas.php',
														    beforeSend: function() {
														    },
														    error: function(XMLHttpRequest, textStatus, errorThrown) {
															    if (XMLHttpRequest.readyState == 0) {
																	$("#modalHomeConfig").attr('class', 'modal-dialog');
																	$("#modalHomeTitle").text('Verifique su conexión a internet');
																	$("#modalHomeContenido").attr('align', 'left');
																	$("#modalHomeCerrarVentana").show();
																	$("#modalHomeContenido").html('No se pudo establecer una conexión con el servidor del sistema de calidad y por lo tanto su solicitud no pudo ser procesada. <br /><strong>Por favor, verifique que la conexión de su ordenador se encuentre en orden, si usted se conecta vía Wi-Fi intente acercase al router para aumentar la señal o valique estar conectado a su red. Si ya ha intentado todo lo anterior, solicite ayuda llamando a la mesa de ayuda de tricot al anexo 616 o desde celulares al 2 2350 3616</strong>');
																	$("#modalHomeBtnCerrar").show();
																	$("#modalHomeBtnCerrar").text('Cerrar');
																	$("#modalHomeBtnAccion").hide();
															    }
															},
														    statusCode: {
														            404: function(responseObject, textStatus, errorThrown) {
														            	$("#modalHome").modal('show');
														                $("#modalHomeTitle").text('´Problema al cargar las áreas');
														                $("#modalHomeContenido").attr('align', 'left');
														                $("#modalHomeCerrarVentana").show();
														                $("#modalHomeContenido").html('No se encontró respuesta del servidor para las áreas disponibles para trabajar<br /><strong>HTTP 404</strong>');
														                $("#modalHomeBtnCerrar").show();
														                $("#modalHomeBtnCerrar").text('Cerrar');
														                $("#modalHomeBtnAccion").hide();
														            },
														            200: function(responseObject, textStatus, errorThrown) {
														                var resultados = JSON.parse(responseObject);
														                 $.each(resultados, function (index, value) {
														                    if($("#slcArea :selected").text() != value.nombre_area) {
														                    	$("#slcArea").append('<option value="'+value.codigo_area+'">'+value.nombre_area+'</option>');
														                    }
														                });
														                $("#slcArea").removeAttr('disabled');

														                // cargar resto de periodos disponibles ************************************************************
											                			$.ajax({
																		    type: 'post',
																		    url: 'core/ListPeriodosParaEvaluar.php',
																		    beforeSend: function() {
																		    },
																		    error: function(XMLHttpRequest, textStatus, errorThrown) {
																			    if (XMLHttpRequest.readyState == 0) {
																					$("#modalHomeConfig").attr('class', 'modal-dialog');
																					$("#modalHomeTitle").text('Verifique su conexión a internet');
																					$("#modalHomeContenido").attr('align', 'left');
																					$("#modalHomeCerrarVentana").show();
																					$("#modalHomeContenido").html('No se pudo establecer una conexión con el servidor del sistema de calidad y por lo tanto su solicitud no pudo ser procesada. <br /><strong>Por favor, verifique que la conexión de su ordenador se encuentre en orden, si usted se conecta vía Wi-Fi intente acercase al router para aumentar la señal o valique estar conectado a su red. Si ya ha intentado todo lo anterior, solicite ayuda llamando a la mesa de ayuda de tricot al anexo 616 o desde celulares al 2 2350 3616</strong>');
																					$("#modalHomeBtnCerrar").show();
																					$("#modalHomeBtnCerrar").text('Cerrar');
																					$("#modalHomeBtnAccion").hide();
																			    }
																			},
																		    statusCode: {
																	            404: function(responseObject, textStatus, errorThrown) {
																	            	$("#modalHome").modal('show');
																	                $("#modalHomeTitle").text('´Problema al cargar el periodo');
																	                $("#modalHomeContenido").attr('align', 'left');
																	                $("#modalHomeCerrarVentana").show();
																	                $("#modalHomeContenido").html('No se encontró respuesta del servidor para los periodos a trabajar<br /><strong>HTTP 404</strong>');
																	                $("#modalHomeBtnCerrar").show();
																	                $("#modalHomeBtnCerrar").text('Cerrar');
																	                $("#modalHomeBtnAccion").hide();
																	            },
																	            200: function(responseObject, textStatus, errorThrown) {
																	                var resultados = JSON.parse(responseObject);
																	               
																	                 $.each(resultados.periodos, function (index, value) {
																	                    if($("#slcPeriodo :selected").text() != value) {
																	                    	$("#slcPeriodo").append('<option value="'+value+'">'+value+'</option>');
																	                    }
																	                }); 
																					$("#slcPeriodo").removeAttr('disabled');

																					var evaluador 	= $("#slcEvaluador :selected").val();
																					var periodo 	= $("#slcPeriodo :selected").val();
																					var area 		= $("#slcArea :selected").val();
																					actualizarListadoEjecutivos(periodo, area);
																					refrescarTabla();
																					actualizarEstadisticas();
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
							}
						}
					});
			}
		}
	});
});

$("#btnForceUpdate").click(function() {
	actualizarCentroApelaciones();
	actualizarEstadisticas();
	refrescarTabla();
});


$("#btnAprobar").click(function() {

	var response = $("#btnAprobar").text().trim();
	if(response == "Aprobar a nivel quincenal") {
		$("#modalHomeConfig").attr('class', 'modal-dialog');
		$("#modalHome").modal('show');
		$("#modalHomeTitle").text('Aprobación de Evaluaciones');
        $("#modalHomeContenido").attr('align', 'left');
        $("#modalHomeCerrarVentana").show();
        $("#modalHomeContenido").html('Esta a punto de declarar que se encuentra conforme tanto con la evaluación quincenal como con las evaluaciones parciales que la conforman para el periodo '+$("#slcPeriodo :selected").val()+'. ¿Esta seguro de proceder?, <p style="color: red;"><strong>recuerde que una vez aprobadas no podrá realizar proceso de apelación ni se podrán modificar estas evaluaciones.</strong></p>');
        $("#modalHomeBtnCerrar").show();
        $("#modalHomeBtnCerrar").text('Cancelar');
        $("#modalHomeBtnAccion").text('Aprobar Quincenales');
        $("#modalHomeBtnAccion").show();
	}else if(response == "Aprobar a nivel final") {
		$("#modalHomeConfig").attr('class', 'modal-dialog');
		$("#modalHome").modal('show');
		$("#modalHomeTitle").text('Aprobación de Evaluaciones');
        $("#modalHomeContenido").attr('align', 'left');
        $("#modalHomeCerrarVentana").show();
        $("#modalHomeContenido").html('Esta a punto de declarar que se encuentra conforme tanto con la evaluación final como con las evaluaciones parciales que la conforman para el periodo '+$("#slcPeriodo :selected").val()+'. ¿Esta seguro de proceder?, <p style="color: red;"><strong>recuerde que una vez aprobadas no podrá realizar proceso de apelación ni se podrán modificar estas evaluaciones.</strong></p>');        $("#modalHomeBtnCerrar").show();
        $("#modalHomeBtnCerrar").text('Cancelar');
        $("#modalHomeBtnAccion").text('Aprobar y cerrar periodo');
        $("#modalHomeBtnAccion").show();
	}
});

$("#btnDescargaMasiva").click(function() {
	var ejecutivo 	= $("#slcEjecutivo :selected").val();
	var periodo 	= $("#slcPeriodo :selected").val();
	$.ajax({
	    type: 'post',
	    url: 'core/SessionManager.php',
	    beforeSend: function() {
	        //inicializando modal que valida sesión de raulí
	        $("#slcArea").prop('disabled', 'disabled');
	        $("#slcPeriodo").prop('disabled', 'disabled');
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
	            $("#slcArea").removeAttr('disabled');
	        	$("#slcPeriodo").removeAttr('disabled');
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
	            $("#slcArea").removeAttr('disabled');
	        	$("#slcPeriodo").removeAttr('disabled');
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
	            $("#slcArea").removeAttr('disabled');
	        	$("#slcPeriodo").removeAttr('disabled');
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
	            $("#slcArea").removeAttr('disabled');
	        	$("#slcPeriodo").removeAttr('disabled');
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
	            $("#slcArea").removeAttr('disabled');
	        	$("#slcPeriodo").removeAttr('disabled');
	            return 0;
	        }, 
	        200: function(responseObject, textStatus, errorThrown) {
	        	$("#slcArea").removeAttr('disabled');
    			$("#slcPeriodo").removeAttr('disabled');
	        	window.location.href="../../centralreport/centralreport/core/exportXLSConsolidado.php?ejecutivo="+ejecutivo+"&periodo="+periodo;
	      	}
	    }
	});
});