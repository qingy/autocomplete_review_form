<?php

//Log into the server
@ $db = mysql_pconnect('[HOST]', '[DATABASE USER]', '[DATABASE PASSWORD]');

//Select the database desired
mysql_select_db('[DATABASE NAME]');

//If no connection can be made, echo it out to the screen
if(!$db){
	echo "Error: Could not connect to the database. Please try again later.";
	exit;
}

?>