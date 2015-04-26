<?php
function textFieldOk($textField)
{
	if($textField == "")
	{?>
		<script>
			alert('debes completar todos los campos de texto');
			self.location = "contacts.php";
		</script><?php
	}
	else
	{
		return TRUE;
	}
}

function clear($data) 
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

function ValidateEmail($email)
{
	if (filter_var($email, FILTER_VALIDATE_EMAIL)) 
	{
		return TRUE;
	}
	else
	{?>
		<script>
			alert('debes ingresar un email Valido');
			self.location = "contacts.php";
		</script><?php 
	}
}
