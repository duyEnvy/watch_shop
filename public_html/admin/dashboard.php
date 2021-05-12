<?php session_start(); ?>
!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/admin-style.css?ver=<?= rand(1, 100000) ?>">
    <title>Dashboard</title>
</head>
<body>
<?php
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    include "sidebar.php";
    ?>
    
    <div class="main">

    <?php
            include "../include/Config.php";
            $result = mysqli_query($conn,"SELECT SUM(order_line.Price) AS price_sum FROM order_line INNER JOIN `order` As o ON order_line.Order_ID = o.Order_ID WHERE o.Status = 2");
            $row = mysqli_fetch_assoc($result);
            $sum = $row['price_sum'];
            if ($sum <1){
                $sum =0;
            }
            echo "<div id='income' class='dbbox'> Sale volume:<br>$sum $</div>";
            $result = mysqli_query($conn,"SELECT COUNT(Order_ID) AS order_num FROM `order`");
            $row = mysqli_fetch_assoc($result);
            $sum = $row['order_num'];
            if ($sum <1){
                $sum =0;
            }
            echo "<div id = 'orders' class='dbbox'> Orders:<br>$sum</div>";
            $result = mysqli_query($conn,"SELECT SUM(order_line.Quantity) AS product_sold FROM order_line INNER JOIN `order` As o ON order_line.Order_ID = o.Order_ID WHERE o.Status = 2");
            $row = mysqli_fetch_assoc($result);
            $sum = $row['product_sold'];
            if ($sum <1){
                $sum =0;
            }
            echo "<div id= 'product-sold' class='dbbox'> Products sold:<br>$sum</div>";     
        ?>
        <table id="db-table">
            <p>Product sale table:</p>
            <tr >
                <th>Product name</th>
                <th>Image</th>
                <th>ID</th>
                <th>Quantity</th>
                <th>Total value sale</th>
            </tr>
            <?php
            $result = mysqli_query($conn,"SELECT picture,Watch_Name,product.Price AS single_price,SUM(order_line.Quantity) AS product_sold,Product_ID FROM order_line INNER JOIN `order` As o ON order_line.Order_ID = o.Order_ID INNER JOIN `product` ON product.Watch_ID = order_line.Product_ID WHERE o.Status = 2 GROUP BY Product_ID");
            while($row = mysqli_fetch_assoc($result)){
                echo "<tr>";
                    echo '<td>'.$row['Watch_Name'].'</td>';
                    echo '<td><img src="'.$row['picture'].'" width="50px" height="45px"></td>';
                    echo '<td>'.$row['Product_ID'].'</td>';
                    echo '<td>'.$row['product_sold'].'</td>';
                    echo '<td>'.$row['single_price']*$row['product_sold'].'</td>';
                echo "</tr>";
            }
            ?>
        </table>
        <table id="db-table">
            <p>Order list table:</p>
            <tr >
                <th>Order ID</th>
                <th>Customer name</th>
                <th>Value</th>
                <th>Date</th>
                <th>Status</th>
            </tr>
            <?php
            $result = mysqli_query($conn,"SELECT *,SUM(Price) AS Sum_Price FROM `order` AS o INNER JOIN `order_line` AS ol ON o.Order_ID = ol.Order_ID GROUP BY ol.Order_ID");
            while($row = mysqli_fetch_assoc($result)){
                echo "<tr>";
                    echo '<td>'.$row['Order_ID'].'</td>';
                    echo '<td>'.$row['Customer_Name'].'</td>';
                    echo '<td>'.$row['Sum_Price'].'</td>';
                    echo '<td>'.$row['Cur_Date'].'</td>';
                    switch ($row['Status']) {
                        case 0:
                            echo '<td>Pending</td>';
                          break;
                        case 1:
                            echo '<td>Shipping</td>';
                          break;
                        case 2:
                            echo '<td>Completed</td>';
                          break;
                        case 3:
                            echo '<td>Cancelled</td>';
                            break;
                        default:
                        echo '<td>Undefined</td>';
                      }
                echo "</tr>";
            }
            ?>
        </table>
    
    </div>
        <?php }else {
        echo '<meta http-equiv="refresh" content="0;url=admin.php">';
    } ?>
        
</body>
</html>