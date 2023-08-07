<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


    <?php
    if(isset($_SESSION['status']) && $_SESSION['status'] !=''){?>
    <script>
           swal({
            title: "<?php echo $_SESSION['status'];?>",
            text: "",
            icon: "<?php echo $_SESSION['status_code'];?>",
            button: "Done",
            });
     </script>
     <?php
        unset($_SESSION['status']);
    }
        ?>
<?php if(isset($_SESSION['order'])){?>
<script>
    swal({
        title: "Your Order Detail",
        text: "Order status: Paid\n" +
              "Order Value: Rs. <?php echo $_SESSION['value']; ?>.00\n" +
              "Order ID: <?php echo $_SESSION['order']; ?>\n" +
              "Customer Name: <?php echo $_SESSION['name']; ?>\n" +
              "Customer Email: <?php echo $_SESSION['email']; ?>\n" +
              "Customer Phone: <?php echo $_SESSION['phone']; ?>\n" +
              "We will contact you soon...",
        icon: "success"
    });
</script>
<?php
unset($_SESSION['value']);
unset($_SESSION['order']);
unset($_SESSION['name']);
unset($_SESSION['email']);
unset($_SESSION['phone']);
}?>
