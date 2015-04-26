<?php
function saca_dominio($url)
{
	$protocolos = array('http://', 'https://', 'ftp://', 'www.','.cl','.com','.net','.org');
	$url = explode('/', str_replace($protocolos, '', $url));
    	return $url[0];
}
$nombreProyecto=saca_dominio('verdemagenta');//reemplazar 'verdemagenta'  por $_SERVER['SERVER_NAME']
$file = basename($_SERVER["PHP_SELF"]);
if($file == 'index.php')$title = 'index';
if($file == 'index.php')$description = 'index';