<?php
require_once "DBconnect.php";
session_start();
?>
<!DOCTYPE html>
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
    <link href="background.css" rel="stylesheet">
    <title>Checkout</title>
    <style>
      body{
    padding:0;
    margin:0;
    width:100%;
    height:100vh;
    background-image: url("gradientBg.jpg");
}
.wrapper{
    width:200px;
    height:60px;
    position: absolute;
    
    left:50%;
    top:50%;
    transform: translate(-50%, -50%);
}
.circle{
    width:20px;
    height:20px;
    position: absolute;
    border-radius: 50%;
    background-color: #fff;
    left:15%;
    transform-origin: 50%;
    animation: circle .5s alternate infinite ease;
}

@keyframes circle{
    0%{
        top:60px;
        height:5px;
        border-radius: 50px 50px 25px 25px;
        transform: scaleX(1.7);
    }
    40%{
        height:20px;
        border-radius: 50%;
        transform: scaleX(1);
    }
    100%{
        top:0%;
    }
}
.circle:nth-child(2){
    left:45%;
    animation-delay: .2s;
}
.circle:nth-child(3){
    left:auto;
    right:15%;
    animation-delay: .3s;
}
.shadow{
    width:20px;
    height:4px;
    border-radius: 50%;
    background-color: rgba(0,0,0,.5);
    position: absolute;
    top:62px;
    transform-origin: 50%;
    z-index: -1;
    left:15%;
    filter: blur(1px);
    animation: shadow .5s alternate infinite ease;
}

@keyframes shadow{
    0%{
        transform: scaleX(1.5);
    }
    40%{
        transform: scaleX(1);
        opacity: .7;
    }
    100%{
        transform: scaleX(.2);
        opacity: .4;
    }
}
.shadow:nth-child(4){
    left: 45%;
    animation-delay: .2s
}
.shadow:nth-child(5){
    left:auto;
    right:15%;
    animation-delay: .3s;
}
.wrapper span{
    position: absolute;
    top:25%;
    font-family: 'Lato';
    font-size: 20px;
    letter-spacing: 12px;
    color: #fff;
    left:15%;
}

th{
            background-color:gray;
            padding:2%;
            width:25%;
            color: white;
        }
        tr{
            padding:3%;
            background-color :darkcyan;
            color: white;

        }
      </style>

  </head>
<body>


 <!-- Loader animation -->
 <div id="loader" class="wrapper" style=" display: none;">
            <div class="circle"></div>
            <div class="circle"></div>
            <div class="circle"></div>
            <div class="shadow"></div>
            <div class="shadow"></div>
            <div class="shadow"></div>
            <span style="margin-top: 25%;">Finalizing Your Order</span>
        </div>






<!--bank simulator-->
<div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalToggleLabel">Authenticate Transacion</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <!--First model detail start-->
                  
                   <div class="text-success" style="background-color: antiquewhite; padding: 6%; border-radius: 2px;" aria-disabled="true">
                    <p>
                      We have sent an OTP to your registered mobile number xxxxxxx908 please enter your OTP to authenticate this transacion
                    </p>
                  </div>
                  <label style="font-weight: 600; color: gray;">One Time Password (OTP)</label><br>
                 
                  
                  <!--Text restriction-->
                  <script>function checkInput(ob) {
                    const invalidChars = /[^0-9]/gi;
                    if(invalidChars.test(ob.value)) {
                      ob.value = ob.value.replace(invalidChars, "");
                    }

                    
                  };
                </script> 
                <!--OTP verification-->
                <button  onclick="generateOTPcode()" class="btn btn-primary">Send OTP</button>
                  <br><br>
                  <input maxlength="6" onChange="checkInput(this)"style="padding:10px;"
                   onKeyup="checkInput(this)" type="text" id="userInput"  placeholder="Enter the OTP">
                  <br><br>
                  <button class="btn btn-primary" style="margin-left: 80%;" onclick="confirmOTPcode()">Confirm</button>
                  <div id="result" class="result"></div>
                

                  
                   <!--First model detail end-->
                 </div>
                 <div class="modal-footer">
                
                </div>
              </div>
            </div>
          </div>
          <div id="slideContainer" style="display: none;">
          <div class="slide">
          <h1>Your Finalizd Order</h1><br>
          <?php
          $userID = $_SESSION['userId'];
          $sql = "SELECT sc.*, b.Language FROM `shopping_cart` sc
          JOIN `book` b ON sc.ISBN_fk = b.ISBN_No
          WHERE sc.userID = ?";
          $stmt = $mysqli->prepare($sql);
          $stmt->bind_param("i", $userID);
          $stmt->execute();
          $allproduct = $stmt->get_result();

          $sqlSum = "SELECT SUM(`tot_price`) AS total_price FROM `shopping_cart` WHERE `userID` = ? ";
          $stmtSum = $mysqli->prepare($sqlSum);
          $stmtSum->bind_param("i", $userID);
          $stmtSum->execute();
          $resultSum = $stmtSum->get_result();
          $totalPriceRow = $resultSum->fetch_assoc();
          $totalPrice = $totalPriceRow['total_price'];
          ?>
           <table>
            <tr>
                <th>Book category</th>
                <th>Book Name</th>
                <th>Language</th>
                <th>Quantity</th>
            </tr>
            

              <?php
            while ($row = mysqli_fetch_assoc($allproduct)) {
              ?>

            <tr>
                <td><?php echo $row['category']?></td>
                <td><?php echo $row['book_name']?></td>
                <td><?php echo $row['Language']?></td>
                <td><?php echo $row['quantity']?> </td>
            </tr>
            <?php }?>

          
          <a id="checkoutBtn" class="btn btn-primary" style="margin-bottom: 2%;"  data-bs-toggle="modal" href="#exampleModalToggle" role="button">Checkout</a>
          <h5 class="mb-5">Total Price: <?php echo $totalPrice?></h5>
            
        </div>
            </div>
            </div>
          </div>


        </div>

        <script>
            function showSlides() {
            var loader = document.getElementById("loader");
            var slideContainer = document.getElementById("slideContainer");

            // Hide the loader
            loader.style.display = "none";
            // Show the slide container
            slideContainer.style.display = "block";
        }

        
        function hideLoader() {
            showSlides();
        }

        // Show the loader on page load
        window.onload = function () {
            var loader = document.getElementById("loader");
            loader.style.display = "block";

           
            setTimeout(hideLoader, 5000);
        };
   


   let OTPcode;
    
    function generateOTPcode() {
      
      OTPcode = Math.floor(100000 + Math.random() * 900000);
      
      
      alert("Your OTP Number is: " + OTPcode);
    }
    
    function confirmOTPcode() {
      
      const userInput = document.getElementById("userInput").value;
      
      
      if (userInput === OTPcode.toString()) {
        location.href = "otpvalid.php";
      } else {
        location.href = "otpinvalid.php";
      }
    }





</script>
</body>
</html>