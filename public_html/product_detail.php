<?php
    session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Overwatch</title>
    <link rel="stylesheet" href="assets/css/style.css?ver=<?=rand(1,100000)?>">
</head>
<body>
    <?php
    include "header.php";
    ?>
    <?php 
     include "include/Config.php";
     $id = $_GET['id'];
     $sql = "select * from product where Watch_ID = '$id' ";
     $result = mysqli_query($conn,$sql);
     $row = mysqli_fetch_assoc($result);
      echo '<div class="upper-detail"><img class="detail-img" src="'.$row['picture'].'">';
      echo '<div class="name-type-size"><p><span id="watch-name-detail">'.$row['Watch_Name'].'</span><br>Machine type: '.$row['Machine_Type'].'<br> Size: '.$row['Size'].'</p><p id = "price-detail">Price: '.$row['Price'].' $</p><p>Available: '.$row['Quantity'].'</p>';
      echo '<form action="check_out.php" method="post">
      <input id ="quantity-detail" type="number" name="quantity-detail" value="1" min="1" max="'.$row['Quantity'].'">
      <button class="buy-button-detail" name="buy-detail" type="submit" value="'.$id.'">BUY NOW</button>

      </form>';
      echo '</div>';
      echo '</div>';
    ?>
    
    <div id="all-detail">
            <div class="detail-info">
            <h3>Product information:</h3>
            <p>Name:
            <?php echo $row['Watch_Name']; ?>
            </p>
            <p>Brand:
            <?php echo $row['Brand']; ?>
            </p>
            
            <p>Gender:
            <?php echo $row['Gender']?"Male":"Female"; ?></p>
            <p>Origin:
            <?php echo $row['Origin']; ?></p>
            <p>Assurance:
            <?php echo $row['Assurance']; ?></p>
            <p>
            Other properties:
            <?php echo $row['Other']; ?>
            </p>
            
            </div>
            <div class="detail-tech">
                <h3>Technical detail:</h3>
                <p>Machine_Type:
            <?php echo $row['Machine_Type']; ?></p>
                <p>Size:
            <?php echo $row['Size']; ?></p>
                <p>Case_Type:
            <?php echo $row['Case_Type']; ?></p>
                <p>Strap:
            <?php echo $row['Strap']; ?></p>
                <p>Glass:
            <?php echo $row['Glass']; ?></p>
                <p>Water Resistance:
            <?php echo $row['Water_Resistance']; ?></p>
        
        
        
        
        
        
            </div>
        
        
        
    </div>
</body>
</html>

