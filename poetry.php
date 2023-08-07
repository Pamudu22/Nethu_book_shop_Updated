<!DOCTYPE html>
<?php
  session_start();
  $mysqli = require __DIR__."/DBconnect.php";

  $sql = "SELECT b.Book_Name, b.ISBN_No, a.author_name 
  AS Author_Name, p.publisher AS Publisher_Name, c.category_name 
  AS Category_Name, b.Book_Price, b.Language, b.image_url, b.image_name,b.Current_books
  FROM book b
  INNER JOIN author a ON b.author_fk = a.author_id
  INNER JOIN publisher p ON b.publisher_fk = p.publisher_id
  INNER JOIN category c ON b.category_fk = c.category_id
  WHERE c.category_name = 'POETRY';";
  $allproduct = $mysqli->query($sql);

  if(isset($_POST['add_to_cart'])){
    if (!isset($_SESSION['userId'])) {
      $_SESSION['status'] = "You are not Logged in";
              $_SESSION['status_code']= "error";
              
      header("Location: Sign-in.php"); 
      exit(0);
    }
    $stock = $_POST['Current_books'];
   
    if ($stock == 0){
      $_SESSION['message'] = "Product Ran Out of Stock! ";
      header("Location:poetry.php");
      exit(0);
    

    }


    $book_name = $_POST['book_name'];
    $book_price = $_POST['book_price'];
    $quantity = 1;
    $image_url = $_POST['img_url'];
    $category = $_POST['category'];
    $userID = $_SESSION['userId'];
    $ISBN_No = $_POST['ISBN_No'];

    //sql query to check whether item is already on the shopping cart
    $check = "SELECT * FROM `shopping_cart` WHERE book_name = '$book_name' AND userID = '$userID';";
    $select_cart = mysqli_query($mysqli,$check);

    if(mysqli_num_rows($select_cart) > 0){
      $_SESSION['message'] = "Product Already added to cart! ";
      header("Location:poetry.php");
      exit(0);

    }else{
      $sqlcd = "INSERT INTO `shopping_cart` (ISBN_fk, image_url, book_name, quantity, price, category, userID) 
      VALUES ('$ISBN_No', '$image_url', '$book_name', '$quantity', '$book_price', '$category', '$userID');";

      $insert_book = $mysqli->query($sqlcd);
      $_SESSION['messg'] = "product added to cart succesfully";
      header("Location:poetry.php");
      exit(0);
    }
    
     
  }
  //wishlist
  if (isset($_POST['add_to_wishlist'])) {
    if (!isset($_SESSION['userId'])) {
        $_SESSION['status'] = "You are not Logged in";
        $_SESSION['status_code'] = "error";
        header("Location: Sign-in.php");
        exit(0);
    }

    $book_name = $_POST['book_name'];
    $book_price = $_POST['book_price'];
    $image_url = $_POST['img_url'];
    $category = $_POST['category'];
    $userID = $_SESSION['userId'];
    $ISBN_No = $_POST['ISBN_No'];

    // SQL query to check whether the item is already on the wishlist using a prepared statement
    $check = "SELECT * FROM `wishlist` WHERE book_name = ? AND userID = ?";
    $stmt_check = $mysqli->prepare($check);
    $stmt_check->bind_param("si", $book_name, $userID);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        $_SESSION['meg'] = "Product Already added to Wishlist!";
        header("Location: poetry.php");
        exit(0);
    } else {
        // SQL query with prepared statement for inserting into the wishlist table
        $sqlcd = "INSERT INTO `wishlist` (image_url, book_name, price, category, userID,ISBN_fk) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt_insert = $mysqli->prepare($sqlcd);
        $stmt_insert->bind_param("ssdsss", $image_url, $book_name, $book_price, $category, $userID,$ISBN_No);
        $stmt_insert->execute();

        $_SESSION['meg'] = "Product added to Wishlist successfully";
        header("Location: poetry.php");
        exit(0);
    }
}
  
?>


<html>
<head>
  <!-- Required meta tags -->
    
  <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="NethuStyle.css">
    <link rel="stylesheet" href="catagory.css">

    <!--fontawesome link-->
    <script src="https://kit.fontawesome.com/22142c7d49.js" crossorigin="anonymous"></script>
   

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!--Bootstraps JS-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <link href="background.css" rel="stylesheet">

  <meta http-equiv="X-UA-Campatible" content="IE-edge">
  
  <title>Book Haven - Explore a World of Stories</title>
    
    
  </head>
</head>
<body> 
  <div class="background">
    <nav class="navbar navbar-expand-lg navbar-dark py-5" style="background-color: rgba(10, 10, 102, 0.541);">
      <div class="container">
       

        <a class="navbar-brand" href="#">  <img src="New_logo.png" alt="Book_shop_logo"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="index.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-warning active" aria-current="page" href="category.php">Category</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="faq.php">Help/FAQ</a>
            </li>
            <li class="nav-item">
              <a class="nav-link " aria-current="page" href="sign-in.php">Sign-in</a>
            </li>
            <li class="nav-item">
              <a class="nav-link " aria-current="page" href="Sign-up.php">Sign-up</a>
            </li>
           <li class="nav-item">
              <a class="nav-link " aria-current="page" href="newWishlist.php">Wishlist</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="shoppingNew.php">Shopping cart</a>
            </li>
            
          </nav>
          <!--end of nav bar-->
          <?php
            include "message.php";
          ?>
          <div class="container">
          <h1 class="heading">   POETRY </h1>
          <div class="box-container">
          
          <?php 
            while($row = mysqli_fetch_assoc($allproduct)){
          ?>
  
  
              <form action="" method="post">
              <div class="box" style="height:650px;">
            <img src="<?php echo $row['image_url'] ?>" alt="<?php echo $row['image_name'] ?>">
            <h3 style="color:white;"><?php echo $row['Book_Name'] ?></h3>
            <h2 style="color:white;">Rs. <?php echo $row['Book_Price'] ?>.00</h2>
            <h4 style="color:white;"><?php echo $row['Language'] ?> medium</h4>
            <h6 style="color:thistle;"><?php echo $row['Publisher_Name'] ?></h6>
            <h6 style="color:thistle;">ISBN: <?php echo $row['ISBN_No'] ?></h6>

            <input type="hidden" name="book_name" value="<?php echo $row['Book_Name'] ?>">
            <input type="hidden" name="book_price" value="<?php echo $row['Book_Price'] ?>">
            <input type="hidden" name="img_url" value="<?php echo $row['image_url'] ?>">
            <input type="hidden" name="category" value="<?php echo $row['Category_Name'] ?>">
            <input type="hidden" name="ISBN_No" value="<?php echo $row['ISBN_No'] ?>">
            <input type="hidden" name="Current_books" value="<?php echo $row['Current_books'] ?>">

            
              <div>
              <button  class="btn" style="background-color:darkred;" type="submit"  name="add_to_wishlist"><i class="fa-solid fa-heart"></i></button> 
              <button  class="btn" type="submit"  name="add_to_cart"> Add To Cart</button>
            
              </div>
          
            
            
           
            </div>

              </form>
        
            
          
        
         

        
        <?php 
            }
          ?>
          </div>
          
             
        </div>
       
         
 
  
        <?php 
          require "Footer.php";
        ?>
         </div>
      
        
</body>
</html>
