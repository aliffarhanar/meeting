<?php
	include_once 'autoloader.inc.php';
	usergrid_autoload('Apache\\Usergrid\\Client');
	$client = new Apache\Usergrid\Client('https://api.nobackend.id','tbaas.rapatin','meeting');
	
?>