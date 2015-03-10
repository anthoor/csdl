<?php
	session_start();
	
	if( !isset( $_SESSION['user'] ) ) {
		header( "location:../login.php?user=101" );
	} else if ( isset( $_GET['op'] ) ) {
		$oper = $_GET['op'];
	} else {
		header( "location:issue.php?op=1" );
	}
	
	require_once 'user.php';
	require_once 'controller.php';
	
	$users = new User( $_SESSION['user'] );
?>

<html>
	<head>
		<title>Books :: <?php echo $users->getTypeName(); ?></title>
		<link rel="stylesheet" href="../css/spacelab.min.css" type="text/css" />
		<script src="../js/jquery.js"></script>
		<script src="../js/bootstrap.min.js"></script>
		<script>
			function dconfirm() {
				var book = document.getElementById('book');
				var text = book.options[book.selectedIndex].text;
				return confirm("Are you sure you want to delete " + document.getElementById('copies').value + " copies of \"" + text + "\"?");
			}
		</script>
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
						<li>
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
						<li class="dropdown active">
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
<?php
	if( $oper == 1 ) {
?>
				<center>
					<h3>Add Books</h3>
				</center>
				<form action="addbook.php" method="POST" class="form-horizontal">
					<div class="form-group">
						<label for="title" class="col-sm-2 control-label">Book Title</label>
						<div class="col-sm-10">
							<input type="text" name="title" class="form-control" placeholder="Book Title" autofocus />
						</div>
					</div>
					<div class="form-group">
						<label for="author" class="col-sm-2 control-label">Book Authors</label>
						<div class="col-sm-10">
							<input type="text" name="author" class="form-control" placeholder="Book Authors" />
						</div>
					</div>
					<div class="form-group">
						<label for="publisher" class="col-sm-2 control-label">Book Publisher</label>
						<div class="col-sm-10">
							<input type="text" name="publisher" class="form-control" placeholder="Book Publisher" />
						</div>
					</div>
					<div class="form-group">
						<label for="edition" class="col-sm-2 control-label">Book Edition</label>
						<div class="col-sm-10">
							<input type="number" name="edition" class="form-control" placeholder="Book Edition" />
						</div>
					</div>
					<div class="form-group">
						<label for="count" class="col-sm-2 control-label">Book Count</label>
						<div class="col-sm-10">
							<input type="number" name="count" class="form-control" placeholder="Book Count" />
						</div>
					</div>
					<input type="hidden" name="op" value="<?php echo $oper; ?>" />
					<div class="form-group" align="center">
						<button class="btn btn-success">Add Books</button>
					</div>
				</form>
<?php
	} else if( $oper == 2 ) {
?>
				<center>
					<h3>Remove Book</h3>
				</center>
				<form action="addbook.php" method="POST" class="form-horizontal" onsubmit="dconfirm();">
					<div class="form-group">
						<label for="title" class="col-sm-2 control-label">Book Title</label>
						<div class="col-sm-10">
							<select name="book" class="form-control" id="book">
								<?php echo loadBooks(); ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="author" class="col-sm-2 control-label">No of Copies</label>
						<div class="col-sm-10">
							<input type="text" name="count" id="copies" class="form-control" placeholder="Book Copies" />
						</div>
					</div>
					<input type="hidden" name="op" value="<?php echo $oper; ?>" />
					<div class="form-group" align="center">
						<button class="btn btn-danger">Remove Book</button>
					</div>
				</form>
<?php
	}
?>
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
