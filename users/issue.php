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
		<title>Issue :: <?php echo $users->getTypeName(); ?></title>
		<link rel="stylesheet" href="../css/spacelab.min.css" type="text/css" />
		<script src="../js/jquery.js"></script>
		<script src="../js/bootstrap.min.js"></script>
		<style>
			body {
				padding-top:70px;
				padding-bottom:30px;
			}
		</style>
		
		<script>
			function loadIssueableBooks() {
				var xmlhttp;
				if (window.XMLHttpRequest) {
					xmlhttp=new XMLHttpRequest();
				} else {
					xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
				}
				
				xmlhttp.onreadystatechange=function() {
					if( xmlhttp.readyState == 4 && xmlhttp.status == 200 ) {
						document.getElementById('book-group').innerHTML = "";
						var response = xmlhttp.responseText;
						if( response != null && response != '' ) {
							var rows = response.split("<<<");
							var print = "<div class=\"form-group\">\n<label for=\"book\">Books</label>\n<select name=\"book\" class=\"form-control\">";
							for( i in rows ) {
								var cols = rows[i].split("##");
								print += "<option value=\"" + cols[0] + "\">" + cols[1] + " - " + cols[3] + " [ " + cols[4] + ", Ed. " + cols[2] + " ]</option>";
							}
							print += "</select>\n</div>";
							document.getElementById('book-group').innerHTML = print;
						}
					}
				}
				var select = document.getElementById('user');
				var URL = "ajax.php?op=loadIssueableBooks&user="+select.options[select.selectedIndex].value;
				xmlhttp.open( "GET", URL, true );
				xmlhttp.send();
			}
			
			function loadReturnableBooks() {
				var xmlhttp;
				if (window.XMLHttpRequest) {
					xmlhttp=new XMLHttpRequest();
				} else {
					xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
				}
				
				xmlhttp.onreadystatechange=function() {
					if( xmlhttp.readyState == 4 && xmlhttp.status == 200 ) {
						document.getElementById('book-group').innerHTML = "";
						var response = xmlhttp.responseText;
						if( response != null && response != '' ) {
							var rows = response.split("<<<");
							var print = "<div class=\"form-group\">\n<label for=\"book\">Books</label>\n<select name=\"book[]\" class=\"form-control\">\n<option value=\"=-1\">Select Book</option>";
							for( i in rows ) {
								var cols = rows[i].split("##");
								print += "<option value=\"" + cols[0] + "\">" + cols[1] + " - " + cols[3] + " [ " + cols[4] + ", Ed. " + cols[2] + " ]</option>";
							}
							print += "</select>\n</div>";
							document.getElementById('book-group').innerHTML = print;
						}
					}
				}
				var select = document.getElementById('user');
				var URL = "ajax.php?op=loadReturnableBooks&user="+select.options[select.selectedIndex].value;
				xmlhttp.open( "GET", URL, true );
				xmlhttp.send();
			}
		</script>
		
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
						<li class="dropdown active">
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
<?php
	if( $oper == 1 ) {
?>
				<center>
					<h3>Issue Books</h3>
				</center>
				<form action="issuebook.php" method="POST">
					<div class="form-group" id="user-group">
						<label for="user">User</label>
						<select name="user" id="user" class="form-control" onchange="loadIssueableBooks();">
							<option value="-1">Select User</option>
							<?php echo loadUsers(); ?>
						</select>
					</div>
					<div class="form-group" id="book-group">
					</div>
					<input type="hidden" name="op" value="<?php echo $oper; ?>" />
					<div class="form-group" align="center">
						<button class="btn btn-success">Issue Book</button>
					</div>
				</form>
<?php
	} else if( $oper == 2 ) {
?>
				<center>
					<h3>Return Books</h3>
				</center>
				<form action="issuebook.php" method="POST">
					<div class="form-group" id="user-group">
						<label for="user">User</label>
						<select name="user" id="user" class="form-control" onchange="loadReturnableBooks();">
							<option value="-1">Select User</option>
							<?php echo loadUsers(); ?>
						</select>
					</div>
					<div class="form-group" id="book-group">
					</div>
					<input type="hidden" name="op" value="<?php echo $oper; ?>" />
					<div class="form-group" align="center">
						<button class="btn btn-info">Return Book</button>
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
