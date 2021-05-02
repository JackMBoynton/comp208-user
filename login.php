<?php

include_once 'config/dbconfig.php';

$title = 'COMP208 Foodtracker - User Login';

session_start();

$db = new dbconfig();
$conn = $db->getConnection();

$error = '';

// if isset $_SESSION['loggedIn'] and it also equals true, redirect to index.php else, see comment below
if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true) {
	header('Location: index.php', TRUE, 301);
	exit();
} else {

	$emailStmt = $conn->prepare("SELECT * FROM user WHERE Email = :email");
	$usernameStmt = $conn->prepare("SELECT * FROM user WHERE Username = :username");

	//  if isset post values, then we need to match them with a user in the db, if not, output an error and display the form again
	if (isset($_POST['identifier']) && !empty($_POST['identifier'])) {

		// we know identifier isn't empty, therefore, check if it is email or password
		if (filter_var($_POST['identifier'], FILTER_VALIDATE_EMAIL)) {
			$emailStmt->bindValue(':email', $_POST['identifier']);
			$emailStmt->execute();
		} else {
			$usernameStmt->bindValue(':username', $_POST['identifier']);
			$usernameStmt->execute();
		}

		// we have executed the statement above, so now we need to get the count of users and the row of the user
		if (filter_var($_POST['identifier'], FILTER_VALIDATE_EMAIL)) {
			$count = $emailStmt->rowCount();
			$row = $emailStmt->fetch();
		} else {
			$count = $usernameStmt->rowCount();
			$row = $usernameStmt->fetch();
		}

		// if we actually have a user
		if ($count > 0) {

			// extract it
			extract($row);

			if (password_verify($_POST['password'], $Password)) {

				$_SESSION['loggedIn'] = true;
				$_SESSION['username'] = $Username;
				$_SESSION['userID'] = $UserID;

				header('Location: index.php', TRUE, 301);
				exit();

			} else {
				$error = 'Password invalid or not supplied.';
			}
		} else {
			$error = 'User does not exist';
		}

	}

}

include('includes/formPageStart.php');

?>



<body>
	
	<!-- Login Page below here -->
	<div class="back">


  <div class="div-center">
		<div class="content">

			<h3>User Login</h3>
			<hr />
			<form action="/login.php" method="post">

				<div class="form-group">
					<label for="identifier">Email Address / Username</label>
					<input name="identifier" type="text" class="form-control" id="identifier" placeholder="Enter email or username">
				</div>

				<div class="form-group">
					<label for="password">Password</label>
					<input name="password" type="password" class="form-control" id="password" placeholder="Enter password">
				</div>

				<button type="submit" class="btn btn-primary btn-block">Login</button>

				<span>Not got an account? <a href="register.php">Sign up here!</a></span>

				<small id="error" class="text-danger"><?php echo $error ?></small>      

			</form>

		</div>
	</div>

<?php include('includes/pageEnd.php');