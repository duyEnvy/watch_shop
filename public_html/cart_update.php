<?php
 session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<?php

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
    echo '<meta http-equiv="refresh" content="1;url=view_cart.php">';
?>

</body>
</html>
