<?php
	session_start();
	
	if( !isset( $_SESSION['user'] ) ) {
		header( "location:../login.php?type=103" );
	}
	
	require_once 'user.php';
	
	$users = new User( $_SESSION['user'] );
?>

<html>
	<head>
		<title>Home :: <?php echo $users->getTypeName(); ?></title>
		<link rel="stylesheet" href="../css/spacelab.min.css" type="text/css" />
		<script src="../js/jquery.js"></script>
		<script src="../js/bootstrap.min.js"></script>
		<style>
			body {
				padding-top:70px;
				padding-bottom:30px;
			}
		</style>
	</head>
	<body>
		<div class="navbar navbar-default navbar-fixed-top" role="navigation">
			<div class="container">
				<div class="navbar-header">
					<a class="navbar-brand" href="./">csdl</a>
				</div>
				<div class="navbar-collapse collapse">
					<ul class="nav navbar-nav">
						<li class="active">
							<a href="./">
								<span class="glyphicon glyphicon-home"></span>
								Home
							</a>
						</li>
						<li class="dropdown">
							<a class="dropdown-toggle" data-toggle="dropdown" href="#">
								<span class="glyphicon glyphicon-edit"></span>
								Issues
								<b class="caret"></b>
							</a>
							<ul class="dropdown-menu">
								<li><a href="issue.php?op=1">Issue Book</a></li>
								<li><a href="issue.php?op=2">Return Book</a></li>
							</ul>
						</li>
						<li class="dropdown">
							<a class="dropdown-toggle" data-toggle="dropdown" href="#">
								<span class="glyphicon glyphicon-edit"></span>
								Books
								<b class="caret"></b>
							</a>
							<ul class="dropdown-menu">
								<li><a href="books.php?op=1">Add Books</a></li>
								<li><a href="books.php?op=2">Remove Books</a></li>
							</ul>
						</li>
						<li class="dropdown">
							<a class="dropdown-toggle" data-toggle="dropdown" href="#">
								<span class="glyphicon glyphicon-edit"></span>
								Dues
								<b class="caret"></b>
							</a>
							<ul class="dropdown-menu">
								<li><a href="dues.php?op=2">Pending Fines</a></li>
							</ul>
						</li>
						<li>
							<a href="logout.php">
								<span class="glyphicon glyphicon-log-out"></span>
								Logout
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="jumbotron">
				<h1>CS Department Library <small>csdl.mitkannur.ac.in</small></h1>
			</div>
		</div>
		<div class="navbar navbar-default navbar-fixed-bottom" role="navigation">
			<div class="container">
				<div class="navbar-header">
					<a class="navbar-brand" href="./">
						<span class="glyphicon glyphicon-copyright-mark"></span> csdl
					</a>
				</div>
				<div class="navbar-collapse collapse">
					<ul class="nav navbar-nav">
						<li>
							<a href="mailto:lalluanthoor@hotmail.com">
								<span class="glyphicon glyphicon-user"></span>
								csdl.mitkannur.ac.in
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</body>
</html>
