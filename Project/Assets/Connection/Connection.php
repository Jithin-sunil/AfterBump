<?php
$Server="localhost";
$User="root";
$Password="";
$Db="db_afterbump";
$Con=mysqli_connect($Server,$User,$Password,$Db);
if(!$Con)
{
		echo"Connection Error";
}
?>