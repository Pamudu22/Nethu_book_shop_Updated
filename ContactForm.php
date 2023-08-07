<!DOCTYPE html>
<?php
  session_start();
  $mysqli = require __DIR__."/DBconnect.php";
  

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

  <link rel="stylesheet" href="cform.css">

  <title>Contact Form</title>

 
  <style>
      .inpttxt{
        width: 100%;
      }
    </style>
</head>
<body>
  <div class="background">
    <nav class="navbar navbar-expand-lg navbar-dark py-5" style="background-color: rgba(10, 10, 102, 0.541);">
      <div class="container">
        <a class="navbar-brand" href="#">  <img src="New_logo.png" alt="Book_shop_logo"></a>
        <h1 class="cartname">Nethu Book Shop</h1><br>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="category.php">category</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!--end of navigation-->
    <?php
      require "message.php";
      require "alert.php";
    ?>
    <h1 style="color:white; font-weight: 300; text-align: center; margin-top: 5%;"  >Delivery Information</h1>

    <div class="back">
    <form method="post" action="cformprcs.php">
        <label for="name">Name</label><br>
        <input class="inpttxt" type="text" name="name" id="name" required><br>
        
        <label for="email">email</label><br>
        <input class="inpttxt" type="email" name="email" id="email" required><br>
        
        <label for="contact">Mobile Number</label><br>
        <input class="inpttxt" type="text" name="contact" id="contact" required><br>
        
       

        <label for="Address">Address</label><br>
        <input type="text" class="inpttxt" name="Address" id="Address" required>
        
        <br>
        
        <button name="send" type="submit" class="button add">Send</button>
    </form>
    </div>

    
  
 

</body>
<?php
  require "Footer.php";
?>
