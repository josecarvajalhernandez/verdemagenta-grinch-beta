<?php 
/**GrinchVM Beta V 1.3.5.2
 	
 	El uso es de esta aplicación es de uso exclusivo para el equipo de desarrollo, no del cliente final,
	por lo tanto este archivo luego de ser utilizado debe ser removido del servidor del cliente
*/
	$BASE_DIRECTORY    = TRUE;
	$CONFIG_DIRECTORY  = TRUE;
	$DYNAMIC_DIRECTORY = TRUE;
	$HELPERS_DIRECTORY = TRUE;
	$MENU_FILE 		   = TRUE;
	$ADMIN    	       = TRUE;

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
	fwrite($viewBaseHeader, "<!DOCTYPE html>" . PHP_EOL);
	fwrite($viewBaseHeader, "<html lang='esp'>" . PHP_EOL);
	fwrite($viewBaseHeader, "<head>" . PHP_EOL);
	fwrite($viewBaseHeader, "<meta charset='UTF-8'>" . PHP_EOL);
	fwrite($viewBaseHeader, "<meta name='viewport' content='width=device-width, initial-scale=1.0'> " . PHP_EOL);
	fwrite($viewBaseHeader, '<meta name="robots" content="INDEX,FOLLOW,ARCHIVE"> ' . PHP_EOL);
	fwrite($viewBaseHeader, '<meta name="description" content="<?=$description?>"/>' . PHP_EOL);
	fwrite($viewBaseHeader, '<meta name="author" content="VerdeMagenta"/>' . PHP_EOL);
	fwrite($viewBaseHeader, '<title><?=$title;?></title>' . PHP_EOL);
	fwrite($viewBaseHeader, "<link href='http://".'<?=$_SERVER["SERVER_NAME"]?>'."/public/css/estilo.css' rel='stylesheet' type='text/css'>" . PHP_EOL);
	fwrite($viewBaseHeader, "<script type='text/javascript' src='http://".'<?=$_SERVER["SERVER_NAME"]?>'."/public/js/js.js'></script>" . PHP_EOL);
	fwrite($viewBaseHeader, "</head>" . PHP_EOL);
	fwrite($viewBaseHeader, "<body>" . PHP_EOL);
	fwrite($viewBaseHeader, '<div><?=$nombreProyecto;?></div>' . PHP_EOL);
	fclose($viewBaseHeader);

	touch("app/views/viewBase/menu.php",0755);

	touch("app/views/viewBase/footer.php", 0755);
	$viewBaseFooter = fopen("app/views/viewBase/footer.php", "w");
	fwrite($viewBaseFooter, "<footer><h5>Powered by VerdeMagenta </h5></footer>" . PHP_EOL);
	fwrite($viewBaseFooter, "</body>" . PHP_EOL);
	fwrite($viewBaseFooter, "</html>" . PHP_EOL);
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
							   "include('../../views/'.".'$folder'.".'/content.php');");
		fclose($configContent);

		$configDataBase = fopen("app/config/database.php", "w");
		fwrite($configDataBase, '<?php' . PHP_EOL.
								   	'function conexion()'. PHP_EOL.
								   	'{' . PHP_EOL.
								   	'	 $server   = "localhost"; ' . PHP_EOL.
								   	'	 $username = "usuario"; ' . PHP_EOL.
								   	'	 $password = "clave"; ' . PHP_EOL.
								   	'	 $database = "base de datos"; ' . PHP_EOL.
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
							'function saca_dominio($url)'.PHP_EOL.
							'{'.PHP_EOL.
							'	$protocolos = array("http://", "https://", "ftp://", "www.",".cl",".com",".net",".org",".co",".es",".io",".info",".ar",".ve");'.PHP_EOL.
	                        '	$url = explode("/", str_replace($protocolos, "", $url));'.PHP_EOL.
    	                    '	return $url[0];'.PHP_EOL.
							'}'.PHP_EOL.
							'$nombreProyecto = saca_dominio($_SERVER["SERVER_NAME"]);'.PHP_EOL.
							'$urlBase        = $_SERVER["SERVER_NAME"];'.PHP_EOL.
							'$file           = basename($_SERVER["PHP_SELF"]);'.PHP_EOL.
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
		fwrite($models,  PHP_EOL);
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
		fwrite($dynamicMeta, PHP_EOL . "if(".'$file'." == '".$dd.".php')".'$title'." = '".$dd."';");
		fwrite($dynamicMeta, PHP_EOL . "if(".'$file'." == '".$dd.".php')".'$description'." = '".$dd."';");
		fclose($dynamicMeta);

		$htaccessDinamic = fopen(".htaccess", "a");
		fwrite($htaccessDinamic, "RewriteRule ^".$dd."$ /app/controllers/".$dd."/".$dd.".php [L]" . PHP_EOL);
		fwrite($htaccessDinamic, "RewriteRule ^".$dd."/$ /app/controllers/".$dd."/".$dd.".php [L]" . PHP_EOL);
		fclose($htaccessDinamic);

	}
}
if($MENU_FILE == "TRUE")
{
		$dynamicMeta = fopen("app/views/viewBase/menu.php", "a");
		fwrite($dynamicMeta, PHP_EOL . '<ul>');
		foreach ($dynamicDirectory as $mn)
		{
			fwrite($dynamicMeta, PHP_EOL . "<li><a href='http://".'<?=$_SERVER["SERVER_NAME"]?>'."/".$mn."'>".$mn."</a></li>");	
		}
		fwrite($dynamicMeta, PHP_EOL . '</ul>');
		fclose($dynamicMeta);
}
//-------------------------------------------------------------
//INSTALANDOR HELPERS
//-------------------------------------------------------------
//los helper pueden ser activados según los modulos que necesite el proyecto
if($HELPERS_DIRECTORY == TRUE)
{
	$VALIDATION_HELPER = TRUE;
	$EMAIL_HELPER      = TRUE;

	if($EMAIL_HELPER == TRUE)
	{
		mkdir("app/helpers/email", 0755);
		chmod("app/helpers/email", 0755);

		touch("app/helpers/email/email.php", 0755);

		$helper_email = fopen("app/helpers/email/email.php", "w");
		fwrite($helper_email, '<?php' . PHP_EOL);
		fwrite($helper_email, 'function contactMe($message, $email)' . PHP_EOL);
		fwrite($helper_email, '{' . PHP_EOL);
		fwrite($helper_email, '		$to = "exampl@email.com";' . PHP_EOL);
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
		fwrite($helper_validation, '		<script>' . PHP_EOL);
		fwrite($helper_validation, "			alert('debes completar todos los campos de texto');" . PHP_EOL);
		fwrite($helper_validation, '			self.location = "contacts.php";' . PHP_EOL);
		fwrite($helper_validation, '		</script><?php' . PHP_EOL);
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
	$LOGIN = TRUE;
	$BLOG    = TRUE;
	
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
	fwrite($adminMenu,PHP_EOL."	<li><a href='http://".'<?=$urlBase?>'."/admin'>Home</a></li>");

	$htaccessAdmin= fopen(".htaccess", "a");
	fwrite($htaccessAdmin, "RewriteRule ^admin$ /app/controllers/admin/admin.php [L]" . PHP_EOL);
	fwrite($htaccessAdmin, "RewriteRule ^admin/$ /app/controllers/admin/admin.php [L]" . PHP_EOL);
	fclose($htaccessAdmin);

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
		fwrite($contentBlog, '<h2>Panel de administración <?=$nombreProyecto;?>|<?=$file;?></h2>' . PHP_EOL);
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
	if($LOGIN == TRUE)
	{
		$htaccessPerfil = fopen(".htaccess", "a");
		fwrite($htaccessPerfil, "RewriteRule ^admin/mi-perfil$ /app/controllers/admin/perfil.php [L]" . PHP_EOL);
		fwrite($htaccessPerfil, "RewriteRule ^admin/mi-perfil/$ /app/controllers/admin/perfil.php [L]" . PHP_EOL);
		fclose($htaccessPerfil);
		fwrite($adminMenu,"	<li><a href='http://".'<?=$urlBase?>'."/admin/mi-perfil'>Mi Perfil</a></li>".PHP_EOL);

		touch("app/controllers/admin/perfil.php", 0755);
		touch("app/views/admin/contentPerfil.php", 0755);

		$contentLogin = fopen("app/views/admin/contentPerfil.php", "w");
		fwrite($contentLogin, '<h2>Panel de administración <?=$nombreProyecto;?>|<?=$file;?></h2>' . PHP_EOL);
		fclose($contentLogin);

		$adminBlog = fopen("app/controllers/admin/perfil.php", "w");
		
		fwrite($adminBlog,'<?php'.PHP_EOL);
		fwrite($adminBlog,'include("../../config/meta.php");'.PHP_EOL);
		fwrite($adminBlog,'include("../../views/viewBase/header.php");'.PHP_EOL);
		fwrite($adminBlog,'include("../../views/viewBase/menu.php");'.PHP_EOL);
		fwrite($adminBlog,'include("../../views/viewBase/menuAdmin.php");'.PHP_EOL);
		fwrite($adminBlog,'include("../../views/admin/contentPerfil.php");'.PHP_EOL);
		fwrite($adminBlog,'include("../../views/viewBase/footer.php");'.PHP_EOL);
		fclose($adminBlog);
	}	
	fwrite($adminMenu, PHP_EOL.'</ul>');
	fclose($adminMenu);
}