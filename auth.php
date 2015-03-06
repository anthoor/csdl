<?php
session_start();

require_once 'config/dbconstants.php';

class Auth {
	
	private $db;
	
	function __construct() {
		$this->db = new mysqli ( DB_HOST, DB_USER, DB_PASS, DB_NAME );
	}
	
	function authenticate( $user, $pass, $type ) {
		$query = "SELECT user_id, user_password, user_type FROM user WHERE user_name = ?";
		$statement = $this->db->prepare($query);
		$statement->bind_param("s", $user);
		$statement->bind_result( $userid, $userpass, $usertype );
		$statement->execute();
		$statement->store_result();
		$statement->fetch();

		if( $statement->num_rows != 1 ) {
			$_SESSION['error'] = "Invalid Username and/or Password.";
			header( "location:login.php?user="+$type );
		} else {
			if( $userpass != md5($pass) ) {
				$_SESSION['error'] = "Invalid Username and/or Password.";
				header( "location:login.php?user="+$type );
			} else {
				if( $type != $usertype ) {
					$_SESSION['error'] = "Invalid Username and/or Password.";
					header( "location:login.php?user="+$type );
				} else {
					$_SESSION['user'] = $userid;
					$_SESSION['type'] = $type;
					header( "location:users/" );
				}
			}
		}
	}
}

$auth = new Auth();
$auth->authenticate( $_POST['username'], $_POST['passwd'], $_POST['usertype'] );

?>