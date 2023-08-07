<!--SQL DATABASE connection-->
<?php
  include_once "DBconnect.php";
  session_start();

  if (!isset($_SESSION['userId'])) {
    $_SESSION['status'] = "You are not Logged in";
            $_SESSION['status_code']= "error";
            
    header("Location: Sign-in.php"); 
    exit(0);
    
  }
  $userID = $_SESSION['userId'];

  $sql = "SELECT * FROM `wishlist` WHERE userID = ?";
  $stmt = $mysqli->prepare($sql);
  $stmt->bind_param("i", $userID);
  $stmt->execute();
  $allproduct = $stmt->get_result();



   
  

  if(isset($_POST['deletebutton'])){
    $deleteItem = $_POST['delete'];

    $sql = "DELETE FROM `wishlist` WHERE book_name = ?";
      $stmt = $mysqli->prepare($sql);
      $stmt->bind_param("s", $deleteItem);
      
    if($result = $stmt->execute()){
      $_SESSION['messg'] = "product Removed From Wishlist succesfully";
      header("Location:newWishlist.php");
      exit(0);
    }

  }
  if (isset($_POST['add_to_cart'])) {
    $book_name = $_POST['book_name'];
    $book_price = $_POST['book_price'];
    $quantity = 1;
    $image_url = $_POST['img_url'];
    $category = $_POST['category'];
    $userID = $_SESSION['userId'];
    $ISBN_No = $_POST['ISBN_No'];

    // SQL query to check whether the item is already in the shopping cart
    $check = "SELECT * FROM `shopping_cart` WHERE book_name = ? AND userID = ?";
    $stmt_check = $mysqli->prepare($check);
    $stmt_check->bind_param("si", $book_name, $userID);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        $_SESSION['message'] = "Product Already added to cart!";
        header("Location: newWishlist.php");
        exit(0);
    } else {
        // SQL query with prepared statement for inserting into the shopping_cart table
        $sqlcd = "INSERT INTO `shopping_cart` (image_url, book_name, quantity, price, category, userID, ISBN_fk) 
                  VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt_insert = $mysqli->prepare($sqlcd);
        $stmt_insert->bind_param("sssdsdi", $image_url, $book_name, $quantity, $book_price, $category, $userID, $ISBN_No);
        $stmt_insert->execute();

        $_SESSION['message'] = "Product added to cart successfully";
        header("Location: newWishlist.php");
        exit(0);
    }
}
?>



<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="NethuStyle.css">
   
    <!--fontawesome link-->
    <script src="https://kit.fontawesome.com/22142c7d49.js" crossorigin="anonymous"></script>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!--Bootstraps JS-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <title>Wishlist</title>
  </head>
<body>
 
    <div class="background">
        <nav class="navbar navbar-expand-lg navbar-dark py-5" style="background-color: rgba(10, 10, 102, 0.541);">
            <div class="container">
              <a class="navbar-brand" href="#">  <img src="New_logo.png" alt="Book_shop_logo"></a>
              <h1 class="cartname">Wishlist</h1><br>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              

              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                  <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="index.php">Home</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="category.php">Catagory</a>
                  </li>
				  <li class="nav-item">
                    <a class="nav-link text-warning active" aria-current="page" href="newWishlist.php">Wishlist</a>
                  </li>
				  <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="shoppingNew.php">Shopping cart</a>
                  </li>
                 
                  

                </nav>
                <?php
    require "message.php";
    require "alert.php";
  ?>
<!--shopping cart-->
<section class="h-100 h-custom">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12">
          <div class="card card-registration card-registration-2" style="border-radius: 15px;background-color: rgba(255, 255, 255, 0.871);">
            <div class="card-body p-0">
              <div class="row g-0">
                <div class="col-lg">
                  <div class="p-5">
                    <div class="d-flex justify-content-between align-items-center mb-5">
                      <h1 class="fw-bold mb-0 text-black">Wishlist</h1>
                      
                    </div>
                    <?php 
                      while($row = mysqli_fetch_assoc($allproduct)){
                    ?>
                    <form action="" method="post">
                   <hr class="my-4">
  
                    <div class="row mb-4 d-flex justify-content-between align-items-center">
                      <div class="col-md-2 col-lg-2 col-xl-2">
                        <img
                          src="<?php echo $row['image_url'] ?>"
                          class="img-fluid rounded-3" alt="image">
                      </div>
                      <div class="col-md-3 col-lg-3 col-xl-3">
                        <h6 class="text-muted"><?php echo $row['category'] ?></h6>
                        <h6 class="text-black mb-0"><?php echo $row['book_name'] ?></h6>
                      </div>
                      <div class="col-md-3 col-lg-2 col-xl-2 offset-lg-1">
                        <h6 class="mb-0">Rs.<?php echo $row['price'] ?>.00</h6>
                      </div>
                      <div class="col-md-3 col-lg-3 col-xl-2 d-flex">
                        <button class="add-to-cart-btn" name="add_to_cart">Add To Cart</button>
                     </div>  
                      <div class="col-md-1 col-lg-1 col-xl-1 text-end">
                      <input type="hidden" name="delete" value="<?php echo $row['book_name'] ?>">
                        <button class="btn" type="submit" name="deletebutton" ><i class="fas fa-times"></i></button>
                      </div>
                    </div>
                        <input type="hidden" name="book_name" value="<?php echo $row['book_name'] ?>">
                        <input type="hidden" name="book_price" value="<?php echo $row['price'] ?>">
                        <input type="hidden" name="img_url" value="<?php echo $row['image_url'] ?>">
                        <input type="hidden" name="category" value="<?php echo $row['category'] ?>">
                        <input type="hidden" name="ISBN_No" value="<?php echo $row['ISBN_fk'] ?>">
                        </form>

                    <?php
      
                      }
                      ?>
  
                    
  
                    <hr class="my-4">
  
                    <div class="pt-5">
                      <h6 class="mb-0"><a href="#!" class="text-body"><i
                            class="fas fa-long-arrow-alt-left me-2"></i>Back to shop</a></h6>
                    </div>
                  </div>
                </div>
                
  
                    
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      
    
   

    <?php 
      require_once('Footer.php');
    ?>


  </div>
</div>
  
</div>
  </body>
</html>