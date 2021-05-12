<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/admin-style.css?ver=<?= rand(1, 100000) ?>">
    <title>Add new product</title>
</head>
<body>
    
<?php
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    include "sidebar.php";
    ?>
    <div class="main">

    <?php
    include "../include/Config.php";
    ?>
<div id = "edit-product-form">
      <form method="post" >
      
        <table id="edit-table"  >
            <tr>
                <input type="hidden" name = "watch-id"  >
                <td id = "edit-tag"><p>Watch Name:</p></td>
                <td>
                    <input type="text" name="watch_name" id="" >
                </td>
            </tr>
            <tr>
                <td id = "edit-tag"><p>Brand:</p></td>
                <td>
                    <input type="text" name="brand" id="" >
                </td>
            </tr>
            <tr>
                <td id = "edit-tag"><p>Machine_Type:</p></td>
                <td>
                    <input type="text" name="machine_type" id="" >
                </td>
            </tr>
            <tr>
                <td id = "edit-tag"><p>Size:</p></td>
                <td>
                    <input type="text" name="size" id="" >
                </td>
            </tr>
            <tr>
                <td id = "edit-tag">Case_Type:<p></p></td>
                <td>
                    <input type="text" name="case_type" id="">
                </td>
            </tr>
            <var> <tr>
                <td id = "edit-tag">Strap:<p></p></td>
                <td>
                    <input type="text" name="strap" id="" >
                </td>
            </tr>
            <tr>
                <td id = "edit-tag"><p>Glass:</p></td>
                <td>
                    <input type="text" name="glass" id="" >
                </td>
            </tr>
            <tr>
                <td id = "edit-tag"><p>Water Resistance:</p></td>
                <td>
                    <input type="text" name="water_resistence" id="" >
                </td>
            </tr>
            <tr>
                <td id = "edit-tag"><p>Other:</p></td>
                <td>
                    <input type="text" name="other" id="" >
                </td>
            </tr>
            <tr>
                <td id = "edit-tag"><p>Assurance:</p></td>
                <td>
                    <input type="text" name="assurance" id="" >
                </td>
            </tr>
            <tr>
                <td id = "edit-tag"><p>Gender:</p></td>
                <td>
                    <select name="gender" id="" >
                        <option value="0">Male</option>
                        <option value="1">Female</option>
                        <option value="2">Both</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td id = "edit-tag"><p>Origin:</p></td>
                <td>
                    <input type="text" name="origin" id="" ">
                </td>
            </tr>
            <tr>
                <td id = "edit-tag"><p>Picture link:</p></td>
                <td>
                    <input type="text" name="picture" id=" "">
                </td>
            </tr>
            <tr>
                <td id = "edit-tag"><p>Price:</p></td>
                <td>
                    <input type="number" name="price" id="" placeholder="in USD">
                </td>
            </tr>
            <tr>
                <td id = "edit-tag"><p>Quantity:</p></td>
                <td>
                    <input type="number" name="quantity" id="" >
                </td>
            </tr>
            <tr>
            <td></td>
            
                <td>
                    <button type="submit" id="edit-product" name="submit-add" >Add product</button>
                </td>
            </tr>
        
        </table>
    </form>
    </div>
    <?php
    if(isset($_POST['submit-add'])){
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
        $sql = "INSERT INTO product (Watch_Name, Brand, Machine_Type,Size,Case_Type,Strap,Glass,Water_Resistance,Other,Assurance,Gender,Origin,picture,Price,Quantity)
        VALUES ('$watchName','$brand','$machineType' ,'$size','$caseType','$strap','$glass','$waterResistence','$other','$assurance','$gender', '$origin','$picture','$price','$quantity')";
        if(mysqli_query($conn, $sql)){
            echo "add product successfully";
        }else {
            echo $sql;
            echo "add product failed";
        }   
    }}else {
        echo '<meta http-equiv="refresh" content="0;url=admin.php">';
    }
    ?>
</body>
</html>