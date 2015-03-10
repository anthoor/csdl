<?php
	session_start();
	require_once '../config/dbconstants.php';
	
	class Book {
		private $db;
		
		function __construct() {
			$this->db = new mysqli( DB_HOST, DB_USER, DB_PASS, DB_NAME );
		}
		
		public function addBooks( $title, $authors, $publisher, $edition, $count ) {
			$query = "INSERT INTO book (book_title, book_authors, book_publisher, book_edition, book_count) VALUES (?, ?, ?, ?, ?)";
			$statement = $this->db->prepare( $query );
			$statement->bind_param( "sssii", $title, $authors, $publisher, $edition, $count );
			$statement->execute();
		}
		
		public function removeBooks( $bookID, $count ) {
			$query = "SELECT book_count FROM book WHERE book_id = ?";
			$statement = $this->db->prepare( $query );
			$statement->bind_param( "i", $bookID );
			$statement->bind_result( $oldcount );
			$statement->execute();
			$statement->store_result();
			$statement->fetch();
			
			if( $oldcount == $count ) {
				$query = "DELETE FROM book WHERE book_id = ?";
				$statement = $this->db->prepare( $query );
				$statement->bind_param( "i", $bookID );
			} else {
				$query = "UPDATE book SET book_count = ? WHERE book_id = ?";
				$statement = $this->db->prepare( $query );
				$statement->bind_param( "ii", $count, $bookID );
			}
			$statement->execute();
		}
	}
	
	if( isset( $_POST ) ) {
		$book = new Book();
		if( $_POST['op'] == 1 ) {
			$book->addBooks( $_POST['title'], $_POST['author'], $_POST['publisher'], $_POST['edition'], $_POST['count'] );
			header( "location:books.php?op=1" );
		} else if( $_POST['op'] == 2 ) {
			$book->removeBooks( $_POST['book'], $_POST['count'] );
			header( "location:books.php?op=2" );
		}
	}
?>