<?php
$file = basename($_SERVER["PHP_SELF"]);
$folder = str_replace(".php", "", $file);
include('app/models/'.$file);