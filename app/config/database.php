<?php
function conexion()
{
	 $server   = "localhost"; 
	 $username = "usuario"; 
	 $password = "clave"; 
	 $database = "base de datos"; 
	 $link     = mysqli_connect($server, $username, $password, $database);
	 mysqli_set_charset($link,"utf8");
	 return($link);
	 mysqli_close($link);
}