<?php
	session_start();
?>
<html>
	<head>
		<title>Home</title>
		<link rel="stylesheet" href="css/spacelab.min.css" type="text/css" />
		<script src="js/jquery.js"></script>
		<script src="js/bootstrap.min.js"></script>
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
								Login
								<b class="caret"></b>
							</a>
							<ul class="dropdown-menu">
								<li><a href="login.php?user=101">Librarian</a></li>
								<li><a href="login.php?user=102">Staff</a></li>
                                <li><a href="login.php?user=104">Student</a></li>
								<li><a href="login.php?user=103">Guest</a></li>
							</ul>
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
