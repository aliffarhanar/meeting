<?php

	   
function auth($PHP_AUTH_USER1,$PHP_AUTH_PW1){

 $auth=0;
 global $nama;
 $ldapconfig['host'] = 'merahputih.telkom.co.id';
 //$ldapconfig['host'] = '10.0.32.230';
 $ldapconfig['authrealm'] = 'User Intranet Telkom ND';
 if ($PHP_AUTH_USER1 != "" && $PHP_AUTH_PW1 != "") {
			$ds=@ldap_connect($ldapconfig['host']);
			$r = @ldap_search( $ds, " ", 'uid=' . $PHP_AUTH_USER1);
			if ($r) {
					$result = @ldap_get_entries( $ds, $r);
					if (isset($result[0])) {
							if (@ldap_bind( $ds, $result[0]['dn'], $PHP_AUTH_PW1) ) {
									$auth=1;
							}
					}
			}
	}
 return $auth; 
}

function info($PHP_AUTH_USER1){

 $auth=0;
 global $nama;
 $ldapconfig['host'] = 'merahputih.telkom.co.id';
 //$ldapconfig['host'] = '10.0.32.230';
 $ldapconfig['authrealm'] = 'User Intranet Telkom ND';
 if ($PHP_AUTH_USER1) {
			$ds= ldap_connect($ldapconfig['host'])or die("Could not connect to {$ldapconfig['host']}");;
			$r = ldap_search( $ds, " ", 'uid=' . $PHP_AUTH_USER1)or die ("Error in search
        query");
			if ($r) {
				$result = ldap_get_entries( $ds, $r);
				return $result;
			}
		return false;
	}
}

if (isset($_GET['test'])) echo info($_GET['test'];


?>

