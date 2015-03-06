<?php

$availableBooks = "SELECT book_id, book_title, book_authors, book_publisher, book_edition FROM book WHERE book_count > 0";

$busyIssues = "SELECT issue.issue_id, issue.book_id, issue.user_id FROM issue WHERE issue.issue_id NOT IN (SELECT issue_id FROM `return` AS ret)";

$busyBooks = "SELECT issue.book_id, issue.issue_id, issue.issue_date, issue.user_id FROM issue WHERE issue.issue_id NOT IN (SELECT issue_id FROM `return`) AS ret";

$booksInHand = "SELECT book_id FROM ($busyIssues) AS busy WHERE busy.user_id = ?";


$issueableBooks = "SELECT book.book_id, book.book_title, book.book_authors, book.book_publisher, book.book_edition FROM book WHERE book.book_id NOT IN ($booksInHand) AND book.book_count > 0";

$returnableBooks = "SELECT book.book_title, book.book_authors, book.book_publisher, book.book_edition, busy.issue_id FROM book, (SELECT issue.book_id, issue.issue_id, issue.user_id FROM issue WHERE issue_id NOT IN (SELECT issue_id FROM `return`)) AS busy WHERE book.book_id = busy.book_id AND busy.user_id = ?";


$finedBooks = "SELECT issue.issue_id, book.book_title, issue.lease_days, DATEDIFF(CURRENT_TIMESTAMP, issue.issue_date) FROM issue, book WHERE issue.issue_id NOT IN (SELECT issue_id FROM `return`) AND DATEDIFF(CURRENT_TIMESTAMP, issue.issue_date) > lease_days AND issue.book_id = book.book_id AND issue.user_id = ?";
?>