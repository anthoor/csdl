<?php

require_once 'queries.php';
require_once '../config/dbconstants.php';
require_once 'getdues.php';

$operation = $_GET['op'];

if( $operation == "loadReturnableBooks" ) {
	$userid = $_GET['user'];
	$db = new mysqli( DB_HOST, DB_USER, DB_PASS, DB_NAME );
	$statement = $db->prepare( $returnableBooks );
	$statement->bind_param( "i", $userid );
	$statement->bind_result( $book_title, $book_authors, $book_publisher, $book_edition, $issue_id );
	$statement->execute();
	$statement->store_result();
	$result = "";
	while( $statement->fetch() ) {
		if( Dues::getDuesForIssue( $issue_id ) == 0 ) {
			$result .= "<<<$issue_id##$book_title##$book_edition##$book_authors##$book_publisher";
		}
	}
	$result = substr( $result, 3 );
	echo $result;
} else if( $operation == "loadIssueableBooks" ) {
	$userid = $_GET['user'];
	$db = new mysqli( DB_HOST, DB_USER, DB_PASS, DB_NAME );
	$statement = $db->prepare( $issueableBooks );
	$statement->bind_param( "i", $userid );
	$statement->bind_result( $book_id, $book_title, $book_authors, $book_publisher, $book_edition );
	$statement->execute();
	$statement->store_result();
	$result = "";
	while( $statement->fetch() ) {
		$result .= "<<<$book_id##$book_title##$book_edition##$book_authors##$book_publisher";
	}
	$result = substr( $result, 3 );
	echo $result;
} else if( $operation == "loadFinedBooks" ) {
	$userid = $_GET['user'];
	$db = new mysqli( DB_HOST, DB_USER, DB_PASS, DB_NAME );
	$statement = $db->prepare( $finedBooks );
	$statement->bind_param( "i", $userid );
	$statement->bind_result( $issue_id, $book_id, $lease_days, $diffdays );
	$statement->execute();
	$statement->store_result();
	$result = "";
	while( $statement->fetch() ) {
		$amount = Dues::getDuesForIssue( $issue_id );
		$result .= "<<<$book_id##$issue_id##$lease_days##$diffdays##$amount";
	}
	$result = substr( $result, 3 );
	echo $result;
}

?>