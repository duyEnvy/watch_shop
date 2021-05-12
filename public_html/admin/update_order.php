<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
include "../include/Config.php";

        if(isset($_POST['update-quantity'])){
            $updateOrderID = $_POST['orderID'];
            $updateQuantity = $_POST['quantity'];
            $updatePrice = $_POST['updatePrice']*$updateQuantity;
            $productID = $_POST['productID'];
            $sql = "UPDATE `order_line` SET Quantity='$updateQuantity',Price='$updatePrice' WHERE Order_ID='$updateOrderID' AND Product_ID='$productID'";
            mysqli_query($conn,$sql);
            echo '<meta http-equiv="refresh" content="1;url=edit_order.php?edit-order='.$updateOrderID.'">';
        }
        if(isset($_POST['delete-quantity'])){
            $updateOrderID = $_POST['orderID'];
            $productID = $_POST['productID'];
            $sql = "DELETE FROM `order_line` WHERE Order_ID='$updateOrderID' AND Product_ID='$productID'";
            mysqli_query($conn,$sql);
            echo '<meta http-equiv="refresh" content="1;url=edit_order.php?edit-order='.$updateOrderID.'">';
        }
                if(isset($_POST['submit-edit'])){
                    
                    $orderID=$_POST['orderID'];
                    $name=$_POST['customer-name'];
                    $phone=$_POST['phone'];
                    $address=$_POST['address'];
                    $note=$_POST['note'];
                    $sql = "UPDATE `order` SET Customer_Name='$name',Phone='$phone',cusAddress='$address',Note='$note' WHERE Order_ID = '$orderID'";
                    mysqli_query($conn,$sql);
                    echo '<meta http-equiv="refresh" content="1;url=edit_order.php?edit-order='.$orderID.'">';
                }
                if(isset($_POST['add_product'])){
                    $proID = $_POST['add_pro_id'];
                    $quantity = $_POST['add_pro_quantity'];
                    $orderID=$_POST['orderID'];
                    $sql = "SELECT Price FROM product WHERE Watch_ID = '$proID'";
                    $result = mysqli_query($conn,$sql);
                    $row = mysqli_fetch_assoc($result);
                    $price = $row['Price']*$quantity;
                    $sql = "SELECT * FROM `order_line` WHERE Order_ID='$orderID' AND Product_ID='$proID'";
                    $result = mysqli_query($conn,$sql);
                    $num_rows = mysqli_num_rows($result);
                    echo $num_rows;
                    if($num_rows>0){
                        $sql = "UPDATE `order_line` SET Quantity = Quantity+$quantity,Price='$price' WHERE Order_ID='$orderID' AND Product_ID='$proID' ";
                        mysqli_query($conn,$sql);
                    }else{
                        $sql = "INSERT INTO `order_line` VALUES ('$orderID','$proID','$quantity','$price')";
                    mysqli_query($conn,$sql);
                    }
                    
                    
                    echo '<meta http-equiv="refresh" content="1;url=edit_order.php?edit-order='.$orderID.'">';
                }}else {
                    echo '<meta http-equiv="refresh" content="0;url=admin.php">';
                }
        
        ?>
</body>
</html>