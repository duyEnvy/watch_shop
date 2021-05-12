<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/admin-style.css?ver=<?= rand(1, 100000) ?>">
    <title>Document</title>
</head>
<body>
<?php
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    include "sidebar.php";
    include "../include/Config.php";
    if(isset($_POST['delete-order'])){
        $orderID = $_POST['delete-order'];
        $sql = "DELETE FROM `order` WHERE Order_ID ='$orderID'";
        mysqli_query($conn,$sql);
    }
    if(isset($_POST['alter-status'])){
        $alterStatusID = $_POST['alterStatusID'];
        $alterStatus = $_POST['alter-status'];
        $sql = "UPDATE `order` SET Status='$alterStatus' WHERE Order_ID='$alterStatusID'";
        mysqli_query($conn,$sql);
       
        if($alterStatus ==1){
            $sql = "SELECT ol.Product_ID AS proID,ol.Quantity AS orderQuantity,ol.Price AS orderPrice FROM `order_line` AS ol INNER JOIN `product` AS p ON ol.Product_ID = p.Watch_ID WHERE ol.Order_ID ='$alterStatusID'";
            $result = mysqli_query($conn,$sql);
            while($row=mysqli_fetch_assoc($result)){
                $proID = $row['proID'];
                $quantity = $row['orderQuantity']; 
                $sql = "UPDATE `product` SET Quantity = Quantity - '$quantity' WHERE Watch_ID = '$proID' ";
                if(mysqli_query($conn,$sql)){
                    echo "success";
                }else{
                    echo $sql;
                }
            }
        }
        if($alterStatus ==3 || $alterStatus ==0){
            $sql = "SELECT ol.Product_ID AS proID,ol.Quantity AS orderQuantity,ol.Price AS orderPrice FROM `order_line` AS ol INNER JOIN `product` AS p ON ol.Product_ID = p.Watch_ID WHERE ol.Order_ID ='$alterStatusID'";
            $result = mysqli_query($conn,$sql);
            while($row=mysqli_fetch_assoc($result)){
                $proID = $row['proID'];
                $quantity = $row['orderQuantity']; 
                $sql = "UPDATE `product` SET Quantity = Quantity + '$quantity' WHERE Watch_ID = '$proID' ";
                if(mysqli_query($conn,$sql)){
                    echo "success";
                }else{
                    echo $sql;
                }
            }
        }
        
    }
    ?>
    <div class="main">

    <table id="db-table">
            <p>Order list:</p>
            <tr >
                <th>ID</th>
                <th>Customer name</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Note</th>
                <th>Status</th>
                <th>Total price</th>
                <th>Date</th>
                <th>Detail</th>
                <th>Delete</th>
            </tr>
            <?php
            $result = mysqli_query($conn,"SELECT * FROM `order`");
            while($row = mysqli_fetch_assoc($result)){
                
                echo "<tr>";
                    echo '<td>'.$row['Order_ID'].'</td>';
                    echo '<td>'.$row['Customer_Name'].'</td>';
                    echo '<td>'.$row['Phone'].'</td>';
                    echo '<td>'.$row['cusAddress'].'</td>';
                    echo '<td>'.$row['Note'].'</td>';
                    switch ($row['Status']) {
                        case 0:
                            echo "
                                <td>
                                <form method='post' action='' id='myform'>
                                <div class='dropdown'>
                                <button class='dropbtn'>Pending</button>
                                <div class='dropdown-content'>
                                <ul>
                                <input type='hidden' name='alterStatusID' value='".$row['Order_ID']."'>
                                   <li><button type='submit' name='alter-status' value='1'>Shipping</button></li>
                                   <li><button type='submit' name='alter-status' value='2'>Completed</button></li>
                                   <li><button type='submit' name='alter-status' value='3'>Cancelled</button></li>
                                </ul>
                                </div>
                                </div>
                                </form></td>
                            ";
                          break;
                          
                        case 1:
                            echo "
                                <td>
                                <form method='post' action='' id='myform'>
                                <div class='dropdown'>
                                <button class='dropbtn'>Shipping</button>
                                <div class='dropdown-content'>
                                <ul>
                                <input type='hidden' name='alterStatusID' value='".$row['Order_ID']."'>
                                   <li><button type='submit' name='alter-status' value='0'>Pending</button></li>
                                   <li><button type='submit' name='alter-status' value='2'>Completed</button></li>
                                   <li><button type='submit' name='alter-status' value='3'>Cancelled</button></li>
                                </ul>
                                </div>
                                </div>
                                </form></td>
                            ";
                          break;
                        case 2:
                            echo '<td>Completed</td>';
                            break;
                        case 3:
                            echo '<td>Cancelled</td>';
                            break;
                        default:
                      }
                    
                    echo '<td>'.$row['Total_Price'].'</td>';
                    echo '<td>'.$row['Cur_Date'].'</td>';
                    echo '<td><a href="detail_order.php?id=' . $row['Order_ID'] . '">Detail</a></td>';
                    echo "<form method='post'>";
                    echo '<td><button id="deleteOrder" type="submit" name="delete-order" value='.$row['Order_ID'].'>Delete</button></td>';
                    echo "</form>";
                    echo "</tr>";
            }
            ?>
        </table>
    </div>


    </div>
        <?php }else {
        echo '<meta http-equiv="refresh" content="0;url=admin.php">';
    } ?>
</body>
</html>