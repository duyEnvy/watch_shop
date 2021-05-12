<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check out</title>
    <link rel="stylesheet" href="assets/css/style.css?ver=<?= rand(1, 100000) ?>">
</head>
<body>
    <?php 
        include "include/Config.php";
        include "header.php";
    ?>
    <?php
    
    ?>
    <?php
        if(isset($_POST['buy'])){
            $fullName = $_POST['customer-name'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            $note = $_POST['note'];
            $quantity = $_POST['quantity'];
            $id = $_POST['id'];
            $price = $_POST['price'];
            $totalPrice = $price*$quantity;
            $sql = "INSERT INTO `order` (Customer_Name,Phone,cusAddress,Note,Status,Cur_Date) 
            VALUES ('$fullName','$phone','$address','$note',0,curdate())";
            if(mysqli_query($conn, $sql)){
                $result = mysqli_query($conn, 'select max(Order_ID) as curentOrder from `order`');
                $row = mysqli_fetch_assoc($result);
                $curentOrder = $row['curentOrder'];
                $sql = "INSERT INTO `order_line` (Order_ID,Product_ID,Quantity,Price) 
                VALUES ('$curentOrder','$id','$quantity','$totalPrice')";
                if(mysqli_query($conn, $sql)){
                    ?>
                        <div class="alert">
                        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                        order successfully!
                        </div>
                    <script>
                        function createCookie(name, value, days) {
    var expires;
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toGMTString();
    }
    else {
        expires = "";
    }
    document.cookie = name + "=" + value + expires + "; path=/";
}

function getCookie(c_name) {
    if (document.cookie.length > 0) {
        c_start = document.cookie.indexOf(c_name + "=");
        if (c_start != -1) {
            c_start = c_start + c_name.length + 1;
            c_end = document.cookie.indexOf(";", c_start);
            if (c_end == -1) {
                c_end = document.cookie.length;
            }
            return unescape(document.cookie.substring(c_start, c_end));
        }
    }
    return "";
}
                    var orderID = [];
                    if(getCookie('orderID')){
                        var retrievedData = getCookie("orderID");
                        var previousOrderArr = JSON.parse(retrievedData);
                        let i = 0;
                        previousOrderArr.forEach(function(entry) {
                        orderID[i] = entry;
                        i++;
                    });
                    }
                    orderID.push("<?php echo $curentOrder;  ?>");
                    createCookie('orderID', JSON.stringify(orderID),30);
                    </script>
                    <?php

                }else {
                    ?>
                        <div class="alert">
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
  order failed!
</div>
                    <?php
            }
                
            }else {
                ?>
                        <div class="alert">
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
  order failed!
</div>
                    <?php
            }
        }
        if(isset($_POST['buyCart'])){
            $fullName = $_POST['customer-name'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            $note = $_POST['note'];
            $sql = "INSERT INTO `order` (Customer_Name,Phone,cusAddress,Note,Status,Cur_Date) 
            VALUES ('$fullName','$phone','$address','$note',0,curdate())";
            $curentOrder = 0;
            if(mysqli_query($conn, $sql)){
                $result = mysqli_query($conn, 'select max(Order_ID) as curentOrder from `order`');
                $row = mysqli_fetch_assoc($result);
                $curentOrder = $row['curentOrder'];
                $sql = "INSERT INTO `order_line` (Order_ID,Product_ID,Quantity,Price) 
                VALUES ";
                foreach($_SESSION['cart'] as $uinfos){
                    $id = $uinfos['id'];
                    $quantity = $uinfos['quantity'];
                    $price = $uinfos['price']*$quantity;
                    $sql .= "('$curentOrder','$id','$quantity','$price'),";
                }
                $sql = substr($sql, 0, -1);
                
                if(mysqli_query($conn, $sql)){
                    ?>
                        <div class="alert">
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
  order successfully!
</div>
<script>
                    function createCookie(name, value, days) {
    var expires;
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        
        expires = "; expires=" + date.toGMTString();
    }
    else {
        expires = "";
    }
    document.cookie = name + "=" + value + expires + "; path=/";
}

function getCookie(c_name) {
    if (document.cookie.length > 0) {
        c_start = document.cookie.indexOf(c_name + "=");
        if (c_start != -1) {
            c_start = c_start + c_name.length + 1;
            c_end = document.cookie.indexOf(";", c_start);
            if (c_end == -1) {
                c_end = document.cookie.length;
            }
            return unescape(document.cookie.substring(c_start, c_end));
        }
    }
    return "";
}
                    var orderID = [];
                    if(getCookie('orderID')){
                        var retrievedData = getCookie("orderID");
                        var previousOrderArr = JSON.parse(retrievedData);
                        let i = 0;
                        previousOrderArr.forEach(function(entry) {
                        
                        orderID[i] = entry;
                        i++;
                    });
                    }
                    orderID.push("<?php echo $curentOrder;  ?>");
                    createCookie('orderID', JSON.stringify(orderID),30);
                    </script>
                    <?php
                    session_destroy();
                }else {
                    ?>
                    <div class="alert">
<span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
order failed!
</div>
                <?php
            }
                
            }else {
                ?>
                        <div class="alert">
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
  order failed!
</div>
                    <?php
            }
        }
    
    ?>
    <div class="check-out-form">
    <form action="" method="post">
        <table>
            <h2>Enter your information :</h2>
            <tr>
                <td><input type="text" name="customer-name" id="" placeholder="Full Name" required></td>
            </tr>
            <tr>
                <td><input type="tel" name="phone" id="" placeholder="Phone" required></td>
            </tr>
            <tr>
                <td><textarea name="address" id="" placeholder="Address" required></textarea></td>
            </tr>
            <tr>
                <td><textarea name="note" id="" placeholder="Note" ></textarea></td>
            </tr>
        </table>
    </div>
    <?php 
          include "include/Config.php";
          if(isset($_POST['buy-detail'])){
            $id=intval($_POST['buy-detail']);
            $sql="SELECT * FROM product WHERE Watch_ID ='$id'";
            $query=mysqli_query($conn,$sql);
            $row=mysqli_fetch_array($query);
            echo '<div class="checkout-all-product-container">';
            echo '<div class="checkout-product-container">'; 
            echo '<img id="checkout-img" src="'.$row['picture'].'" alt="Watch Image">';
            echo '<div class="checkout-product-info">';
            echo '<span>'.$row['Watch_Name'].'</span><br>';
            echo '<input type="number" name="quantity" id="quantity-input" value="'.$_POST['quantity-detail'].'" min="1" max="'.$row['Quantity'].'" onchange="myFunction()">';
            echo '<input type="hidden" name="id" value="'.$row['Watch_ID'].'">';
            echo '<input type="hidden" name="price" value="'.$row['Price'].'">';
            echo '<span id="checkout-price">Price:'.$row['Price']*$_POST['quantity-detail'].'$</span>';
            echo '</div>
                    </div>';
            echo        '</div>
                    <div class="checkout-total">
                                  <p id="total-price">TOTAL PRICE: '.$row['Price'].'$</p>
                                  <button id="check-out" type="submit" name="buy">Order</button> 
                    </div>';
                    ?>
                    <script>
                        const eachPrice = document.querySelector('#checkout-price');
                        const totalPrice = document.querySelector('#total-price');
                        function myFunction() {
                            var x = document.getElementById("quantity-input");
                            x.value = x.value.toUpperCase();
                            eachPrice.textContent = 'Price :'+ x.value*(<?php echo $row['Price'] ?>) + '$';
                            totalPrice.textContent = 'TOTAL PRICE: '+ x.value*(<?php echo $row['Price'] ?>) + '$';
                        }

</script>
                    <?php
          }
          elseif(isset($_POST['buy-home'])){
            $id=intval($_POST['buy-home']);
            $sql="SELECT * FROM product WHERE Watch_ID ='$id'";
            $query=mysqli_query($conn,$sql);
            $row=mysqli_fetch_array($query);
            echo '<div class="checkout-all-product-container">';
            echo '<div class="checkout-product-container">'; 
            echo '<img id="checkout-img" src="'.$row['picture'].'" alt="Watch Image">';
            echo '<div class="checkout-product-info">';
            echo '<span>'.$row['Watch_Name'].'</span><br>';
            echo '<input type="number" id="quantity-input" name="quantity" value="1" min="1" max="'.$row['Quantity'].'" onchange="myFunction()">';
            echo '<input type="hidden" name="id" value="'.$row['Watch_ID'].'">';
            echo '<input type="hidden" name="price" value="'.$row['Price'].'">';
            echo '<span id="checkout-price">Price:'.$row['Price'].'$</span>';
            echo '</div>
                    </div>';
            echo        '</div>
                    <div class="checkout-total">
                                  <p id="total-price">TOTAL PRICE: '.$row['Price'].'$</p>
                                  <button id="check-out" type="submit" name="buy">Order</button> 
                    </div>';
                    ?>
                    <script>
                        const eachPrice = document.querySelector('#checkout-price');
                        const totalPrice = document.querySelector('#total-price');
                        function myFunction() {
                            var x = document.getElementById("quantity-input");
                            x.value = x.value.toUpperCase();
                            eachPrice.textContent = 'Price :'+ x.value*(<?php echo $row['Price'] ?>) + '$';
                            totalPrice.textContent = 'TOTAL PRICE: '+ x.value*(<?php echo $row['Price'] ?>) + '$';
                        }

</script>
                    <?php
          }
          elseif(isset($_SESSION['cart'])){
              if(count($_SESSION['cart'])>0){
                                $sql ='';
                                foreach($_SESSION['cart'] as $id => $value) { 
                                    $sql.=$id.",";
                                    $quantity += $_SESSION['cart'][$id]['quantity'];
                                } 
                                $sql=substr($sql, 0, -1);
                                $sql=substr($sql, 0);
                                $sql="SELECT * FROM product WHERE Watch_ID IN ($sql) ORDER BY Watch_Name ASC";
                $query=mysqli_query($conn,$sql); 
                $totalprice=0;
                echo '<div class="checkout-all-product-container">'; 
                while($row=mysqli_fetch_array($query)){ 
                    $subtotal=floatval($_SESSION['cart'][$row['Watch_ID']]['quantity'])*floatval($row['Price']); 
                    $totalprice+=$subtotal; 
                ?>        
                          
                          <div class="checkout-product-container">
                          <?php echo '<img id="checkout-img" src="'.$row['picture'].'" alt="Watch Image">' ?>
                          <div class="checkout-product-info">
                          <?php echo '<span>'.$row['Watch_Name'].'</span><br>'?>
                          <span> Quantity:  <?php echo $_SESSION['cart'][$row['Watch_ID']]['quantity'] ?></span>
                          <span id="checkout-price">Price: <?php echo floatval($row['Price'])*floatval($_SESSION['cart'][$row['Watch_ID']]['quantity']) ?>$</span>
                          <input type="hidden" name="id" value="<?php echo $row['Watch_ID'] ?>">
                          </div>
                          </div>
                <?php 
                      
                } 
    ?>
    </div>
      <div class="checkout-total">
                    <p>TOTAL PRICE: <?php echo $totalprice.'$' ?></p>
                    <button id="check-out" type="submit" name="buyCart">Order</button> 
      </div>

    
<br /> 
<br />
<?php

              }
              else {
                echo '<h3 id="cart-empty">Your cart is empty</h3>';
            }
              
                  
}else {
    echo '<h3 id="cart-empty">Your cart is empty</h3>';
}
?>
</form>
</body>
</html>