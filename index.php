<?php

include_once 'config/dbconfig.php';

$title = 'COMP208 Foodtracker - Product Storage';
$rowIndex = 1;

session_start();

$db = new dbconfig();
$conn = $db->getConnection();

if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true) {
	$username = $_SESSION['username'];
} else {
	header('Location: login.php', TRUE, 301);
	exit();
}

// get the groceries held by the user
$usersGroceriesStmt = $conn->prepare("SELECT * FROM grocery WHERE UserID = :uid");
$usersGroceriesStmt->bindValue(':uid', $_SESSION['userID'], PDO::PARAM_INT);
$usersGroceriesStmt->execute();

?>
	
<?php include('includes/pageStart.php'); ?>

<!-- Beginning of Cards and layout -->
<div class="container-fluid" style="padding-top: 0.25%;">

	<div class="row" style="margin-left: 0.2%">
		<?php echo '<h2>' . $_SESSION['username'] . ' - Product Storage</h2>'; ?>
	</div>

	<table class="table table-bordered" style="background-color: #fff">
		<thead>
			<tr>
				<th scope="col">#</th>
				<th scope="col">Product Name</th>
				<th scope="col">Barcode</th>
				<th scope="col">Expiry Date</th>
				<th scope="col">Days Left</th>
			</tr>
		</thead>
		<tbody>
		<?php


		while ($row = $usersGroceriesStmt->fetch()) { ?>

			<tr>
				<th scope="row"><?php echo $row['GroceryNo'] ?></th>
				<td><?php echo $row['Name'] ?></td>
				<td><?php echo $row['Barcode'] ?></td>
				<td><?php echo $row['ExpiryDate'] ?></td>
				<td><?php echo (new DateTime($row['ExpiryDate']))->diff(new DateTime())->days; ?></td>
			</tr>

			<?php $rowIndex++; ?>
		<?php 
		}
		?>

		</tbody>
	</table>

</div>

<?php include('includes/pageEnd.php'); ?>