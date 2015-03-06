<?php

	require_once '../config/dbconstants.php';

	class User {
		private $id;
		private $name;
		private $type;
		private $typeName;
		
		public function __construct( $id ) {
			$this->id = $id;
			$db = new mysqli( DB_HOST, DB_USER, DB_PASS, DB_NAME );
			$query = "SELECT user_fullname, user_type FROM user WHERE user_id = ?";
			$statement = $db->prepare( $query );
			$statement->bind_param( "i", $id );
			$statement->bind_result( $this->name, $this->type );
			$statement->execute();
			$statement->store_result();
			$statement->fetch();
			
			$query = "SELECT type_name FROM user_type WHERE type_id = ?";
			$statement = $db->prepare( $query );
			$statement->bind_param( "i", $this->type );
			$statement->bind_result( $this->typeName );
			$statement->execute();
			$statement->store_result();
			$statement->fetch();
		}
		
		public function getID() {
			return $this->id;
		}
		
		public function getName() {
			return $this->name;
		}
		
		public function getTypeID() {
			return $this->type;
		}
		
		public function getTypeName() {
			return $this->typeName;
		}
	}
?>