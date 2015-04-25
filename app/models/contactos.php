<?php
include('app/config/database.php');
$link = conexion();
$folder;

function queryOneDataExistcontactos($tuple,$value,$result)
{
	 global $link;
 	 global $folder;
    $query  = " SELECT $result FROM $folder WHERE {$tuple} = '{$value}' ";
	 $data   = mysqli_query($link, $query);
    if(mysqli_num_rows($data) !== 0);
    {
     	 $row = mysqli_fetch_assoc($data);
     	 $res = $row[$result];

     	 return $res;
    }
    else
    {
     	 return FALSE;
    }
}
