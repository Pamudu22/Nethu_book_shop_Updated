<!--SQL DATABASE connection-->
<?php
  session_start();
  include_once "DBconnect.php";
  
?>

<!doctype html>
<html lang="en">
  <head>
   <!-- Required meta tags -->
    
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--fontawesome link-->
    <script src="https://kit.fontawesome.com/22142c7d49.js" crossorigin="anonymous"></script>
   
   <link rel="stylesheet" href="NethuStyle.css">
   <!-- Bootstrap CSS -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
   <!--Bootstraps JS-->
   <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    
    <title>Nethu Book Shop</title>
  </head>
  <body>
    <div class="Homeback">
           
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
              <a class="nav-link text-warning active" aria-current="page" href="#">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="AdminSignup.php">Sign-up</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="new_Inventory.php">Inventory</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="Admin_Book_Manager.php">Inventory Manager</a>
            </li>
            <li class="nav-item">
              <a class="admintxt" aria-current="page" >Hello Admin!</a>
            </li>
          </nav>
          <!--End of navigation-->
            <?php ;
              include "alert.php";?>
              <div class="Front">
                <br><br>
                <div class="Bname">Nethu Book Shop</div><br><br>
                <h1>Where everything <br>you need to know <br>is only an arm’s length away!</h1>
                
              </div>

              
   


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <?php 
      require_once('footerAdmin.php');
    ?>
    


</div>

  </body>
</html>