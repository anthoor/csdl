<?php 
	session_start();
	if( !isset( $_GET['user'] ) ) {
		header( "location:login.php?user=101" );
	} else {
		$usertype = $_GET[ 'user' ];
	}
?>
<html>
<head>
<title>Login</title>
<link rel="stylesheet" href="css/spacelab.min.css" type="text/css" />
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<style>
body {
	padding-top: 70px;
	padding-bottom: 30px;
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
					<li><a href="./"> <span class="glyphicon glyphicon-home"></span>
							Home
					</a></li>
					<li class="dropdown active"><a class="dropdown-toggle"
						data-toggle="dropdown" href="#"> <span
							class="glyphicon glyphicon-edit"></span> Login <b class="caret"></b>
					</a>
						<ul class="dropdown-menu">
							<li><a href="login.php?user=101">Librarian</a></li>
							<li><a href="login.php?user=102">Staff</a></li>
							<li><a href="login.php?user=104">Student</a></li>
							<li><a href="login.php?user=103">Guest</a></li>
						</ul></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-md-4"></div>
			<div class="col-md-4">
				<div class="jumbotron">
					<form role="form" action="auth.php" method="post">
						<div class="form-group">
							<label for="username">Username</label> <input type="text"
								name="username" id="username" class="form-control"
								placeholder="Username" />
						</div>
						<div class="form-group">
							<label for="passwd">Password</label> <input type="password"
								name="passwd" id="passwd" class="form-control"
								placeholder="Password" />
						</div>
						<input type="hidden" name="usertype" value="<?php echo $usertype; ?>" />
						<button class="btn btn-success" style="width: 100%;">Login</button>
					</form>
				</div>
			</div>
			<div class="col-md-4"></div>
		</div>
	</div>
	<div class="navbar navbar-default navbar-fixed-bottom"
		role="navigation">
		<div class="container">
			<div class="navbar-header">
				<a class="navbar-brand" href="./"> <span
					class="glyphicon glyphicon-copyright-mark"></span> csdl
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
