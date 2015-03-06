<?php

require_once '../config/dbconstants.php';
require_once 'queries.php';

class Dues {
	public static function getOverdueBooks( $userID ) {
		$dueBooks = "SELECT issue_id, DATEDIFF(issue_date, CURRENT_TIMESTAMP())  FROM 
			(SELECT issue.book_id, issue.issue_id, issue.issue_date, issue.user_id,issue.lease_days FROM issue WHERE issue.issue_id NOT IN 
			(SELECT issue_id FROM `return` AS ret)) AS something WHERE DATEDIFF(issue_date, CURRENT_TIMESTAMP()) > lease_days AND user_id = ?";
		$db = new mysqli( DB_HOST, DB_USER, DB_PASS, DB_NAME );
		$statement = $db->prepare( $dueBooks );
		$statement->bind_param( "i", $userID );
		$statement->bind_result( $issueID, $diffdays );
		$statement->execute();
		$statement->store_result();

		$array = NULL;

		if( $statement->num_rows > 0 ) {
			while( $statement->fetch() ) {
				$array[$issueID] = $diffdays;
			}
		}

		return $array;
	}

	public static function getDuesForIssue( $issueID ) {
		$db = new mysqli( DB_HOST, DB_USER, DB_PASS, DB_NAME );
		$query = "SELECT DATEDIFF( CURRENT_TIMESTAMP(), issue_date ) - lease_days FROM issue WHERE issue_id = ?";
		$statement = $db->prepare( $query );
		$statement->bind_param( "i", $issueID );
		$statement->bind_result( $diffdays );
		$statement->execute();
		$statement->store_result();
		$statement->fetch();
		$fine = 0;
		if( $diffdays > 0 ) {
			$fine = Dues::calculateAmount( $diffdays );
		}
		return $fine;
	}

	public static function calculateAmount( $days ) {
		$fineFactor = 1;
		$fine = 0;
		while( $days > 7 ) {
			$sub = 7 * $fineFactor;
			$days = $days - 7;
			$fineFactor = $fineFactor * 2;
			$fine = $fine + $sub;
		}
		$fine = $fine + $days * $fineFactor;
		return $fine;
	}
}
?>