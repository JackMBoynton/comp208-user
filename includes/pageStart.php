<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo $title; ?></title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">

  <a class="navbar-brand" href="index.php">Expiration Tracker - Admin Backend</a>

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
    </ul>

	<?php
	if ($_SESSION['loggedIn']) {
		echo '
			<form class="form-inline my-2 my-lg-0" action="logout.php">
				<button class="btn btn-danger my-2 my-sm-0" type="submit">Logout</button>
			</form>
		';
	} else {
		echo '
			<form class="form-inline my-2 my-lg-0" action="login.php">
      			<button class="btn btn-success my-2 my-sm-0" type="submit">Login</button>
    		</form>
		';
	}
	?>

  </div>

</nav>