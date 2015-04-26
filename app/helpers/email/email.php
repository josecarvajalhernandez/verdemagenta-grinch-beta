<?php
function contactMe($message, $email)
{
		$to = "exampl@email.com";
		$subject = "title message";
		$txt = $message;
		$headers = "From: ".$email. "\r\n";
		$headers .= "Cc: example1@email.cl,example2@email.cl";
		mail($to,$subject,$txt,$headers);
}
