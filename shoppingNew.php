<!--SQL DATABASE connection-->
<?php
  
  session_start();
  $mysqli = require __DIR__."/DBconnect.php";
  
  if (!isset($_SESSION['userId'])) {
    $_SESSION['status'] = "You are not Logged in";
            $_SESSION['status_code']= "error";
            
    header("Location: Sign-in.php"); 
    exit(0);
    
  }
  $userID = $_SESSION['userId'];

  $sql = "SELECT sc.*, b.Current_books
          FROM shopping_cart sc
          JOIN book b ON sc.ISBN_fk = b.ISBN_No
          WHERE sc.userID = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $userID);
$stmt->execute();
$allproduct = $stmt->get_result();

if ($allproduct) {
  $numrows = $allproduct->num_rows;
} else {
 
  $numrows = 0;
}

   
  

  if(isset($_POST['deletebutton'])){
    $deleteItem = $_POST['delete'];

    $sql = "DELETE FROM `shopping_cart` WHERE book_name = '$deleteItem';";
    if($result = $mysqli->query($sql)){
      $_SESSION['message'] = "product Removed From cart succesfully";
      header("Location:shoppingNew.php");
      exit(0);
    }

  }

  $i = 0;

  
    
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
    <title>Shopping Cart</title>


    <script>
 function updateQuantityInDatabase(scartID, newQuantity, newTotalPrice) {
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        console.log(this.responseText);
      }
    };

    xhttp.open("POST", "updateQuantityInDatabase.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(`scartID=${scartID}&quantity=${newQuantity}&totalPrice=${newTotalPrice}`);
  }

 function updateQuantity(row, increment, scartID, stock) {
  let quantityElement = document.getElementById (`quantity-${row}`);
  let newQuantity = parseInt(quantityElement.value) + increment;

  if (newQuantity >= 1 && newQuantity <= stock) {
    quantityElement.value = newQuantity;
    calculatePrice(row, newQuantity);
    calculateTotalPrice();

    let priceElement = document.querySelector(`[data-row="${row}"][data-price]`);
    let price = parseFloat(priceElement.dataset.price);
    let newTotalPrice = price * newQuantity;

    console.log(scartID);
    console.log(newTotalPrice);

    // Update the total price in the database
    updateQuantityInDatabase(scartID, newQuantity, newTotalPrice);
  }
}


    


  function calculatePrice(row, quantity) {
    let priceElement = document.querySelector(`[data-row="${row}"][data-price]`);
    let price = parseFloat(priceElement.dataset.price);
    let newPrice = price * quantity;
    priceElement.innerText = `Rs. ${newPrice.toFixed(2)}`;
  }

  function calculateTotalPrice() {
    let overallTotalPrice = 0;
    let allProductElements = document.querySelectorAll('[data-price]');
    allProductElements.forEach((element) => {
      let row = element.dataset.row;
      let quantity = parseInt(document.getElementById(`quantity-${row}`).value);
      let price = parseFloat(element.dataset.price);
      let totalPrice = price * quantity;
      overallTotalPrice += totalPrice;
    });

    document.getElementById('overallTotalPriceDisplay').innerText = `Rs. ${overallTotalPrice.toFixed(2)}`;
  }

  window.onload = function () {
    let allProductElements = document.querySelectorAll('[data-price]');
    allProductElements.forEach((element) => {
      let row = element.dataset.row;
      let quantity = parseInt(document.getElementById(`quantity-${row}`).value);
      calculatePrice(row, quantity);

      // Add event listeners to the plus and minus 
      document.getElementById(`quantity-minus-${row}`).addEventListener('click', function () {
        updateQuantity(row, -1);
      });
      document.getElementById(`quantity-plus-${row}`).addEventListener('click', function () {
        updateQuantity(row, 1);
      });
    });

    // Calculate  total price
    calculateTotalPrice();
  };

  function updateTotalPriceDisplay(totalPrice) {
    let totalPriceElement = document.getElementById('overallTotalPriceDisplay');
    totalPriceElement.innerText = `Rs. ${totalPrice.toFixed(2)}`;
  }

  
  
  function validateCardDetails() {
    const cardNum = document.getElementById("cardNum").value;
    const typeName = document.getElementById("typeName").value;
    const typeExp = document.getElementById("typeExp").value;
    const cvv = document.getElementById("cvv").value;

    if (!cardNum || !typeName || !typeExp || !cvv) {
      alert("Please fill in all card details before checking out.");
      return false;
    }

    location.href = "checkout.php";
  }
  

  
</script>

  



  </head>
<body>
    <div class="background">
        <nav class="navbar navbar-expand-lg navbar-dark py-5" style="background-color: rgba(10, 10, 102, 0.541);">
            <div class="container">
              <a class="navbar-brand" href="#">  <img src="New_logo.png" alt="Book_shop_logo"></a>
              <h1 class="cartname">Shopping cart</h1><br>
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
                    <a class="nav-link" aria-current="page" href="newWishlist.php">Wishlist</a>
                  </li>
				  <li class="nav-item">
                    <a class="nav-link text-warning active" aria-current="page" href="#">Shopping cart</a>
                  </li>
                 
                  

                </nav>
<!--shopping cart-->
<?php
    include "alert.php";
    include "message.php";
    ?>
    <section class="h-100 h-custom">
      <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
          <div class="col-12">
            <div class="card card-registration card-registration-2"
              style="border-radius: 15px;background-color: rgba(255, 255, 255, 0.871);">
              <div class="card-body p-0">
                <div class="row g-0">
                  <div class="col-lg-8">
                    <div class="p-5">
                      <div class="d-flex justify-content-between align-items-center mb-5">
                        <h1 class="fw-bold mb-0 text-black">Shopping Cart</h1>
                        <h6 class="mb-0 text-muted"><?php echo $numrows ?> items</h6>
                      </div>

                      <?php
                      while ($row = mysqli_fetch_assoc($allproduct)) {
                        $totalPrice = $row['price'] * $row['quantity'];
                        $stock = $row['Current_books'];
                        ?>
                        <hr class="my-4">
                        <form action="" method="post">
                          <div class="row mb-4 d-flex justify-content-between align-items-center">
                            <div class="col-md-1 col-lg-1 col-xl-1 text-end">
                              <input type="hidden" name="delete" value="<?php echo $row['book_name'] ?>">
                              <button class="btn" type="submit" name="deletebutton"><i class="fas fa-times"></i></button>
                            </div>

                            <div class="col-md-2 col-lg-2 col-xl-2">
                              <img src="<?php echo $row['image_url'] ?>" class="img-fluid rounded-3" alt="Cotton T-shirt">
                            </div>

                            <div class="col-md-3 col-lg-3 col-xl-3">
                              <h6 class="text-muted">
                                <?php echo $row['category'] ?>
                              </h6>
                              <h6 class="text-black mb-0">
                                <?php echo $row['book_name'] ?>
                                
                              </h6>
                              
                            </div>
                            
                            

                            <div class="col-md-3 col-lg-3 col-xl-2 d-flex">
                            <button class="input-group-text" type="button" data-row="<?php echo $i; ?>" data-scartID="<?php echo $row['ScartID']; ?>" onclick="updateQuantity(<?php echo $i; ?>, -1, <?php echo $row['ScartID']; ?>,<?php echo $stock; ?>)">-</button>
                            <input type="number" id="quantity-<?php echo $i; ?>" class="form-control form-control-sm" value="1" min="1" max="10" onchange="updateQuantity(<?php echo $i; ?>, 0, <?php echo $row['ScartID']; ?>)">
                            <button class="input-group-text" type="button" data-row="<?php echo $i; ?>" data-scartID="<?php echo $row['ScartID']; ?>" onclick="updateQuantity(<?php echo $i; ?>, 1, <?php echo $row['ScartID']; ?>,<?php echo $stock; ?>)">+</button>

                            </div>


                            <div class="col-md-3 col-lg-2 col-xl-2 offset-lg-1">
                              
                                <h6 class="mb-0" data-price="<?php echo $row['price']; ?>" data-row="<?php echo $i; ?>">Rs. <?php echo ($row['price'] * $row['quantity']); ?>.00</h6>
                              

                        </form>
                      </div>

                    </div>









                    <?php $i++; 
                      
                    }
                    $overallTotalPrice = 0;
                      mysqli_data_seek($allproduct, 0); // Reset the result set pointer
                      while ($row = mysqli_fetch_assoc($allproduct)) {
                        $totalPrice = $row['price'] * $row['quantity'];
                        $overallTotalPrice += $totalPrice;
                      }
                     ?>

                    <div class="d-flex justify-content-between mb-4" style="font-weight: 500;">
                      <br><br><br>
                    </div>
                   






                  <hr class="my-4">

                  <div class="pt-5">
                    <h6 class="mb-0"><a href="#!" class="text-body"><i class="fas fa-long-arrow-alt-left me-2"></i>Back
                        to shop</a></h6>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 bg-grey">
                <div class="p-5">
                  <h3 class="fw-bold mb-5 mt-2 pt-1">Summary</h3>
                  <hr class="my-4">

                  <div class="d-flex justify-content-between mb-4">
                    <h5 class="text-uppercase">items <?php echo $numrows ?></h5>
                    
                  </div>





                  <h5 class="text-uppercase mb-3"></h5>

                  <div class="mb-5">
                    
                  </div>

                  <hr class="my-4">

                  <div class="d-flex justify-content-between mb-5">
                    <h5 class="text-uppercase">Total price</h5>
                    <h5 id="overallTotalPriceDisplay">Rs. <?php echo $overallTotalPrice; ?>.00</h5>
                  </div>


                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>
  </div>
    <!--card payment-->
      <div class="card shadow-2-strong mb-5 mb-lg-0" style="border-radius: 16px; background-color: rgba(255, 255, 255, 0.847); margin: 5%;">
        <div class="card-body p-4">

          <div class="row">
            <div class="col-md-6 col-lg-4 col-xl-3 mb-4 mb-md-0">
              <form>
                <div class="d-flex flex-row pb-3">
                  <div class="d-flex align-items-center pe-2">
                    <input class="form-check-input" type="radio" name="radioNoLabel" id="radioNoLabel1v"
                      value="" aria-label="..." checked />
                  </div>
                  <div class="rounded border w-100 p-3">
                    <p class="d-flex align-items-center mb-0">
                      <i class="fab fa-cc-mastercard fa-2x text-dark pe-2"></i>Credit
                      Card
                    </p>
                  </div>
                </div>
                <div class="d-flex flex-row pb-3">
                  <div class="d-flex align-items-center pe-2">
                    <input class="form-check-input" type="radio" name="radioNoLabel" id="radioNoLabel2v"
                      value="" aria-label="..." />
                  </div>
                  <div class="rounded border w-100 p-3">
                    <p class="d-flex align-items-center mb-0">
                      <i class="fab fa-cc-visa fa-2x fa-lg text-dark pe-2"></i>Debit Card
                    </p>
                  </div>
                </div>
                <div class="d-flex flex-row">
                  <div class="d-flex align-items-center pe-2">
                    
                  </div>
                  <div class="rounded border w-100 p-3">
                   
                  </div>
                </div>
              </form>
            </div>
            <div class="col-md-6 col-lg-4 col-xl-6">
              <div class="row">
                <div class="col-12 col-xl-6">
                  <div class="form-outline mb-4 mb-xl-5">
                    
                    <input type="text" id="typeName" class="form-control form-control-lg" siez="17"
                      placeholder="John Smith"  />
                    <label class="form-label"  for="typeName">Name on card</label>
                  </div>

                  <div class="form-outline mb-4 mb-xl-5">
                    <input type="date" id="typeExp" class="form-control form-control-lg" placeholder="MM/YY"
                      size="7" id="exp" minlength="7" maxlength="7" />
                    <label class="form-label" for="typeExp">Expiration</label>
                  </div>
                </div>
                <div class="col-12 col-xl-6">
                  <div class="form-outline mb-4 mb-xl-5">
                    <input type="text" id="cardNum" class="form-control form-control-lg" siez="17"
                      placeholder="1111 2222 3333 4444" minlength="19" maxlength="19"    />
                    <label class="form-label" for="cardNum">Card Number</label>
                  </div>

                  <div class="form-outline mb-4 mb-xl-5">
                    <input type="password" id="cvv" class="form-control form-control-lg"
                      placeholder="&#9679;&#9679;&#9679;" size="1" minlength="3" maxlength="3"  />
                    <label class="form-label" for="cvv">Cvv</label>
                  </div>
                </div>
              </div>
            </div>
           
            <div class="col-lg-4 col-xl-3">
              <div class="d-flex justify-content-between" style="font-weight: 500;">
                <p class="mb-2"></p>
                <p class="mb-2"></p>
              </div>

              <div class="d-flex justify-content-between" style="font-weight: 500;">
                <p class="mb-0"></p>
                <p class="mb-0"></p>
              </div>

              <hr class="my-4">

              <div class="d-flex justify-content-between mb-4" style="font-weight: 500;">
                <br><br><br>
              </div>
              <a class="btn btn-primary" style="margin-left: 75%;" id="checkoutButton" role="button" onclick="validateCardDetails()" >Checkout</a>

           
            
  </section>
  
                    

   

    <?php 
      require_once('Footer.php');
    ?>


  
  </div>
  </div>
</div>
  </body>
</html>