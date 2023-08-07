<?php
session_start();
require_once "DBconnect.php";

$Name = mysqli_real_escape_string($mysqli, $_POST['name']);
$email = mysqli_real_escape_string($mysqli, $_POST['email']);
$mobN = mysqli_real_escape_string($mysqli, $_POST['contact']);
$Address = mysqli_real_escape_string($mysqli, $_POST['Address']);

$userID = $_SESSION['userId'];

$sqlSum = "SELECT SUM(`tot_price`) AS total_price FROM `shopping_cart` WHERE `userID` = ?";
$stmtSum = $mysqli->prepare($sqlSum);
$stmtSum->bind_param("i", $userID);
$stmtSum->execute();
$resultSum = $stmtSum->get_result();
$totalPriceRow = $resultSum->fetch_assoc();
$totalPrice = $totalPriceRow['total_price'];

// Insert order details into the order_detail table
$sqlInsert = "INSERT INTO `order_detail` (`userName`, `email`, `contactNum`, `Total_price`, `userID`) VALUES (?, ?, ?, ?, ?)";
$stmtInsert = $mysqli->prepare($sqlInsert);
$stmtInsert->bind_param("ssiii", $Name, $email, $mobN, $totalPrice, $userID);

$stmtInsert->execute();
$orderID = $stmtInsert->insert_id;

$sql = "SELECT sc.*, b.Language FROM `shopping_cart` sc
        JOIN `book` b ON sc.ISBN_fk = b.ISBN_No
        WHERE sc.userID = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $userID);
$stmt->execute();
$allproduct = $stmt->get_result();

$to = "nethubookshop.lk@gmail.com";
$subjct = "Order Detail";

// Start building the message using a variable
$message = "
<html>
    <head>
        <style>
        th{
            background-color:gray;
            padding:2%;
            width:25%
        }
        tr{
            padding:3%;
            background-color :lightgreen;

        }
        </style>
        <title>Order Detail</title>
    </head>
    <body>
        <p>Detail of the Customer</p>
        
                <h4><b>Order Number:</b> $orderID  <br></h4>
                <h4><b>Customer Name:</b> $Name <br></h4> 
                <h4><b>Customer Email:</b>  $email <br></h4>
                <h4><b>Address:</b>  $Address <br></h4>
                <h4><b>Contact Information:</b>  $mobN <br></h4>
                
         
        
        <br>
        <table>
            <tr>
                <th>Book category</th>
                <th>Book Name</th>
                <th>Language</th>
                <th>Quantity</th>
            </tr>";
            
// Loop through the products and append them to the message
while ($row = mysqli_fetch_assoc($allproduct)) {
    $message .= "
            <tr>
                <td>".$row['category']."</td>
                <td>".$row['book_name']."</td>
                <td>".$row['Language']."</td>
                <td>".$row['quantity']."</td>
            </tr>";
}

// Finish building the message
$message .= "
        </table>
    </body>
</html>";

$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= "From: <nethubookshop.lk@gmail.com>" . "\r\n";

$shoppingCartQuery = "SELECT ISBN_fk, SUM(quantity) AS total_quantity
                      FROM shopping_cart
                      WHERE userID = ? 
                      GROUP BY ISBN_fk";

// Assuming you have the user ID available (replace USER_ID with the actual user ID)


if ($stmt = $mysqli->prepare($shoppingCartQuery)) {
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $result = $stmt->get_result();
    $cartDetails = array();
    while ($row = $result->fetch_assoc()) {
        $cartDetails[$row['ISBN_fk']] = $row['total_quantity'];
    }
    $stmt->close();
}

// Update the current books value in the book table
if (!empty($cartDetails)) {
    $updateBookQuery = "UPDATE book
                        SET Current_books = Current_books - ?
                        WHERE ISBN_No = ?";

    foreach ($cartDetails as $ISBN => $quantity) {
        if ($stmt = $mysqli->prepare($updateBookQuery)) {
            $stmt->bind_param("is", $quantity, $ISBN);
            $stmt->execute();
            $stmt->close();
        }
    }
}



if (mail($to, $subjct, $message, $headers)) {
    // Delete shopping cart items after sending the email
    $sqlD = "DELETE FROM `shopping_cart` WHERE userID = $userID;";
    $mysqli->query($sqlD);

    $_SESSION['order']  = $orderID;
    $_SESSION['value']  = $totalPrice;
    $_SESSION['email']  = $email;
    $_SESSION['phone']  = $mobN;
    $_SESSION['name']   = $Name;
    header("Location:index.php");
    exit(0);
}
?>
