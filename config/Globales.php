<?php
	//***************************************************
	// S I S T E M A
	//***************************************************
		//Ambiente (DES: Desarrollo / PRD: Produccion)
		define('ambiente', 'DEV');
		//Zona horaria
		date_default_timezone_set('America/Santiago');

	//***************************************************
	// S E G U R I D A D
	//***************************************************
		//Tiempo máximo de inactividad del usuario
		define('maxTiempoInactividad', 30);

	//***************************************************
	// D I R E C T O R I O S  y  O T R O S
	//***************************************************
		//directorio base del sistema
		define('dirbase'		, $_SERVER["DOCUMENT_ROOT"]);
		//directorio de controladores
		define('dirConfig'		, dirbase.'/revision/config/');
		//directorio de controladores
		define('dirController'	, dirbase.'/revision/controller/');
		//directorio de cores
		define('dirCore'		, dirbase.'/revision/core/');
		//directorio de fachada
		define('dirFacade'		, dirbase.'/revision/facade/');
		//directorio de frameworks utilizados
		define('dirFramework'	, dirbase.'/revision/framework/');
		//direcotiors de modelos de la base de datos
		define('dirModel'		, dirbase.'/revision/model/');
		//directorio del transaccional
		define('dirTransaction'	, dirbase.'/revision/transaction/');
		//directorio de attachments
		define('dirFileAttachments'	, dirbase.'/calidad/files/attachments/');
		//directorio de audios
		define('dirFileAudio'	, dirbase.'/calidad/files/audio/');
		//directorio de finales
		define('dirFileFinales'	, dirbase.'/calidad/files/finales/');
		//directorio de parciales
		define('dirFileParciales'	, dirbase.'/calidad/files/parciales/');
		//directorio de quincenales
		define('dirFilesQuincenales'	, dirbase.'/calidad/files/quincenales/');
		//directorio temporal de carga de archivos
		define('dirFileesTemporal'	, dirbase.'/calidad/files/tmp/');
		//directorio de templates de reportería PDF
		define('dirPDFTemplates'	, dirbase.'/calidad/templatepdf/');
		//FQDN reconocible en DNS de servidor
		define('DomainNameURL'		, 'http://localhost/calidad/');

	//***************************************************
	// C O N E X I O N   D A T A B A S E
	//***************************************************
	if(ambiente == 'DEV') {
		//configuración de conexión de desarrollo
		define('servidorMysql'	, 'localhost');
		define('usuarioMysql'	, 'root');
		define('passwordMysql'	, 'Tricot');
		define('databaseMysql'	, 'calidad');
		define('puertoMysql'	,  3306);
	}else{
		//configuración de conexión de producción
		define('servidorMysql'	, 'localhost');
		define('usuarioMysql'	, 'nrgchile_calidad');
		define('passwordMysql'	, 'calidad2020$$');
		define('databaseMysql'	, 'nrgchile_calidad');
		define('puertoMysql'	, 3306);
	}


	//***************************************************
	// C O N F I G U R A C I O N E S   G L O B A L E S
	//***************************************************
	if(ambiente == 'DEV') {
		//Reporte de Errores en desarrollo de sitio web
		error_reporting(E_ALL);
	}else{
		//Reporte de Errores en producción de sitio web
		error_reporting(0);
	}
?>