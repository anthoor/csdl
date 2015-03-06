<?php

require_once '../config/dbconstants.php';
//Controller for all pages. Write functions here.

function loadUsers() {
	$query = "SELECT user.user_id, user.user_fullname, user_type.type_name FROM user, user_type WHERE user.user_type = user_type.type_id";
	$db = new mysqli( DB_HOST, DB_USER, DB_PASS, DB_NAME );
	$statement = $db->prepare( $query );
	$statement->bind_result( $id, $name, $type );
	$statement->execute();
	$statement->store_result();
	$result = "";
	while( $statement->fetch() ) {
		$result .= "<option value=\"$id\">$name [$type]</option>\n";
	}
	return $result;
}

?>