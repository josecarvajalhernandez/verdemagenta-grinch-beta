<?php
/**GrinchVM Beta V 1.3*/
	$BASE_DIRECTORY    = TRUE;
	$CONFIG_DIRECTORY  = TRUE;
	$DYNAMIC_DIRECTORY = TRUE;
	$HELPERS_DIRECTORY = TRUE;

if($BASE_DIRECTORY == TRUE)
{
/**CARPETAS BASE*/
	$folderBase = array('app','js','css','img');
	
	foreach($folderBase as $fdb)
	{
		mkdir($fdb, 0755);
		chmod($fdb, 0755);
	}
	touch("index.php", 0755);
	touch("js/js.js", 0755);
	touch("css/estilo.css", 0755);
		
		$mod = fopen("index.php", "w");
		fwrite($mod, "<?php" . PHP_EOL);
		fwrite($mod, "include('app/config/controller.php');" . PHP_EOL);
		fclose($mod);
//-------------------------------------------------------
//| DIRECTORIOS basename(path)						   ||
//-------------------------------------------------------
	$baseDirectory = array('controllers','models','views','config','helpers');
	
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
	fwrite($viewBaseHeader, "<meta charset='UTF-8'>" . PHP_EOL);
	fwrite($viewBaseHeader, "<meta name='viewport' content='width=device-width, initial-scale=1.0'> " . PHP_EOL);
	fwrite($viewBaseHeader, '<meta name="robots" content="INDEX,FOLLOW,ARCHIVE"> ' . PHP_EOL);
	fwrite($viewBaseHeader, '<meta name="description" content="<?=$description?>"/>' . PHP_EOL);
	fwrite($viewBaseHeader, '<meta name="author" content="VerdeMagenta"/>' . PHP_EOL);
	fwrite($viewBaseHeader, "<body>" . PHP_EOL);
	fwrite($viewBaseHeader, '<title><?=$title;?></title>' . PHP_EOL);
	fwrite($viewBaseHeader, '<link href="css/estilo.css" rel="stylesheet" type="text/css">' . PHP_EOL);
	fwrite($viewBaseHeader, '<script type="text/javascript" src="js/js.js"></script>' . PHP_EOL);
	fwrite($viewBaseHeader, "<header><h3>HEADER</h3></header>" . PHP_EOL);
	fclose($viewBaseHeader);

	touch("app/views/viewBase/footer.php", 0755);
	$viewBaseFooter = fopen("app/views/viewBase/footer.php", "w");
	fwrite($viewBaseFooter, "<footer><h3>FOOTER</h3></footer>" . PHP_EOL);
	fwrite($viewBaseFooter, "</body>" . PHP_EOL);
	fwrite($viewBaseFooter, "</html>" . PHP_EOL);
	fclose($viewBaseFooter);
}
if($CONFIG_DIRECTORY == TRUE)
{
//-----------------------------------------------------------
// DIRECTORIOS DE CONFIGURACION
//--------------------------------------------------------
//configuración estatica , solo es necesario editar la conexion a la base de datos
	$configDirectory = array('content','controller','database','models','meta');
	
	foreach($configDirectory as $c)
	{
		touch("app/config/".$c.".php", 0755);
	}

		$configContent = fopen("app/config/content.php", "w");
		fwrite($configContent, '<?php' . PHP_EOL.
							   '$file = basename($_SERVER["PHP_SELF"]);' . PHP_EOL.
							   '$folder = str_replace(".php", "", $file);' . PHP_EOL.
							   "include('app/views/'.".'$folder'.".'/content.php');");
		fclose($configContent);

		$configController = fopen("app/config/controller.php", "w");
		fwrite($configController, '<?php' . PHP_EOL.
								   '$file = basename($_SERVER["PHP_SELF"]);' . PHP_EOL.
								   '$folder = str_replace(".php", "", $file);' . PHP_EOL.
							       "include('app/controllers/'.".'$folder'.".'/'.".'$file'.");");
		fclose($configController);

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
		fwrite($configMeta, '<?php' . PHP_EOL);
		fwrite($configMeta, '$file = basename($_SERVER["PHP_SELF"]);');
		fclose($configMeta);
}
if($DYNAMIC_DIRECTORY == TRUE)
{
//-------------------------------------------------------------
//DIRECTORIOS DINAMICOS
//-------------------------------------------------------------
//el siguiente arrary debe ser modificado según las necesidades del proyecto
	
	$dynamicDirectory = array('index','contacto','servicios','nosotros');
	
	foreach($dynamicDirectory as $dd)
	{
		
		mkdir("app/controllers/".$dd, 0755);
		chmod("app/controllers/".$dd, 0755);

		touch("app/controllers/".$dd.'/'.$dd.".php", 0755);

		$controllers = fopen("app/controllers/".$dd.'/'.$dd.".php", "w");
		fwrite($controllers, "<?php" . PHP_EOL);
		fwrite($controllers, "include('app/config/meta.php');" . PHP_EOL);
		fwrite($controllers, "include('app/views/viewBase/header.php');" . PHP_EOL);
		fwrite($controllers, "include('app/config/content.php');" . PHP_EOL);
		fwrite($controllers, "include('app/views/viewBase/footer.php');" . PHP_EOL);
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
	}
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