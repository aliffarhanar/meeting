<?php
	include_once 'autoloader.inc.php';
	usergrid_autoload('Apache\\Usergrid\\Client');
	$client = new Apache\Usergrid\Client('https://api.nobackend.id','nobackend.meeting','meeting');
	isset($_SESSION['token'])?$client->set_oauth_token($_SESSION['token']):'';
	function base_url(){
		return 'http://meetingrooms.apps.playcourt.id/';
	}
?>
