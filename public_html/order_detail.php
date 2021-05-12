<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/css/style.css?ver=<?=rand(1,100000)?>">
</head>
<body>
<?php
        include "header.php";
        if(isset($_POST['detail-order'])){
            $orderID = $_POST['detail-order'];
            $sql= "SELECT *,SUM(Price) AS Sum_Price FROM `order` AS o INNER JOIN `order_line` AS ol ON o.Order_ID = ol.Order_ID WHERE o.Order_ID = '$orderID' GROUP BY ol.Order_ID";
            $result = mysqli_query($conn,$sql);
            $row = mysqli_fetch_assoc($result);
            echo "<h3>Order #". $row['Order_ID'] ." details</h3>";

            ?>
            <div class="check-out-form">
                <p>Customer name:<?php echo $row['Customer_Name']; ?></p>
                <p>Phone number:<?php echo $row['Phone']; ?></p>
                <p>Address:<?php echo $row['cusAddress']; ?></p>
                <p>Note:<?php echo $row['Note']; ?></p>
                <p>Status:
                    <?php 
                        switch ($row['Status']) {
                            case 0:
                                echo "Pending";
                                break;
                            case 1:
                                echo "Shipping";
                                break;
                            case 2:
                                echo "Completed";
                                break;
                            case 3:
                                echo "Cancelled";
                                break;
                            default:
                          }
                    ?></p>
                <p>Total price:<?php echo $row['Sum_Price']; ?>$</p>
                <p>Date:<?php echo $row['Cur_Date']; ?></p>
            </div>
            <div class="checkout-all-product-container">
            <h3>Product list: </h3>
                <?php
                $sql = "SELECT *,ol.Quantity AS orderQuantity,ol.Price AS orderPrice FROM `order_line` AS ol INNER JOIN `product` AS p ON ol.Product_ID = p.Watch_ID WHERE ol.Order_ID ='$orderID'";
                $result = mysqli_query($conn,$sql);
                while($row=mysqli_fetch_assoc($result)){ 
                ?>        
                          
                          <div class="checkout-product-container">
                          <?php echo '<img id="checkout-img" src="'.$row['picture'].'" alt="Watch Image">' ?>
                          <div class="checkout-product-info">
                          <?php echo '<span>'.$row['Watch_Name'].'</span><br>'?>
                          <span> Quantity:  <?php echo $row['orderQuantity'] ?></span>
                          <span id="checkout-price">Price: <?php echo $row['orderPrice'] ?>$</span>
                          </div>
                          </div>
                <?php 
                      
                } 
    ?>
    </div>



            <?php

        }
    
    ?>
</body>
</html>