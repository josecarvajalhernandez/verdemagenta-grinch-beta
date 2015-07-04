<?php 
/**GrinchVM  BETA
	
	autor:José Carvajal Hernández
	sitio: www.verdemagenta.cl

 	El uso es de esta aplicación es de uso exclusivo para el equipo de desarrollo, no del cliente final,
	por lo tanto este archivo luego de ser utilizado debe ser removido del servidor del cliente
*/  
	$proyecto 		   = 'verdemagenta';

	$BASE_DIRECTORY    = TRUE;
	$CONFIG_DIRECTORY  = TRUE;
	$DYNAMIC_DIRECTORY = TRUE;
	$MENU_FILE 		   = TRUE;	
	$HELPERS_DIRECTORY = TRUE;
	$ADMIN    	       = TRUE;//MODULOS DE ADMINISTRACION,CONTENIDO DEL SITIO,BLOG ETC(REQUIERE QUE $LOGIN_ADMIN SEA TRUE)

	if($HELPERS_DIRECTORY == TRUE)
	{
		$VALIDATION_HELPER = TRUE;
		$EMAIL_HELPER      = TRUE;
	}
	if($ADMIN == TRUE)
	{		
		$LOGIN_USER	 = TRUE;//(OPCIONAL)LOGIN COMUN PARA USUARIOS
		$LOGIN_ADMIN = TRUE;//(OBLIGATORIO SI SE REQUIERE ADMINISTRACION)LOGIN DE ADMINISTRACION DE MODULOS SOLO PARA CUENTAS DE ADMINISTRADOR
		$BLOG    	 = TRUE;
	}
if($BASE_DIRECTORY == TRUE)
{
/**CARPETAS BASE*/
	$folderBase = array('app','public');
	foreach($folderBase as $fdb)
	{
		mkdir($fdb, 0755);
		chmod($fdb, 0755);
	}
	$folderPublic = array('js','css','img');
	foreach ($folderPublic as $fdp)
	{
		mkdir('public/'.$fdp, 0755);
		chmod('public/'.$fdp, 0755);
	}
	touch(".htaccess", 0755);
	$htacces = fopen(".htaccess", "w");
	fwrite($htacces, "DirectoryIndex app/controllers/index/index.php" . PHP_EOL);
	fwrite($htacces,"RewriteEngine on" . PHP_EOL);
	fclose($htacces);

	touch("public/js/js.js", 0755);
	touch("public/css/estilo.css", 0755);	
		
//-------------------------------------------------------
//| DIRECTORIOS BASE        						   ||
//-------------------------------------------------------
	$baseDirectory = array('controllers','models','views','config','helpers');
	function saca_dominio($url)
	{
    	$protocolos = array('http://', 'https://', 'ftp://', 'www.','.cl','.com','.net','.org','.co','.es','.io','.info','.ar','.ve');
    	$url = explode('/', str_replace($protocolos, '', $url));
    	return $url[0];
	}
	echo 'Haz instalado el framework en '.saca_dominio($_SERVER["SERVER_NAME"]).' correctamente';
	
	foreach($baseDirectory as $b)
	{
		mkdir("app/".$b, 0755);
		chmod("app/".$b, 0755);
	}
	
	mkdir("app/views/viewBase", 0755);
	chmod("app/views/viewBase", 0755);
	
	touch("app/views/viewBase/header.php", 0755);
	
	$viewBaseHeader = fopen("app/views/viewBase/header.php", "w");
	
	fwrite($viewBaseHeader, "<!DOCTYPE html>" . PHP_EOL.
		 					"<html lang='esp'>" . PHP_EOL.
							"<head>" . PHP_EOL.
							"<meta charset='UTF-8'>" . PHP_EOL.
							"<meta name='viewport' content='width=device-width, initial-scale=1.0'> " . PHP_EOL.
							'<meta name="robots" content="INDEX,FOLLOW,ARCHIVE"> ' . PHP_EOL.
							'<meta name="description" content="<?=$description?>"/>' . PHP_EOL.
							'<meta name="author" content="VerdeMagenta"/>' . PHP_EOL.
	 					 	'<title><?=$title;?></title>' . PHP_EOL.
							"<link href='http://".'<?=$_SERVER["SERVER_NAME"]?>'."/public/css/estilo.css' rel='stylesheet' type='text/css'>" . PHP_EOL.
							"<script type='text/javascript' src='http://".'<?=$_SERVER["SERVER_NAME"]?>'."/public/js/js.js'></script>" . PHP_EOL.
							"</head>" . PHP_EOL.
							"<body>" . PHP_EOL.
							'<div><?=$nombreProyecto;?></div>' . PHP_EOL);
	fclose($viewBaseHeader);

	touch("app/views/viewBase/menu.php",0755);

	touch("app/views/viewBase/footer.php", 0755);
	$viewBaseFooter = fopen("app/views/viewBase/footer.php", "w");
	fwrite($viewBaseFooter, "<footer><h5>Powered by VerdeMagenta </h5></footer>" . PHP_EOL.
							"</body>" . PHP_EOL.
							"</html>" . PHP_EOL);
	fclose($viewBaseFooter);
}

if($CONFIG_DIRECTORY == TRUE)
{
//--------------------------------------------------------------------------------------------
// DIRECTORIOS DE CONFIGURACION							                                     |
//--------------------------------------------------------------------------------------------
//configuración estatica , solo es necesario editar la conexion a la base de datos

	$configDirectory = array('content','database','models','meta');
	
	foreach($configDirectory as $c)
	{
		touch("app/config/".$c.".php", 0755);
	}

		$configContent = fopen("app/config/content.php", "w");
		fwrite($configContent, '<?php' . PHP_EOL.
							   '$file = basename($_SERVER["PHP_SELF"]);' . PHP_EOL.
							   '$folder = str_replace(".php", "", $file);' . PHP_EOL.
							   "include('../../views/'.".'$folder'.".'/content.php');". PHP_EOL);
		fclose($configContent);

		$configDataBase = fopen("app/config/database.php", "w");
		fwrite($configDataBase, '<?php' . PHP_EOL.
								   	'function conexion()'. PHP_EOL.
								   	'{' . PHP_EOL.
								   	'	 $server   = "localhost"; ' . PHP_EOL.
								   	'	 $username = "root"; ' . PHP_EOL.
								   	'	 $password = ""; ' . PHP_EOL.
								   	'	 $database = "prueba"; ' . PHP_EOL.
							       	'	 $link     = mysqli_connect($server, $username, $password, $database);' . PHP_EOL.
							       	'	 mysqli_set_charset($link,"utf8");' . PHP_EOL.
							       	'	 return($link);' . PHP_EOL.
							       	'	 mysqli_close($link);' . PHP_EOL.
							       	'}');
		fclose($configDataBase);
		
		$configModel = fopen("app/config/models.php", "w");
		fwrite($configModel, '<?php' . PHP_EOL.
							 '$file = basename($_SERVER["PHP_SELF"]);' . PHP_EOL.
							 '$folder = str_replace(".php", "", $file);' . PHP_EOL.
							 "include('app/models/'.".'$file'.");");
		fclose($configModel);

		$configMeta = fopen("app/config/meta.php", "w");
		fwrite($configMeta, '<?php' . PHP_EOL.
							'session_start();'.PHP_EOL.  
							'function saca_dominio($url)'.PHP_EOL.
							'{'.PHP_EOL.
							'	$protocolos = array("http://", "https://", "ftp://", "www.",".cl",".com",".net",".org",".co",".es",".io",".info",".ar",".ve");'.PHP_EOL.
	                        '	$url = explode("/", str_replace($protocolos, "", $url));'.PHP_EOL.
    	                    '	return $url[0];'.PHP_EOL.
							'}'.PHP_EOL.
							'$nombreProyecto = saca_dominio($_SERVER["SERVER_NAME"]);'.PHP_EOL.
							'$urlBase        = $_SERVER["SERVER_NAME"];'.PHP_EOL.
							'$file           = basename($_SERVER["PHP_SELF"]);'.PHP_EOL.
							'$folder = str_replace(".php", "", $file);' .PHP_EOL.
							'$title          = $nombreProyecto;'.PHP_EOL.
							'$description    = $nombreProyecto;');
		fclose($configMeta);
}
if($DYNAMIC_DIRECTORY == TRUE)
{
//------------------------------------------------------------------------------------------------------------
//DIRECTORIOS DINAMICOS																						 |	
//------------------------------------------------------------------------------------------------------------
//el siguiente arrary debe ser modificado según las necesidades del proyecto(por defecto siempre debe ir index)
	
	$dynamicDirectory = array('index','nosotros','servicios','clientes','productos','contacto','blog');
	
	foreach($dynamicDirectory as $dd)
	{
		
		mkdir("app/controllers/".$dd, 0755);
		chmod("app/controllers/".$dd, 0755);

		touch("app/controllers/".$dd.'/'.$dd.".php", 0755);

		$controllers = fopen("app/controllers/".$dd.'/'.$dd.".php", "w");
		fwrite($controllers, "<?php" . PHP_EOL);
		fwrite($controllers, "include('../../config/meta.php');" . PHP_EOL);
		fwrite($controllers, "include('../../views/viewBase/header.php');" . PHP_EOL);
		if($LOGIN_USER == TRUE)
		{	
			fwrite($controllers, "include('../../helpers/login/login.php');" . PHP_EOL);
		}
		fwrite($controllers, "include('../../views/viewBase/menu.php');" . PHP_EOL);
		fwrite($controllers, "include('../../config/content.php');" . PHP_EOL);
		fwrite($controllers, "include('../../views/viewBase/footer.php');" . PHP_EOL);
		fclose($controllers);

		touch("app/models/".$dd.".php", 0755);

		$models = fopen("app/models/".$dd.".php", "w");
		fwrite($models, "<?php" . PHP_EOL);
		fwrite($models, "include('app/config/database.php');" . PHP_EOL);
		fwrite($models, '$link = conexion();' . PHP_EOL);
		fwrite($models, '$folder;' . PHP_EOL);
		fwrite($models, PHP_EOL);
		fwrite($models,	'function queryOneDataExist'.$dd.'($tuple,$value,$result)' . PHP_EOL);
		fwrite($models, "{" . PHP_EOL);
		fwrite($models, '	 global $link;' . PHP_EOL);
		fwrite($models, ' 	 global $folder;' . PHP_EOL);
		fwrite($models, '    $query  = " SELECT $result FROM $folder WHERE {$tuple} = '."'".'{$value}'."'".' ";' . PHP_EOL);
		fwrite($models, '	 $data   = mysqli_query($link, $query);' . PHP_EOL);
		fwrite($models, '    if(mysqli_num_rows($data) !== 0);' . PHP_EOL);
		fwrite($models, '    {' . PHP_EOL);
		fwrite($models, '     	 $row = mysqli_fetch_assoc($data);' . PHP_EOL);
		fwrite($models, '     	 $res = $row[$result];' . PHP_EOL);
		fwrite($models, '     	 return $res;' . PHP_EOL);
		fwrite($models, "    }" . PHP_EOL);
		fwrite($models, "    else" . PHP_EOL);
		fwrite($models, "    {" . PHP_EOL);
		fwrite($models, "     	 return FALSE;" . PHP_EOL);
		fwrite($models, "    }" . PHP_EOL);
		fwrite($models, "}" . PHP_EOL);
		fclose($models);

		mkdir("app/views/".$dd, 0755);
		chmod("app/views/".$dd, 0755);

		touch("app/views/".$dd."/content.php", 0755);
		$views = fopen("app/views/".$dd."/content.php", "w");
		fwrite($views, "<h2>$dd</h2>" . PHP_EOL);
		fclose($views);

		$dynamicMeta = fopen("app/config/meta.php", "a");
		fwrite($dynamicMeta, PHP_EOL . "if(".'$file'." == '".$dd.".php')");
		fwrite($dynamicMeta, PHP_EOL . "{");
		fwrite($dynamicMeta, PHP_EOL . '	$title'." = '".$dd."';");
		fwrite($dynamicMeta, PHP_EOL . '	$description'." = '".$dd."';");
		fwrite($dynamicMeta, PHP_EOL . "}");
		fclose($dynamicMeta);

		$htaccessDinamic = fopen(".htaccess", "a");
		fwrite($htaccessDinamic, "RewriteRule ^".$dd."$ /app/controllers/".$dd."/".$dd.".php [L]" . PHP_EOL);
		if($LOGIN_ADMIN == TRUE)
		{
			fwrite($htaccessDinamic, "RewriteRule ^cuenta/ingreso/".$dd."$ /app/controllers/cuenta/ingreso.php?pagina=".$dd." [L]" . PHP_EOL);
			fwrite($htaccessDinamic, "RewriteRule ^cuenta/registro/".$dd."$ /app/controllers/cuenta/registro.php?pagina=".$dd." [L]" . PHP_EOL);
		}
		fclose($htaccessDinamic);

	}
}
if($MENU_FILE == "TRUE")
{
		$dynamicMenu = fopen("app/views/viewBase/menu.php", "a");
		fwrite($dynamicMenu, PHP_EOL . '<ul>');
		foreach ($dynamicDirectory as $mn)
		{
			fwrite($dynamicMenu, PHP_EOL . "<li><a href='http://".'<?=$_SERVER["SERVER_NAME"]?>'."/".$mn."'>".$mn."</a></li>");	
		}
		fwrite($dynamicMenu, PHP_EOL . '</ul>');
		fclose($dynamicMenu);
}
//-------------------------------------------------------------
//INSTALANDOR HELPERS
//-------------------------------------------------------------
//los helper pueden ser activados según los modulos que necesite el proyecto
if($HELPERS_DIRECTORY == TRUE)
{

	if($EMAIL_HELPER == TRUE)
	{
		mkdir("app/helpers/email", 0755);
		chmod("app/helpers/email", 0755);

		touch("app/helpers/email/email.php", 0755);

		$helper_email = fopen("app/helpers/email/email.php", "w");
		fwrite($helper_email, '<?php' . PHP_EOL);
		fwrite($helper_email, 'function contactMe($message, $email)' . PHP_EOL);
		fwrite($helper_email, '{' . PHP_EOL);
		fwrite($helper_email, '		$to = "contacto@email.com";' . PHP_EOL);
		fwrite($helper_email, '		$subject = "title message";' . PHP_EOL);
		fwrite($helper_email, '		$txt = $message;' . PHP_EOL);
		fwrite($helper_email, '		$headers = "From: ".$email. "\r\n";' . PHP_EOL);
		fwrite($helper_email, '		$headers .= "Cc: example1@email.cl,example2@email.cl";' . PHP_EOL);
		fwrite($helper_email, '		mail($to,$subject,$txt,$headers);' . PHP_EOL);
		fwrite($helper_email, '}' . PHP_EOL);
		fclose($helper_email);
	}
	if($VALIDATION_HELPER == TRUE)
	{
		mkdir("app/helpers/validations", 0755);
		chmod("app/helpers/validations", 0755);
	
		touch("app/helpers/validations/validations.php", 0755);
		
		$helper_validation = fopen("app/helpers/validations/validations.php", "w");
		fwrite($helper_validation, '<?php' . PHP_EOL);
		fwrite($helper_validation, 'function textFieldOk($textField)' . PHP_EOL);
		fwrite($helper_validation, '{' . PHP_EOL);
		fwrite($helper_validation, '	if($textField == "")' . PHP_EOL);
		fwrite($helper_validation, '	{?>' . PHP_EOL);
		fwrite($helper_validation, '		return FALSE;' . PHP_EOL);
		fwrite($helper_validation, '	}' . PHP_EOL);
		fwrite($helper_validation, '	else' . PHP_EOL);
		fwrite($helper_validation, '	{' . PHP_EOL);
		fwrite($helper_validation, '		return TRUE;' . PHP_EOL);
		fwrite($helper_validation, '	}' . PHP_EOL);
		fwrite($helper_validation, '}' . PHP_EOL);
		fwrite($helper_validation,  PHP_EOL);
		fwrite($helper_validation, 'function clear($data) ' . PHP_EOL);
		fwrite($helper_validation, '{' . PHP_EOL);
		fwrite($helper_validation, '	$data = trim($data);' . PHP_EOL);
		fwrite($helper_validation, '	$data = stripslashes($data);' . PHP_EOL);
		fwrite($helper_validation, '	$data = htmlspecialchars($data);' . PHP_EOL);
		fwrite($helper_validation, '	return $data;' . PHP_EOL);
		fwrite($helper_validation, '}' . PHP_EOL);
		fwrite($helper_validation,  PHP_EOL);
		fwrite($helper_validation, 'function ValidateEmail($email)' . PHP_EOL);
		fwrite($helper_validation, '{' . PHP_EOL);
		fwrite($helper_validation, '	if (filter_var($email, FILTER_VALIDATE_EMAIL)) ' . PHP_EOL);
		fwrite($helper_validation, '	{' . PHP_EOL);
		fwrite($helper_validation, '		return TRUE;' . PHP_EOL);
		fwrite($helper_validation, '	}' . PHP_EOL);
		fwrite($helper_validation, '	else' . PHP_EOL);
		fwrite($helper_validation, '	{?>' . PHP_EOL);
		fwrite($helper_validation, '		<script>' . PHP_EOL);
		fwrite($helper_validation, "			alert('debes ingresar un email Valido');" . PHP_EOL);
		fwrite($helper_validation, '			self.location = "contacts.php";' . PHP_EOL);
		fwrite($helper_validation, '		</script><?php ' . PHP_EOL);
		fwrite($helper_validation, '	}' . PHP_EOL);
		fwrite($helper_validation, '}' . PHP_EOL);
		fclose($helper_validation);
	}
}
if($ADMIN == TRUE)
{
//------------------------------------------------------------------------------------------------
//CONEXIÓN A BASE DE DATOS Y CREACIÓN DE USUARIO
//------------------------------------------------------------------------------------------------
	$server   = "localhost"; 
	$username = "root"; 
	$password = ""; 
	$database = "prueba"; 
	$conec     = mysqli_connect($server, $username, $password, $database);
	 	
	mysqli_set_charset($conec,"utf8");

	$crearTablaUsuario = "CREATE TABLE usuario (id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,nombre VARCHAR(70) NOT NULL,usuario VARCHAR(50) NOT NULL,password VARCHAR(50) NOT NULL,correo VARCHAR(50) NOT NULL,permiso VARCHAR(25) NOT NULL,fecha_registro TIMESTAMP)";

	$ejecutar   	   = mysqli_query($conec, $crearTablaUsuario);
		
	$insertarUsuario   = "INSERT INTO usuario (usuario,password,nombre,permiso,correo)values('admin','admin','administrador','administrador','contacto@".$proyecto.".cl')";
	$ejecutar   	   = mysqli_query($conec, $insertarUsuario);

//----------------------------------------------------------------------------------------
	
	mkdir("app/controllers/admin",0755);
	mkdir("app/views/admin",0755);
	
	touch("app/controllers/admin/admin.php", 0755);
	touch("app/views/viewBase/menuAdmin.php", 0755);
	touch("app/views/admin/contentAdmin.php", 0755);	

	$contentAdmin = fopen("app/views/admin/contentAdmin.php", "w");
	fwrite($contentAdmin, '<h2>Panel de administración <?=$nombreProyecto;?></h2>' . PHP_EOL);
	fclose($contentAdmin);

	$admin = fopen("app/controllers/admin/admin.php","w");

	fwrite($admin,'<?php'.PHP_EOL);
	fwrite($admin,'include("../../config/meta.php");'.PHP_EOL);
	fwrite($admin,'include("../../views/viewBase/header.php");'.PHP_EOL);
	fwrite($admin,'include("../../views/viewBase/menu.php");'.PHP_EOL);
	fwrite($admin,'include("../../views/viewBase/menuAdmin.php");'.PHP_EOL);
	fwrite($admin,'include("../../views/admin/contentAdmin.php");'.PHP_EOL);
	fwrite($admin,'include("../../views/viewBase/footer.php");'.PHP_EOL);

	$adminMenu = fopen("app/views/viewBase/menuAdmin.php", "w");
	fwrite($adminMenu,PHP_EOL.'<h3>Menú de Administración</h3>');
	fwrite($adminMenu,PHP_EOL.'<ul>');
	fwrite($adminMenu,PHP_EOL."	<li><a href='http://".'<?=$urlBase?>'."/admin'>Home</a></li>".PHP_EOL);

	$htaccessAdmin= fopen(".htaccess", "a");
	fwrite($htaccessAdmin, "RewriteRule ^admin$ /app/controllers/admin/admin.php [L]" . PHP_EOL);
	fwrite($htaccessAdmin, "RewriteRule ^cuenta/cerrar$ /app/controllers/cuenta/cerrar.php [L]" . PHP_EOL);
	fclose($htaccessAdmin);


	mkdir("app/helpers/login",0755);
	touch("app/helpers/login/login.php",0755);
	$herlperLogin = fopen("app/helpers/login/login.php", "w");
	fwrite($herlperLogin,  '<?php' . PHP_EOL);
	fwrite($herlperLogin,  'if(!isset($_SESSION["usuario"]))' . PHP_EOL);
	fwrite($herlperLogin,  '{' . PHP_EOL);
	fwrite($herlperLogin,  '	include("../../views/viewBase/login.php");' . PHP_EOL);
	fwrite($herlperLogin,  '}' . PHP_EOL);
	fwrite($herlperLogin,  'else' . PHP_EOL);
	fwrite($herlperLogin,  '{?>' . PHP_EOL);
	fwrite($herlperLogin,  "	<a href='http://".'<?=$urlBase?>'."/cuenta/cerrar'>cerrar sesion</a><?php" . PHP_EOL);
	fwrite($herlperLogin,  '}' . PHP_EOL);
	fclose($herlperLogin);

	if($BLOG == TRUE) 
	{
		$htaccessBlog = fopen(".htaccess", "a");
		fwrite($htaccessBlog, "RewriteRule ^admin/blog$ /app/controllers/admin/blog.php [L]" . PHP_EOL);
		fwrite($htaccessBlog, "RewriteRule ^admin/blog/$ /app/controllers/admin/blog.php [L]" . PHP_EOL);
		fclose($htaccessBlog);

		fwrite($adminMenu,"	<li><a href='http://".'<?=$urlBase?>'."/admin/blog'>blog</a></li>".PHP_EOL);
		
		touch("app/controllers/admin/blog.php", 0755);
		touch("app/views/admin/contentBlog.php", 0755);

		$contentBlog = fopen("app/views/admin/contentBlog.php", "w");
		fwrite($contentBlog, '<h2>Panel de administración <?=$nombreProyecto;?>|<?=$folder;?></h2>' . PHP_EOL);
		fclose($contentBlog);

		$adminBlog = fopen("app/controllers/admin/blog.php", "w");
		
		fwrite($adminBlog,'<?php'.PHP_EOL);
		fwrite($adminBlog,'include("../../config/meta.php");'.PHP_EOL);
		fwrite($adminBlog,'include("../../views/viewBase/header.php");'.PHP_EOL);
		fwrite($adminBlog,'include("../../views/viewBase/menu.php");'.PHP_EOL);
		fwrite($adminBlog,'include("../../views/viewBase/menuAdmin.php");'.PHP_EOL);
		fwrite($adminBlog,'include("../../views/admin/contentBlog.php");'.PHP_EOL);
		fwrite($adminBlog,'include("../../views/viewBase/footer.php");'.PHP_EOL);
		fclose($adminBlog);
	}
	if($LOGIN_USER == TRUE)
	{
		touch("app/views/viewBase/login.php",755);
		$login = fopen("app/views/viewBase/login.php", "w");
		fwrite($login, "<a href='http://".'<?=$urlBase?>'."/cuenta/ingreso/".'<?=$folder?>'."'>Ingresa</a>|<a href='http://".'<?=$urlBase?>'."/cuenta/registro/".'<?=$folder?>'."'>Regístrate</a>". PHP_EOL);
		fclose($login);
	}
	if($LOGIN_ADMIN == TRUE)
	{
		$htaccessPerfil    = fopen(".htaccess", "a");
		fwrite($htaccessPerfil, "RewriteRule ^admin/mi-perfil$ /app/controllers/admin/perfil.php [L]" . PHP_EOL);
		fwrite($htaccessPerfil, "RewriteRule ^admin/mi-perfil/$ /app/controllers/admin/perfil.php [L]" . PHP_EOL);
		fclose($htaccessPerfil);
		

		fwrite($adminMenu,"<li><a href='http://".'<?=$urlBase?>'."/admin/mi-perfil'>perfil</a></li>".PHP_EOL);
		

		mkdir("app/views/formularios", 0755);
		chmod("app/views/formularios", 0755);

		touch("app/views/formularios/ingreso.php",755);		
		$formularioIngreso = fopen("app/views/formularios/ingreso.php", "w");
		fwrite($formularioIngreso, '<form name="ingreso" action="" method="post">' . PHP_EOL);
		fwrite($formularioIngreso, '	<input required="required" placeholder="Usuario" type="text" name="usuario"><br/>' . PHP_EOL);
		fwrite($formularioIngreso, '	<input required="required" placeholder="Contraseña" type="password" name="password"><br/>' . PHP_EOL);
		fwrite($formularioIngreso, "	<input type='hidden' name='pagina' value=".'"<?=$_GET["pagina"];?>"'.">" . PHP_EOL);
		fwrite($formularioIngreso, '	<input type="submit" name="btnIngreso" value="ingresa"><br/>' . PHP_EOL);
		fwrite($formularioIngreso, '</form>' . PHP_EOL);
		fclose($formularioIngreso);

		touch("app/views/formularios/registro.php",755);
		$formularioRegistro = fopen("app/views/formularios/registro.php", "w");	
		fwrite($formularioRegistro,'<form name="registro" action="" method="POST">'.PHP_EOL.
								   '	<input type="text" name="nombre" required placeholder="Nombre"><br/>'.PHP_EOL.
								   '	<input type="text" name="correo" required placeholder="E-mail"><br/>'.PHP_EOL.
								   '	<input type="text" name="usuario" required placeholder="Usuario"><br/>'.PHP_EOL.
								   '    <input type="password" name="password" required placeholder="Contraseña"><br/>'.PHP_EOL.
								   '	<input type="password" name="password2" required placeholder="Repita Contraseña"><br/>'.PHP_EOL.
								   '  	<input type="submit" name="enviando-form-registro" required value="Resgistrar"><br/>'.PHP_EOL.
								   '</form>'.PHP_EOL);
		mkdir("app/controllers/cuenta", 0755);
		chmod("app/controllers/cuenta", 0755);


		touch("app/controllers/cuenta/ingreso.php", 0755);
		$contentLogin = fopen("app/controllers/cuenta/ingreso.php", "w");
		fwrite($contentLogin,  '<?php'.PHP_EOL.
						  	   "include('../../config/meta.php');".PHP_EOL.
						  	   'if($_POST)'.PHP_EOL.
						  	   '{'.PHP_EOL.
						  	   '	if($_POST["btnIngreso"] == "ingresa")'.PHP_EOL.
							   '	{'.PHP_EOL.
							   '		include("../../helpers/validations/validations.php");'.PHP_EOL.
							   ''.PHP_EOL.
							   '		$usuario  = clear($_POST["usuario"]);'.PHP_EOL.
							   '		$password = clear($_POST["password"]);'.PHP_EOL.
							   ''.PHP_EOL.
							   '		$usuarioOk  = textFieldOk($usuario);'.PHP_EOL.
							   '		$passwordOk = textFieldOk($password);'.PHP_EOL.
							   ''.PHP_EOL.
							   '		if(($usuarioOk == TRUE)&&($passwordOk == TRUE))'.PHP_EOL.
							   '		{'.PHP_EOL.
							   '			include("../../models/usuario.php");'.PHP_EOL.
							   '			$query = usuarioExiste($usuario,$password);'.PHP_EOL.
							   ''.PHP_EOL.		
							   '	    	if($query == TRUE)'.PHP_EOL.
							   '			{'.PHP_EOL.
							   '				$_SESSION["usuario"] = $usuarioOk;'.PHP_EOL.
							   '				header("Location: ../../".$_POST["pagina"]);'.PHP_EOL.
							   '			}'.PHP_EOL.
							   '			else'.PHP_EOL.
							   '			{?>'.PHP_EOL.
							   '				<script>'.PHP_EOL.
							   "					alert('el usuario y/o contraseña son incorrectos');".PHP_EOL.	
							   "  				</script><?php".PHP_EOL.
							   '			}'.PHP_EOL.
							   '		}'.PHP_EOL.
							   '		else'.PHP_EOL.
							   '		{?>'.PHP_EOL.
							   '			<script>'.PHP_EOL.
							   '				alert("debes completar todos los campos");'.PHP_EOL.
  							   '			</script><?php'.PHP_EOL.
							   '		}'.PHP_EOL.	
							   '	}'.PHP_EOL.
							   '	else'.PHP_EOL.
							   '	{'.PHP_EOL.
							   '		header("Location: ../index");'.PHP_EOL.
							   '	}'.PHP_EOL.
						  	   '}'.PHP_EOL.
						  	   "include('../../views/viewBase/header.php');".PHP_EOL.
						  	   "include('../../views/viewBase/menu.php');".PHP_EOL.
						  	   "include('../../views/cuenta/ingreso.php');".PHP_EOL.
						  	   "include('../../views/viewBase/footer.php');".PHP_EOL);
		fclose($contentLogin);


		touch("app/controllers/cuenta/cerrar.php", 0755);		
		$cerrarCuenta = fopen("app/controllers/cuenta/cerrar.php", "w");
		fwrite($cerrarCuenta, '<?php' . PHP_EOL.
							  'session_start();' . PHP_EOL.
							  'session_destroy();' . PHP_EOL.
					  		  "header('location: ../index');".PHP_EOL);
		fclose($cerrarCuenta);


		touch("app/controllers/cuenta/registro.php", 0755);
		$registrarUsuario = fopen("app/controllers/cuenta/registro.php", "w");
		fwrite($registrarUsuario,  '<?php' . PHP_EOL.
								   "include('../../config/meta.php');".PHP_EOL.
								   "include('../../views/viewBase/header.php');".PHP_EOL.
								   "include('../../views/viewBase/menu.php');".PHP_EOL.
								   "include('../../views/cuenta/registro.php');".PHP_EOL.
								   "include('../../views/viewBase/footer.php');".PHP_EOL);
		fclose($registrarUsuario);

		mkdir("app/views/cuenta", 0755);
		chmod("app/views/cuenta", 0755);

		touch("app/views/cuenta/ingreso.php", 0755);		
		$contentIngreso = fopen("app/views/cuenta/ingreso.php","w");
		fwrite($contentIngreso, '<?php include("../../views/formularios/ingreso.php");?>' . PHP_EOL.
								'<a href="">(¿olvidaste tu contraseña?)</a> o <a href="">registrate</a>' . PHP_EOL);
		fclose($contentIngreso);

		touch("app/views/cuenta/registro.php", 0755);		
		$contentIngreso = fopen("app/views/cuenta/registro.php","w");
		fwrite($contentIngreso, '<?php include("../../views/formularios/registro.php");?>' . PHP_EOL);
		fclose($contentIngreso);

		touch("app/views/admin/contentPerfil.php", 0755);
		$contentLogin 	= fopen("app/views/admin/contentPerfil.php", "w");
		fwrite($contentLogin, '<h2>Panel de administración <?=$nombreProyecto;?>|<?=$folder;?></h2>' . PHP_EOL);
		fclose($contentLogin);


		touch('app/models/usuario.php',0755);
		$modelusuario = fopen("app/models/usuario.php","w");
		fwrite($modelusuario,  '<?php ' .PHP_EOL.
							   'require("../../config/database.php");' .PHP_EOL.
							   '$link = conexion();' .PHP_EOL.
							   '' .PHP_EOL.
							   'function usuarioExiste($usuario,$password)' .PHP_EOL.
		  					   '{' .PHP_EOL.
		  					   '	global $link;' .PHP_EOL.
							   '' .PHP_EOL.
							   '	$query  = " SELECT id FROM usuario WHERE usuario = '."'".'{$usuario}'."'".'  AND password = '."'".'{$password}'."'".' ";' .PHP_EOL.
							   '' .PHP_EOL.
							   '	$data   = mysqli_query($link, $query);' .PHP_EOL.
							   '	if(mysqli_num_rows($data) !== 0)' .PHP_EOL.
							   '	{' .PHP_EOL.
							   '		$row = mysqli_fetch_assoc($data);' .PHP_EOL.
							   '		$res = $row["id"]; ' .PHP_EOL.
							   '' .PHP_EOL.
							   '		return $res;' .PHP_EOL.
							   '    }' .PHP_EOL.
							   '	else' .PHP_EOL.
							   '	{' .PHP_EOL.
							   '     	return FALSE;' .PHP_EOL.
							   '	}' .PHP_EOL.
							   '}' .PHP_EOL);
		fclose($modelusuario);
        

		touch("app/controllers/admin/perfil.php", 0755);		
		$adminBlog = fopen("app/controllers/admin/perfil.php", "w");
		fwrite($adminBlog,'<?php'.PHP_EOL.
						  'include("../../config/meta.php");'.PHP_EOL.
					  	  'include("../../views/viewBase/header.php");'.PHP_EOL.
						  'include("../../views/viewBase/menu.php");'.PHP_EOL.
						  'include("../../views/viewBase/menuAdmin.php");'.PHP_EOL.
						  'include("../../views/admin/contentPerfil.php");'.PHP_EOL.
						  'include("../../views/viewBase/footer.php");'.PHP_EOL);
		fclose($adminBlog);
	}
	fwrite($adminMenu, PHP_EOL.'</ul>');
	fclose($adminMenu);
}