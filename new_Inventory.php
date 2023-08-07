<!--SQL DATABASE connection-->
<?php


$mysqli = require __DIR__ . '/DBconnect.php';

$sql = 'SELECT book.*, author.author_name, category.category_name, publisher.publisher
        FROM book
        INNER JOIN author ON book.author_fk = author.author_id
        INNER JOIN category ON book.category_fk = category.category_id
        INNER JOIN publisher ON book.publisher_fk = publisher.publisher_id;';

$allproduct = $mysqli->query($sql);



?>


<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="NethuStyle.css">
    
    
    <!--fontawesome link-->
    <script src="https://kit.fontawesome.com/22142c7d49.js-" crossorigin="anonymous"></script>
    
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    
    <title>Inventory</title>
  </head>
  <body>
    <!--background-->
    <div class="adminbkback">
      <!--Navigation bar-->
      <nav class="navbar navbar-expand-lg navbar-dark py-5">
      <div class="container">
        <a class="navbar-brand" href="#">  <img src="New_logo.png" alt="Book_shop_logo" class="Book_shop_logo"></a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="Admin.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="AdminSignup.php">Sign-up</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-warning active" aria-current="page" href="#">Inventory</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="Admin_Book_Manager.php">Inventory Manager</a>
            </li>
            <li class="nav-item">
              <a class="admintxt" aria-current="page" >Hello Admin!</a>
            </li>
            </ul>
        </nav>
        <!--End of navigation-->
        <!--Create the table-->
        <div class ="whitepanel">
          <h1 class="fw-bold mb-0 text-black" style="padding-left: 40%; color: white;padding-bottom: 10px; font-weight: 800;">Nethu Book Shop</h1>
          <!--responsive the table-->
<div class="table-responsive-sm">
    <table class="table">
      
          <tr>
              <th>Title</th>
              <th>ISBN No</th>
              <th>Author</th>
              <th>Publisher</th>
              <th>Price (Rs.)</th>
              <th>Category</th>
              <th>Language</th>
              <th>Current books</th>
              <th>Issued books</th>
          </tr>
          <?php while ($row = mysqli_fetch_assoc($allproduct)) { ?>

            <tr>
                <td><?php echo $row['Book_name']; ?></td>
                <td><?php echo $row['ISBN_No']; ?></td>
                <td><?php echo $row['author_name']; ?></td>
                <td><?php echo $row['publisher']; ?></td>
                <td><?php echo $row['Book_Price']; ?></td>
                <td><?php echo $row['category_name']; ?></td>
                <td><?php echo $row['Language']; ?></td>
                <td><?php echo $row['Current_books']; ?></td>
                <td><?php echo $row['Issued_books']; ?></td>
                
                <!-- <form action="AdminUpdate2.php" method="GET">
                <button type="submit" class="btn btn-primary mr-2 mb=2">Update</button></form>
                              <form action="AdminDelete2.php" method="GET">
                <button type="submit" class="btn btn-danger">Delete</button></form> -->
              </td>
          </tr>
          <?php } ?>

          

    </table>
</div>
        </div>
        <!--footer-->
        <?php include_once 'footerAdmin.php'; ?>
        </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>