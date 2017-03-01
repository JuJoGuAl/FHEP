<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
define('DOMAIN_FQDN', 'fhep.org');
define('LDAP_SERVER', '192.168.0.2');
$result='';
if (isset($_POST['action'])){
	$user = strip_tags($_POST['username']) .'@'. DOMAIN_FQDN;
	$pass = stripslashes($_POST['pass']);
	$conn = ldap_connect("ldap://". LDAP_SERVER ."/");
	if (!$conn)
		echo "1"; //Could not connect to LDAP server
	else{
		define('LDAP_OPT_DIAGNOSTIC_MESSAGE', 0x0032);
		ldap_set_option($conn, LDAP_OPT_PROTOCOL_VERSION, 3);
		ldap_set_option($conn, LDAP_OPT_REFERRALS, 0);
		$bind = @ldap_bind($conn, $user, $pass);
		ldap_get_option($conn, LDAP_OPT_DIAGNOSTIC_MESSAGE, $extended_error);
		switch (ldap_errno($conn)){
			//49 Credenciales Invalidas // 0 Correcto //
			case "0":
				$username = explode('@', $user);
				include_once("../clases/class_permisos.php");
				$data = new permisos;
				$valores=$data->validar($username[0]);
				if (empty($valores)){
					$result='3';
				}else{
					session_start();
					$_SESSION['user_log']=$username[0];
					$result='1';
				}
				break;
			case "49":
				$result='2';
				break;
			default:
				$result='4';
				break;
		}
		ldap_close($conn);
		echo $result;
	}
}
?>