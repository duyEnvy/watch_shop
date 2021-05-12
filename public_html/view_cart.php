<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="assets/css/style.css?ver=<?= rand(1, 100000) ?>">
</head>
<body>

<?php
    if(isset($_POST['delete'])){
        $id = $_POST['id'];
        unset($_SESSION['cart'][$id]);
    }

    if(isset($_POST['update-cart'])){
        $quantity = $_POST['quantityInput'];
        $id = $_POST['id'];
        
        if(isset($_SESSION['cart'][$id])){
            if($quantity==0){
                unset($_SESSION['cart'][$id]);
            }elseif($quantity>0){
                $_SESSION['cart'][$id]['quantity'] = $quantity;
            }
        }
    }
?>

<?php 
  
  if(isset($_POST['submit'])){ 
        
      foreach($_POST['quantity'] as $key => $val) { 
          if($val==0) { 
              unset($_SESSION['cart'][$key]); 
          }else{ 
              $_SESSION['cart'][$key]['quantity']=$val; 
          } 
      } 
        
  } 

?> 
<?php 
  include "header.php";
?>
<div>
<h1 style="display:inline-block; margin-left:40px; padding:10px; border-bottom:1px cyan solid;">CART</h1>
<button class="button-track" style="vertical-align:middle"><a  href="track_order.php">Track orders</a></button>
</div>
<?php
 
?> 

    

        
      <?php 
          include "include/Config.php";
          if(isset($_SESSION['cart'])){
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
                echo '<div class="cart-all-product-container">'; 
                while($row=mysqli_fetch_array($query)){ 
                    $subtotal=floatval($_SESSION['cart'][$row['Watch_ID']]['quantity'])*floatval($row['Price']); 
                    $totalprice+=$subtotal; 
                ?>        
                          
                          <div class="cart-product-container">
                          <?php echo '<img id="cart-img" src="'.$row['picture'].'" alt="Watch Image">' ?>
                          <div class="cart-product-info">
                          <?php echo '<h2>'.$row['Watch_Name'].'</h2>'?>
                          <form method="post" action="">
                          <p>Quantity: <input type="number" name="quantityInput" value="<?php echo $_SESSION['cart'][$row['Watch_ID']]['quantity'] ?>" min="0" max="<?php echo $row['Quantity'];?>"></p>
                          <p>Price: <?php echo floatval($row['Price'])*floatval($_SESSION['cart'][$row['Watch_ID']]['quantity']) ?>$</p>
                          <input type="hidden" name="id" value="<?php echo $row['Watch_ID'] ?>">
                          <?php echo '<button class="update-cart-button" type="submit" name="update-cart">Update</button>'; ?>
                          <button id="delete-product" type="submit" name="delete" ><span>&#10005;</span></button>
                          </form>
                          </div>
                          </div>
                <?php 
                      
                } 
    ?>
    </div>
      <div class="cart-total">
                    <p>TOTAL PRICE: <?php echo $totalprice.'$' ?></p>
                    <a href="check_out.php"><button id="check-out">CHECK OUT</button> </a>
      </div>

<br /> 


<br />
<?php

              }
              else {
                echo '<h3>Your cart is empty</h3>';
            }
              
                  
}else {
    echo '<h3>Your cart is empty</h3>';
}
?>
</body>
</html>


                        