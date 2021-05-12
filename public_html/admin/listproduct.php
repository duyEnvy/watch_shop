<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prodcut list</title>
    <link rel="stylesheet" href="../assets/css/admin-style.css?ver=<?= rand(1, 100000) ?>">
    <script src="main.js" type="text/javascript" charset="utf-8" async defer></script>
</head>
<body>
<?php
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    include "sidebar.php";
    ?>
    <div class="main">

    <?php
    include "../include/Config.php";
    
    if(isset($_POST['delete-product'])){
        $productID = $_POST['delete-product'];
        $sql = "DELETE FROM `order` WHERE Order_ID IN( SELECT Order_ID FROM order_line WHERE Product_ID = '$productID' )";
        $result = mysqli_query($conn,$sql);
        $sql = "DELETE FROM product WHERE Watch_ID = '$productID' ";
        $result = mysqli_query($conn,$sql);
    }
    if(isset($_POST['edit-product'])){
        $productID = $_POST['edit-product'];
        $sql = "SELECT * FROM product WHERE Watch_ID = '$productID' ";
        $result = mysqli_query($conn,$sql);
        $row = mysqli_fetch_assoc($result);
    
    ?>
<div id = "edit-product-form">
      <form method="post" >
      
        <table id="edit-table"  >
            <tr>
                <input type="hidden" name = "watch-id" value="<?php echo $_POST['edit-product'];?>" >
                <td id = "edit-tag"><p>Watch Name:</p></td>
                <td>
                    <input type="text" name="watch_name" id="" value="<?php echo $row['Watch_Name'];?>">
                </td>
            </tr>
            <tr>
                <td id = "edit-tag"><p>Brand:</p></td>
                <td>
                    <input type="text" name="brand" id="" value="<?php echo $row['Brand'];?>">
                </td>
            </tr>
            <tr>
                <td id = "edit-tag"><p>Machine_Type:</p></td>
                <td>
                    <input type="text" name="machine_type" id="" value="<?php echo $row['Machine_Type'];?>">
                </td>
            </tr>
            <tr>
                <td id = "edit-tag"><p>Size:</p></td>
                <td>
                    <input type="text" name="size" id="" value="<?php echo $row['Size'];?>">
                </td>
            </tr>
            <tr>
                <td id = "edit-tag">Case_Type:<p></p></td>
                <td>
                    <input type="text" name="case_type" id="" value="<?php echo $row['Case_Type'];?>">
                </td>
            </tr>
            <var> <tr>
                <td id = "edit-tag">Strap:<p></p></td>
                <td>
                    <input type="text" name="strap" id="" value="<?php echo $row['Strap'];?>">
                </td>
            </tr>
            <tr>
                <td id = "edit-tag"><p>Glass:</p></td>
                <td>
                    <input type="text" name="glass" id="" value="<?php echo $row['Glass'];?>">
                </td>
            </tr>
            <tr>
                <td id = "edit-tag"><p>Water Resistance:</p></td>
                <td>
                    <input type="text" name="water_resistence" id="" value="<?php echo $row['Water_Resistance'];?>">
                </td>
            </tr>
            <tr>
                <td id = "edit-tag"><p>Other:</p></td>
                <td>
                    <input type="text" name="other" id="" value="<?php echo $row['Other'];?>">
                </td>
            </tr>
            <tr>
                <td id = "edit-tag"><p>Assurance:</p></td>
                <td>
                    <input type="text" name="assurance" id="" value="<?php echo $row['Assurance'];?>">
                </td>
            </tr>
            <tr>
                <td id = "edit-tag"><p>Gender:</p></td>
                <td>
                    <select name="gender" id="" value="<?php echo $row['Gender'];?>">
                        <option value="0">Male</option>
                        <option value="1">Female</option>
                        <option value="2">Both</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td id = "edit-tag"><p>Origin:</p></td>
                <td>
                    <input type="text" name="origin" id="" value="<?php echo $row['Origin'];?>">
                </td>
            </tr>
            <tr>
                <td id = "edit-tag"><p>Picture link:</p></td>
                <td>
                    <input type="text" name="picture" id=" " value="<?php echo $row['picture'];?>">
                </td>
            </tr>
            <tr>
                <td id = "edit-tag"><p>Price :</p></td>
                <td>
                    <input type="number" name="price" id="" placeholder="in USD" value="<?php echo $row['Price'];?>">
                </td>
            </tr>
            <tr>
                <td id = "edit-tag"><p>Quantity:</p></td>
                <td>
                    <input type="number" name="quantity" id="" value="<?php echo $row['Quantity'];?>">
                </td>
            </tr>
            <tr>
            <td></td>
            
                <td>
                    <button type="submit" id="edit-product" name="submit-edit" onclick="closeEdit()">Edit product</button><button id="x-icon" onclick="closeEdit()">Cancel</button>
                </td>
            </tr>
        
        </table>
    </form>
    </div>
    <?php
}
?>
    <?php
    include "../include/Config.php";
    if(isset($_POST['submit-edit'])){
        $watchID = $_POST['watch-id'];
        $watchName = $_POST['watch_name'];
        $brand = $_POST['brand'];
        $machineType = $_POST['machine_type'];
        $size = $_POST['size'];
        $caseType = $_POST['case_type'];
        $strap = $_POST['strap'];
        $glass = $_POST['glass'];
        $waterResistence = $_POST['water_resistence'];
        $other = $_POST['other'];
        $assurance = $_POST['assurance'];
        $gender = $_POST['gender'];
        $origin = $_POST['origin'];
        $picture = $_POST['picture'];;
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];
        $sql = 'UPDATE product SET Watch_Name = "'.$watchName.'" , Brand = "'.$brand.'" , Machine_Type = "'.$machineType.'" ,Size = "'.$size.'",Case_Type = "'.$caseType.'",
                Strap = "'.$strap.'",Glass= "'.$glass.'",Water_Resistance = "'.$waterResistence.'",Other = "'.$other.'",Assurance = "'.$assurance.'",Gender = "'.$gender.'",
                Origin = "'.$origin.'",picture = "'.$picture.'",Price = "'.$price.'",Quantity = "'.$quantity.'"
                WHERE Watch_ID = "'.$watchID.'"';
        if(mysqli_query($conn, $sql)){
            echo "edit successfully";
        }else {
            echo $sql;
            echo "edit failed";
        }   
    }
    ?>
<table id="db-table">
            <p>Product list:</p>
            <form method="post">
                <span>search: </span>
                <input type="text" name="Watch_Name" id="" placeholder="enter product name" required>
                <button type="submit" name="submit_search_pro">Enter</button>
            </form>
            <tr id="thProlist" >
                <th onclick="sortTable(0)">ID</th>
                <th onclick="sortTable(1)">Product name</th>
                <th>Image</th>
                <th onclick="sortTable(3)">Quantity</th>
                <th onclick="sortTable(4)">Price</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            <?php
            if(isset($_POST['submit_search_pro'])){
                $name = $_POST['Watch_Name'];
                $result = mysqli_query($conn,"SELECT * FROM product where Watch_Name like'%$name%'");
            }else{
                $result = mysqli_query($conn,"SELECT * FROM product");
            }
            
            while($row = mysqli_fetch_assoc($result)){
                ?>
                <form method='post'>
                <tr>
                    <td><?php echo $row['Watch_ID'] ?></td>
                    <td><?php echo $row['Watch_Name'] ?></td>
                    <td><img src="<?php echo $row['picture'] ?>" width="50px" height="45px"></td>
                    <td><?php echo $row['Quantity'] ?></td>
                    <td><?php echo $row['Price']?></td>
                    <td><button id="editProduct" type="submit" name="edit-product" value="<?php echo $row['Watch_ID'] ?>" onclick="openEdit()" >Edit</button></td>
                    <td><button id="deleteProduct" type="submit" name="delete-product" value="<?php echo $row['Watch_ID']?>" onclick="return confirm('Are you sure?'); " >Delete</button></td>
                </tr>
                <?php
            }
            ?>
        </table>
        <script>
function sortTable(n) {
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById("db-table");
  switching = true;
  //Set the sorting direction to ascending:
  dir = "asc"; 
  /*Make a loop that will continue until
  no switching has been done:*/
  while (switching) {
    //start by saying: no switching is done:
    switching = false;
    rows = table.rows;
    /*Loop through all table rows (except the
    first, which contains table headers):*/
    for (i = 1; i < (rows.length - 1); i++) {
      //start by saying there should be no switching:
      shouldSwitch = false;
      /*Get the two elements you want to compare,
      one from current row and one from the next:*/
      x = rows[i].getElementsByTagName("TD")[n];
      y = rows[i + 1].getElementsByTagName("TD")[n];
      /*check if the two rows should switch place,
      based on the direction, asc or desc:*/
      if (dir == "asc") {
          if(n==4||n==0){
            if (Number(x.innerHTML) < Number(y.innerHTML)) {
  shouldSwitch = true;
  break;
}
          }
        else if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
          //if so, mark as a switch and break the loop:
          shouldSwitch= true;
          break;
        }
      } else if (dir == "desc") {
        if(n==4||n==0){
            if (Number(x.innerHTML) > Number(y.innerHTML)) {
  shouldSwitch = true;
  break;
}}
        else if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
          //if so, mark as a switch and break the loop:
          shouldSwitch = true;
          break;
        }
      }
    }
    if (shouldSwitch) {
      /*If a switch has been marked, make the switch
      and mark that a switch has been done:*/
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      //Each time a switch is done, increase this count by 1:
      switchcount ++;      
    } else {
      /*If no switching has been done AND the direction is "asc",
      set the direction to "desc" and run the while loop again.*/
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }
}
</script>
    </div>


        <?php }else {
        echo '<meta http-equiv="refresh" content="0;url=admin.php">';
    } ?>
    
</body>
</html>