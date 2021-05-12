<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/admin-style.css?ver=<?= rand(1, 100000) ?>">
    
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <title>Add new order</title>
</head>
<body>
<div class="main">
<form action="" method="post">
<?php
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    include "sidebar.php";
    include "../include/Config.php";

    if(isset($_POST['submit-add-order'])){
        $fullName = $_POST['customer-name'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $note = $_POST['note'];


        $sql = "INSERT INTO `order` (Customer_Name,Phone,cusAddress,Note,Status,Cur_Date) 
        VALUES ('$fullName','$phone','$address','$note',0,curdate())";
        if(mysqli_query($conn, $sql)){
            $proIDArr = $_POST['add_pro_id'];
            $quantityArr = $_POST['add_pro_quantity'];
            $i = 0;
            $result = mysqli_query($conn, 'select max(Order_ID) as curentOrder from `order`');
            $row = mysqli_fetch_assoc($result);
            $curentOrder = $row['curentOrder'];
            $sql = "INSERT INTO `order_line` (Order_ID,Product_ID,Quantity,Price) 
                VALUES ";
                while($i<count($proIDArr)){
                    $id = $proIDArr[$i];
                    $quantity = $quantityArr[$i];
                    $result = mysqli_query($conn, "SELECT Price FROM `product` WHERE Watch_ID = '$id'");
                    $row = mysqli_fetch_assoc($result);
                    $price = $row['Price']*$quantity;
                    $sql .= "('$curentOrder','$id','$quantity','$price'),";
                    $i++;
                }
                $sql = substr($sql, 0, -1);
                if(mysqli_query($conn, $sql)){
                    echo "<p>create order successfully</p>";
                    session_destroy();
                }else {
                echo "</p>create order failed</p>";
            }

        
    }
}
    ?>
    

            
            <div class="check-out-form">
            <a href='order-list.php'>Back</a>
            
                <table>
                    <tr>
                        <td>Customer name</td>
                        <td><input type="text" name="customer-name" id="" placeholder="Full Name" value="" required></td>
                    </tr>
                    <tr>
                        <td>Phone</td>
                        <td><input type="tel" name="phone" id="" placeholder="Phone" value="" required></td>
                    </tr>
                    <tr>
                        <td>Address</td>
                        <td><textarea name="address" id="" placeholder="Address" value="" required></textarea></td>
                    </tr>
                    <tr>
                        <td>Note</td>
                        <td><textarea name="note" id="" placeholder="Note" value="" ></textarea></td>
                    </tr>
                </table>
                
            </div>
            <div class="checkout-all-product-container">
            <p>Add product:</p>
            <span id="add-input">
            <input type="text" name="add_pro_id[]" id="" placeholder="enter product id">
            <input type="number" name="add_pro_quantity[]" id="" placeholder="enter quantity">
            </span>
            <br>
            <button type="button" id="add">+</button>
            <br>
            <button type="submit" name="submit-add-order">Add order</button>
            
            
            
            </div>
            </div>
            </form>
            <script>
$(document).ready(function(){
	var i=1;
	$('#add').click(function(){
		$('#add-input').append('<br><input type="text" name="add_pro_id[]" id="" placeholder="enter product id"><input type="number" name="add_pro_quantity[]" id="" placeholder="enter quantity">');
	});
	
});
</script>
        <?php }else {
        echo '<meta http-equiv="refresh" content="0;url=admin.php">';
    } ?>
</body>
</html>