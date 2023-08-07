<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST)) {
  http_response_code(400);
  exit("Bad Request");
}

session_start();
$mysqli = require __DIR__ . "/DBconnect.php";

if (!isset($_SESSION['userId'])) {
  http_response_code(401);
  exit("You are not Logged in");
}

$userID = $_SESSION['userId'];
$scartID = $_POST['scartID'];
$quantity = $_POST['quantity'];
$totalPrice = $_POST['totalPrice']; 
$_SESSION['totalPrice'] = $totalPrice;

$sql = "UPDATE `shopping_cart` SET quantity = ?, tot_price = ? WHERE userID = ? AND ScartID = ?";
$stmt = $mysqli->prepare($sql);

if ($stmt === false) {
  http_response_code(500);
  echo "Error preparing the database query.";
  exit();
}

$stmt->bind_param("ddii", $quantity, $totalPrice, $userID, $scartID);

if ($stmt->execute()) {
  echo "Quantity and price updated successfully!";
} else {
  http_response_code(500);
  echo "Error updating quantity and price in the database.";
}

$stmt->close();
$mysqli->close();
?>
