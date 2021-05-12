<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/admin-style.css?ver=<?= rand(1, 100000) ?>">
    <title>Order list</title>
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
            <form method="post">
                <span>search: </span>
                <input type="text" name="Customer_Name" id="" placeholder="enter customer name" required>
                <button type="submit" name="submit_search_order">Enter</button>
            </form>
            <tr >
                <th onclick="sortTable(0)">ID</th>
                <th onclick="sortTable(1)">Customer name</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Note</th>
                <th onclick="sortTable(5)">Status</th>
                <th onclick="sortTable(6)">Total price</th>
                <th onclick="sortTable(7)">Date</th>
                <th>Detail</th>
                <th>Delete</th>
            </tr>
            <?php
            if(isset($_POST['submit_search_order'])){
                $name = $_POST['Customer_Name'];
                $result = mysqli_query($conn,"SELECT *,SUM(Price) AS Sum_Price FROM `order` AS o INNER JOIN `order_line` AS ol ON o.Order_ID = ol.Order_ID where Customer_Name like'%$name%' GROUP BY ol.Order_ID ");
            }else{
            $result = mysqli_query($conn,"SELECT *,SUM(Price) AS Sum_Price FROM `order` AS o INNER JOIN `order_line` AS ol ON o.Order_ID = ol.Order_ID GROUP BY ol.Order_ID");
            }
            if($result){
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
                        
                        echo '<td>'.$row['Sum_Price'].'</td>';
                        echo '<td>'.$row['Cur_Date'].'</td>';
                        echo '<td><button id="editProduct"><a href="detail_order.php?id=' . $row['Order_ID'] . '">Detail</a></button></td>';
                        echo "<form method='post'>";
                        ?>
                        <td><button id="deleteProduct" type="submit" name="delete-order" value='<?php echo $row['Order_ID'] ?>' onclick="return confirm('Are you sure?'); " >Delete</button></td>
                        <?php
                        echo "</form>";
                        echo "</tr>";
                }
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
          if(n==6||n==0){
            if (Number(x.innerHTML) < Number(y.innerHTML)) {
  shouldSwitch = true;
  break;
}
          }else if(n==7){
            if (Date.parse(x.innerHTML) < Date.parse(y.innerHTML)) {
  shouldSwitch = true;
  break;
}}
        else if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
          //if so, mark as a switch and break the loop:
          shouldSwitch= true;
          break;
        }
      } else if (dir == "desc") {
        if(n==6||n==0){
            if (Number(x.innerHTML) > Number(y.innerHTML)) {
  shouldSwitch = true;
  break;
}}else if(n==7){
            if (Date.parse(x.innerHTML) > Date.parse(y.innerHTML)) {
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


    </div>
        <?php }else {
        echo '<meta http-equiv="refresh" content="0;url=admin.php">';
    } ?>
</body>
</html>