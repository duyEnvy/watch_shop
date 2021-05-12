<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track order</title>
    <link rel="stylesheet" href="assets/css/style.css?ver=<?= rand(1, 100000) ?>">
</head>
<body>
<?php
        
        include "header.php";
        if(isset($_COOKIE["orderID"])){
            $array =  json_decode($_COOKIE["orderID"]);
            ?>
                    <table id="track-order">
                        <h3>Your order:</h3>
                        <tr>
                            <th>Order ID</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Phone</th>
                            <th>Note</th>
                            <th>Total price</th>
                            <th>Order date</th>
                            <th>Status</th>
                            <th>Detail</th>
                        </tr>
                <?php
            foreach ($array as $value) {
                $sql = "SELECT *,SUM(Price) AS Sum_Price FROM `order` AS o INNER JOIN `order_line` AS ol ON o.Order_ID = ol.Order_ID WHERE o.Order_ID = '$value' GROUP BY ol.Order_ID";
                $result = mysqli_query($conn,$sql);
                
                while($row = mysqli_fetch_assoc($result)){
                    echo "<tr>";
                    echo '<td>'.$row['Order_ID'].'</td>';
                    echo '<td>'.$row['Customer_Name'].'</td>';
                    
                    echo '<td>'.$row['cusAddress'].'</td>';
                    echo '<td>'.$row['Phone'].'</td>';
                    echo '<td>'.$row['Note'].'</td>';
                    echo '<td>'.$row['Sum_Price'].' $</td>';
                    echo '<td>'.$row['Cur_Date'].'</td>';
                    switch ($row['Status']) {
                        case 0:
                            echo '<td>Processing</td>';
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
                      }
                    
                    
                    
                    echo '
                    <form method="POST" action="order_detail.php">
                    <td><button id="editProduct" type="submit" name="detail-order" value="' . $row['Order_ID'] . '">Detail</button></td>';
                    
                }
            }
        }else{
            echo "<h2>You haven't order anything recently</h2>"; 
        }
        
    ?>
    
</body>
</html>