<?php

    

    if (isset($_SESSION['message'])){
        ?><div class="alert alert-warning alert-dismissible fade show" role="alert" style="width: 50%; text-align: center; margin-left:25%;margin-top:20px;">
        <strong>Hey!</strong> <?= $_SESSION['message']?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
        <?php 
    }
    unset($_SESSION['message']);
    if (isset($_SESSION['msg'])){
        ?><div class="alert alert-warning alert-dismissible fade show" role="alert" style="width: 50%; text-align: center; margin-left:25%;margin-top:20px;">
        <strong>Hey!</strong> <?= $_SESSION['msg']?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
        <?php
    }
    unset($_SESSION['msg']);
    if (isset($_SESSION['messg'])){
      ?><div class="alert alert-success alert-dismissible fade show" role="alert" style="width: 50%; text-align: center; margin-left:25%;margin-top:20px;">
      <strong>Hey!</strong> <?= $_SESSION['messg']?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
      <?php 
  }
  unset($_SESSION['messg']);

  if (isset($_SESSION['meg'])){
    ?><div class="alert alert-danger alert-dismissible fade show" role="alert" style="width: 50%; text-align: center; margin-left:25%;margin-top:20px;">
    <strong>Hey!</strong> <?= $_SESSION['meg']?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
    <?php 
}
unset($_SESSION['meg']);

     

?>