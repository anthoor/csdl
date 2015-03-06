<?php

session_start();

require_once '../config/dbconstants.php';
require_once 'user.php';
require_once 'getdues.php';

class Issue {
	
	public static function issueBook( $bookID, $userID ) {
		$user = new User( $userID );
		
		$leasedays = 0;
		switch( $user->getTypeID() ) {
			case 101:
			case 102:
				$leasedays = 30;
				break;
			case 104:
				$leasedays = 14;
				break;
		}
		
		$db = new mysqli( DB_HOST, DB_USER, DB_PASS, DB_NAME );
		$query = "INSERT INTO issue( user_id, book_id, lease_days ) VALUES ( ?, ?, ? )";
		$statement = $db->prepare( $query );
		$statement->bind_param( "iii", $userID, $bookID, $leasedays );
		$statement->execute();
		
		$query = "UPDATE book SET book_count = book_count - 1 WHERE book_id = ?";
		$statement = $db->prepare( $query );
		$statement->bind_param( "i", $bookID );
		$statement->execute();
	}
	
	public static function returnBook( $issueID ) {
		$db = new mysqli( DB_HOST, DB_USER, DB_PASS, DB_NAME );
		$query = "INSERT INTO `return` ( issue_id ) VALUES ( ? )";
		$statement = $db->prepare( $query );
		$statement->bind_param( "i", $issueID );
		$statement->execute();
		
		$query = "SELECT book_id FROM issue WHERE issue_id = ?";
		$statement = $db->prepare( $query );
		$statement->bind_param( "i", $issueID );
		$statement->bind_result( $bookID );
		$statement->execute();
		$statement->store_result();
		$statement->fetch();
		
		$query = "UPDATE book SET book_count = book_count + 1 WHERE book_id = ?";
		$statement = $db->prepare( $query );
		$statement->bind_param( "i", $bookID );
		$statement->execute();

		$fined = Dues::getDuesForIssue( $issueID );
		if( $fined > 0 ) {
			$query = "INSERT INTO fine ( issue_id, fine_amount ) VALUES ( ?, ? )";
			$statement = $db->prepare( $query );
			$statement->bind_param( "ii", $issueID, $fined );
			$statement->execute();
		}
	}
}

switch( $_POST['op'] ) {
	case 1:
		Issue::issueBook( $_POST['book'], $_POST['user'] );
		header( "location:issue.php?op=1" );
		break;
	case 2:
		foreach( $_POST['book'] as $book ) {
			Issue::returnBook( $book );
		}
		header( "location:issue.php?op=2" );
		break;
}

?>