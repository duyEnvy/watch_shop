<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/admin-style.css?ver=<?= rand(1, 100000) ?>">
    <title>Edit order</title>
</head>
<body>
<?php
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    include "sidebar.php";
    include "../include/Config.php";
    
    ?>
<div class="main">


     <?php
     if(isset($_POST['update-quantity'])){
        $updateOrderID = $_POST['orderID'];
        $updateQuantity = $_POST['quantity'];
        $updatePrice = $_POST['updatePrice']*$updateQuantity;
        $productID = $_POST['productID'];
        $sql = "UPDATE `order_line` SET Quantity='$updateQuantity',Price='$updatePrice' WHERE Order_ID='$updateOrderID' AND Product_ID='$productID'";
        mysqli_query($conn,$sql);
    }
    if(isset($_POST['delete-quantity'])){
        $updateOrderID = $_POST['orderID'];
        $productID = $_POST['productID'];
        $sql = "DELETE FROM `order_line` WHERE Order_ID='$updateOrderID' AND Product_ID='$productID'";
        mysqli_query($conn,$sql);
    }
            if(isset($_POST['submit-edit'])){
                
                $orderID=$_POST['orderID'];
                $name=$_POST['customer-name'];
                $phone=$_POST['phone'];
                $address=$_POST['address'];
                $note=$_POST['note'];
                $sql = "UPDATE `order` SET Customer_Name='$name',Phone='$phone',cusAddress='$address',Note='$note' WHERE Order_ID = '$orderID'";
                mysqli_query($conn,$sql);
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
                if($num_rows>0){
                    $sql = "UPDATE `order_line` SET Quantity = Quantity+$quantity,Price='$price' WHERE Order_ID='$orderID' AND Product_ID='$proID' ";
                    mysqli_query($conn,$sql);
                }else{
                    $sql = "INSERT INTO `order_line` VALUES ('$orderID','$proID','$quantity','$price')";
                mysqli_query($conn,$sql);
                }
            }
                if(isset($_GET['edit-order'])){
                    $orderID = $_GET['edit-order'];
                    $sql = "SELECT * FROM `order` WHERE Order_ID = '$orderID'";
                    $result = mysqli_query($conn,$sql);
                    $row = mysqli_fetch_assoc($result);
                    
                    
            ?>
            
            <div class="check-out-form">
            <a href='order-list.php'>Back</a>
            <form action="edit_order.php?edit-order=<?php echo $orderID; ?>" method="post">
                <table>
                    <tr>
                        <td>Customer name</td>
                        <td><input type="text" name="customer-name" id="" placeholder="Full Name" value="<?php echo $row['Customer_Name']; ?>" required></td>
                    </tr>
                    <tr>
                        <td>Phone</td>
                        <td><input type="tel" name="phone" id="" placeholder="Phone" value="<?php echo $row['Phone']; ?>" required></td>
                    </tr>
                    <tr>
                        <td>Address</td>
                        <td><textarea name="address" id="" placeholder="Address" value="" required><?php echo $row['cusAddress']; ?></textarea></td>
                    </tr>
                    <tr>
                        <td>Note</td>
                        <td><textarea name="note" id="" placeholder="Note" value="" ><?php echo $row['Note']; ?></textarea></td>
                    </tr>
                </table>
                <input type="hidden" name="orderID" value="<?php echo $orderID; ?>">
                <button type="submit" name="submit-edit">Edit</button>
            </form>
            </div>
            <div class="checkout-all-product-container">
            
                <?php
                $sql = "SELECT *,p.Price AS productPrice,p.Quantity AS productQuantity,ol.Quantity AS orderQuantity,ol.Price AS orderPrice FROM `order_line` AS ol INNER JOIN `product` AS p ON ol.Product_ID = p.Watch_ID WHERE ol.Order_ID ='$orderID'";
                $result = mysqli_query($conn,$sql);
                while($row=mysqli_fetch_assoc($result)){ 
                ?>        
                          <form method="POST" action="edit_order.php?edit-order=<?php echo $orderID; ?>">
                          <div class="checkout-product-container">
                          <?php echo '<img id="checkout-img" src="'.$row['picture'].'" alt="Watch Image">' ?>
                          <div class="checkout-product-info">
                          <?php echo '<span>'.$row['Watch_Name'].'</span><br>'?>
                          <input type="hidden" name="updatePrice" value="<?php echo $row['productPrice'] ?>">
                          <input type="hidden" name="orderID" value="<?php echo $orderID ?>">
                          <input type="hidden" name="productID" value="<?php echo $row['Watch_ID'] ?>">
                          <span> Quantity: <input type="number" name="quantity" id="order-quantity-input" value="<?php echo $row['orderQuantity'] ?>" min="1" max = "<?php echo $row['productQuantity'] ?>"></span>
                          <button name="update-quantity" type="submit" >update</button>
                          <button name="delete-quantity" type="submit" >delete</button>
                          <span id="checkout-price">Price: <?php echo $row['orderPrice'] ?>$</span>
                          </div>
                          </div>
                          </form>
                <?php 
                      
                }
            echo '<p>Add new product:</p>
            <form method="POST" action="edit_order.php?edit-order='.$orderID.'">
            <input type="hidden" name="orderID" value="'.$orderID.'">
            <input type="text" name="add_pro_id" id="" placeholder="enter product id">
            <input type="number" name="add_pro_quantity" id="" placeholder="enter quantity">
            <button name="add_product" type="submit" >Add</button>
            </form>
            ';
            }
    ?>
            </div>
        <?php }else {
        echo '<meta http-equiv="refresh" content="0;url=admin.php">';
    } ?>
</body>
</html>