<?php

include_once 'config/dbconfig.php';

session_start();

$title = 'COMP208 Foodtracker - Sign Up';

$db = new dbconfig();
$conn = $db->getConnection();

$error = '';

// initial load
if (isset($_POST['email']) && !empty($_POST['email'])) {
	if (isset($_POST['username']) && !empty($_POST['username'])) {
		if (isset($_POST['password']) && !empty($_POST['password'])) {
			// preparing the statement and binding values
			$signupStmt = $conn->prepare("INSERT INTO user (Email, Username, Password) VALUES (:email, :user, :pwd)");

			$hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);

			$signupStmt->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
			$signupStmt->bindValue(':user', $_POST['username'], PDO::PARAM_STR);
			$signupStmt->bindValue(':pwd', $hashedPassword, PDO::PARAM_STR);
			$signupStmt->execute();

			if ($signupStmt) {
				header('Location: login.php', TRUE, 301);
				exit();
			} else {
				$error = 'User could not be created successfully.';
			}
		} else {
			$error = "Password is missing or invalid.";
		}
	} else {
		$error = "Username / Email is missing or invalid.";
	}
}

include('includes/formPageStart.php');

?>



<body>
	
	<!-- Login Page below here -->
	<div class="back">
		<div class="div-center">
			<div class="content">

				<h3>Sign up for an account!</h3>
				<hr />
				<form action="/register.php" method="post">

					<div class="form-group">
						<label for="email">Account Email</label>
						<input name="email" type="email" class="form-control" id="email" placeholder="Enter email here">
					</div>

					<div class="form-group">
						<label for="username">Account Username</label>
						<input name="username" type="text" class="form-control" id="username" placeholder="Enter username here">
					</div>

					<div class="form-group">
						<label for="password">Account Password</label>
						<input name="password" type="password" class="form-control" id="password" placeholder="Enter password here">
					</div>

					<button type="submit" class="btn btn-primary btn-block">Sign Up</button>

					<small id="error" class="text-danger"><?php echo $error ?></small>      

				</form>

			</div>
		</div>
	</div>

<?php include('../includes/pageEnd.php');