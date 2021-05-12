<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Overwatch</title>
    <link rel="stylesheet" href="assets/css/style.css?ver=<?= rand(1, 100000) ?>">
    <script src="assets/js/main.js"></script>
</head>

<body>
    <?php
    include "header.php";
    ?>
    <!--
    
    -->
    <?php
    $sql = ""; 
    include "include/Config.php";
    if(isset($_POST['add-to-cart'])){ 
        
        $id=intval($_POST['add-to-cart']); 
          
        if(isset($_SESSION['cart'][$id])){ 
            
            $_SESSION['cart'][$id]['quantity']++; 
              
        }else{ 
              
            $sql_s="SELECT * FROM product 
                WHERE Watch_ID='$id'"; 
            $query_s=mysqli_query($conn,$sql_s);
            $rowcount=mysqli_num_rows($query_s);
            if($rowcount!=0){ 
                $row_s=mysqli_fetch_array($query_s); 
                  
                $_SESSION['cart'][$row_s['Watch_ID']]=array(
                        "id" =>  $row_s['Watch_ID'], 
                        "quantity" => 1, 
                        "price" => $row_s['Price'] 
                    ); 
                  
                  
            }else{ 
                  
                $message="This product id it's invalid!"; 
                  
            } 
              
        } 
          
    } 
?>
    <?php 
    if(isset($message)){ 
        echo "<h2>$message</h2>"; 
    } 
?>
    <ul id="filter" style="list-style-type: none;">
        <form action="" method="GET">
            <h2>FILTER BY :</h2>
            <h3>PRICE</h3>
            <li><input type="radio" name="filter-price" value="499" id="">
                < 499$</li> <li><input type="radio" name="filter-price" value="999" id=""> 500$-999$
            </li>
            <li><input type="radio" name="filter-price" value="1000" id=""> > 1000$</li>
            <h3>MACHINE TYPE</h3>
            <?php
                $query = "select Machine_Type from product group by Machine_Type";
                $result = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo    '<li><input type="checkbox" name="filter-machine-type[]" value="'.$row['Machine_Type'].'" id="">'.$row['Machine_Type'].'</li>';
                }
            ?>
            <h3>GLASS</h3>
            <?php
                $query = "select Glass from product group by Glass ";
                $result = mysqli_query($conn,$query);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo    '<li><input type="checkbox" name="filter-glass[]" value="'.$row['Glass'].'" id="">'.$row['Glass'].'</li>';
                }
            ?>
            <h3>STRAP</h3>
            <?php
                $query = "select Strap from product group by Strap";
                $result = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo    '<li><input type="checkbox" name="filter-strap[]" value="'.$row['Strap'].'" id="">'.$row['Strap'].'</li>';
                }
            ?>
            <h3>BRAND</h3>
            <?php
                $query = "select Brand from product group by Brand";
                $result = mysqli_query($conn,$query);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo    '<li><input type="checkbox" name="filter-brand[]" value="'.$row['Brand'].'" id="">'.$row['Brand'].'</li>';
                }
            ?>
            <h3>GENDER</h3>
            <li><input type="checkbox" name="filter-gender[]" value="1" id="">MAN</li>
            <li><input type="checkbox" name="filter-gender[]" value="0" id="">WOMAN</li>
            <li><input type="checkbox" name="filter-gender[]" value="2" id="">BOTH</li>
            <button type="submit" name="filter-button">FILTER</button>
        </form>
    </ul>


    <?php
    
    
    include "include/Config.php";


    if (isset($_GET['search'])) {
        $searchValue = $_GET['searchValue'];
        if (empty($searchValue)) {
        } else {
            $GLOBALS['sql'] = "select * from product where Watch_Name like'%$searchValue%'";
            displayWatch($conn,$GLOBALS['sql']);
        }
    }  elseif (isset($_GET['filter-button'])) {
        $GLOBALS['sql'] = "select * from product where ";
                if(isset($_GET['filter-machine-type'])){
                    $filterMachineType = $_GET['filter-machine-type'];
                    foreach ($filterMachineType as $value){
                        if($GLOBALS['sql']=="select * from product where "){
                            $GLOBALS['sql'].= "(Machine_Type='$value' ";
                        }
                        elseif(strpos($GLOBALS['sql'],'Machine_Type')){
                            $GLOBALS['sql'].= "or Machine_Type='$value' ";
                        }
                        else {
                            $GLOBALS['sql'].= "and (Machine_Type='$value' ";
                        }
                    }
                    $GLOBALS['sql'].=")";
                }
                if(isset($_GET['filter-glass'])){
                    $filterGlass = $_GET['filter-glass'];
                    foreach ($filterGlass as $value){
                        if($GLOBALS['sql']=="select * from product where "){
                            $GLOBALS['sql'].= "(Glass='$value' ";
                        }
                        elseif(strpos($GLOBALS['sql'],'Glass')){
                            $GLOBALS['sql'].= "or Glass='$value' ";
                        }
                        else {
                            $GLOBALS['sql'].= "and (Glass='$value' ";
                        }
                    }
                    $GLOBALS['sql'].=")";
                    
                }
                if(isset($_GET['filter-brand'])){
                    $filterBrand = $_GET['filter-brand'];
                    foreach ($filterBrand as $value){
                        if($GLOBALS['sql']=="select * from product where "){
                            $GLOBALS['sql'].= "(Brand='$value' ";
                        }
                        elseif(strpos($GLOBALS['sql'],'Brand')){
                            $GLOBALS['sql'].= "or Brand='$value' ";
                        }
                        else {
                            $GLOBALS['sql'].= "and (Brand='$value' ";
                        }
                    }
                    $GLOBALS['sql'].=")";
                    
                    
                }
                if(isset($_GET['filter-strap'])){
                    $filterStrap = $_GET['filter-strap'];
                    foreach ($filterStrap as $value){
                        if($GLOBALS['sql']=="select * from product where "){
                            $GLOBALS['sql'].= "(Strap='$value' ";
                        }
                        elseif(strpos($GLOBALS['sql'],'Strap')){
                            $GLOBALS['sql'].= "or Strap='$value' ";
                        }
                        else {
                            $GLOBALS['sql'].= "and (Strap='$value' ";
                        }
                    }
                    $GLOBALS['sql'].=")";
                    
                    
                }
                if(isset($_GET['filter-gender'])){
                    $filterGender = $_GET['filter-gender'];
                    foreach ($filterGender as $value){
                        if($GLOBALS['sql']=="select * from product where "){
                            $GLOBALS['sql'].= "(Gender='$value' ";
                        }
                        elseif(strpos($GLOBALS['sql'],'Gender')){
                            $GLOBALS['sql'].= "or Gender='$value' ";
                        }
                        else {
                            $GLOBALS['sql'].= "and (Gender='$value' ";
                        }
                    }
                    $GLOBALS['sql'].=")";
                    
                }
                if(isset($_GET['filter-price'])){
                     $filterPrice = $_GET['filter-price'];
                    switch($filterPrice){
                        case 499:
                            if($GLOBALS['sql']=="select * from product where "){
                                $GLOBALS['sql'].= "Price < 499 ";
                            }else {
                                $GLOBALS['sql'].= "and Price < 499 ";
                            }
                            
                            break;
                        case 999:
                            if($GLOBALS['sql']=="select * from product where "){
                                $GLOBALS['sql'].= "Price >=500 and Price < 999  ";
                            }else {
                                $GLOBALS['sql'].= "and Price >=500 and Price < 999  ";
                            }
                            break;
                        case 1000:
                            if($GLOBALS['sql']=="select * from product where "){
                                $GLOBALS['sql'].= "Price >=1000 ";
                            }else {
                                $GLOBALS['sql'].= "and Price >=1000 ";
                            }
                            
                            break;
                        }
                }
                
        displayWatch($conn,$GLOBALS['sql']);
    } elseif (isset($_GET['brand'])) {
        $brand = $_GET['brand'];
        $sql = "select * from product where Brand='$brand'";
        displayWatch($conn,$sql);
    }elseif (isset($_GET['brand-man'])) {
        $brand = $_GET['brand-man'];
        $GLOBALS['sql'] = "select * from product where Brand='$brand' and Gender=1 ";
        displayWatch($conn,$GLOBALS['sql']);
    }elseif (isset($_GET['brand-woman'])) {
        $brand = $_GET['brand-woman'];
        $GLOBALS['sql'] = "select * from product where Brand='$brand' and Gender=0 ";
    
        displayWatch($conn,$GLOBALS['sql']);
    }
    elseif (isset($_GET['gender'])) {
        $gender = $_GET['gender'];
        $GLOBALS['sql'] = "select * from product where Gender='$gender'";
    
        displayWatch($conn,$GLOBALS['sql']);
    } else {
        $GLOBALS['sql'] = "select * from product ";
        displayWatch($conn,$GLOBALS['sql']);
    }
    ?>
    <?php
    function displayWatch($conn,$query){
        
        

        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        if (strpos($actual_link, '?') == false) {
            $actual_link .= "?";
        }
        
        
        $copy_actual_link = $actual_link;
        
        

        // $result = mysqli_query($conn, 'select count(Watch_ID) as total from product');
        // $row = mysqli_fetch_assoc($result);
        // $total_records = $row['total'];
        if(isset($_GET['max'])) {
            $query = $query." ORDER BY Price DESC ";
            
        }
        elseif(isset($_GET['min'])) {
            
            $query = $query." ORDER BY Price ASC ";
            
        }
        
           
        
        echo '<div id="sort">
        <span>Sort by price:</span>';
            if(strpos($actual_link, 'min=')){

                $copy_actual_link = str_replace('min=', '', $actual_link);
                echo '
    <form action="'.$copy_actual_link.'&max=" method="post"  >
    <button type="submit" id="max-button" name="max">Max to Min &darr;</button>
    
    </form>
    ';
            }elseif(strpos($actual_link, 'max=')){
                $copy_actual_link = str_replace('max=', '', $actual_link);
                echo '
    <form action="'.$copy_actual_link.'&min=" method="post"  >
    <button type="submit" id="min-button" name="min">Min to Max &uarr;</button>
    
    </form>';
    

            }else{
                echo '
    <form action="'.$actual_link.'&max=" method="post"  >
    <button type="submit" id="max-button" name="max">Max to Min &darr;</button>
    
    </form>
    <form action="'.$actual_link.'&min=" method="post"  >
    <button type="submit" id= "min-button" name="min">Min to Max &uarr;</button>
    </form>';
            }
            echo '</div>';
            
        
        
        

        $result = mysqli_query($conn, $query);
        $total_records = 0;
        while($row = mysqli_fetch_assoc($result)){
            $total_records++;
        }
        // BƯỚC 3: TÌM LIMIT VÀ CURRENT_PAGE
        $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
        $limit = 10;
        // BƯỚC 4: TÍNH TOÁN TOTAL_PAGE VÀ START
        // tổng số trang
        $total_page = ceil($total_records / $limit);
        // Giới hạn current_page trong khoảng 1 đến total_page
        if ($current_page > $total_page){
            $current_page = $total_page;
        }
        else if ($current_page < 1){
            $current_page = 1;
        }
        // Tìm Start
        $start = ($current_page - 1) * $limit;
        // BƯỚC 5: TRUY VẤN LẤY DANH SÁCH TIN TỨC
        // Có limit và start rồi thì truy vấn CSDL lấy danh sách tin tức
        $query = $query.'LIMIT '. $start.','.$limit;
        $result = mysqli_query($conn, $query);
       ?>
            <?php 
            // PHẦN HIỂN THỊ TIN TỨC
            // BƯỚC 6: HIỂN THỊ DANH SÁCH TIN TỨC
            echo    '<div id ="watch-display">';
            if($result){

            
        while ($row = mysqli_fetch_assoc($result)) {
            echo    '<div id ="watch-container">';
            echo    '<img id ="watch-img" src="' . $row['picture'] . '"></a>';
            echo    '<h3 id="watch-name"><a href="product_detail.php?id=' . $row['Watch_ID'] . '">' . $row['Watch_Name'] . '</a></h3>
                        <p>Price : <strong id="price">' . $row['Price'] . ' </strong><strong>$</strong>  </p>
                        
                        <form method="post" style="display:inline-block;"><button class="add-to-cart-button" value="' . $row['Watch_ID'] . '" name="add-to-cart" >Add to cart</button></form>
                        <form method="post" action="check_out.php"><button class="buy-button" name="buy-home" type="submit" value="'.$row['Watch_ID'].'" >Buy</button></form>';
            echo    '<input type="hidden" name="watch-id" value="' . $row['Watch_ID'] . '" />';
            echo    '</div>';
        }
        
    }else {
        echo '<div class="notify_content">
          No product found!
        </div>';
    }
    echo    '</div>';
            ?>
        <div class="pagination"  >
           <?php 
            if ($current_page > 1 && $total_page > 1){
                echo '<a href="'.$actual_link.'&page='.($current_page-1).'">&lt;</a>  ';
            }
            for ($i = 1; $i <= $total_page; $i++){
                if ($i == $current_page){
                    echo '<a id="currentpage" href="'.$actual_link.'&page='.$i.'">'.$i.'</a>  ';
                }
                else{
                    echo '<a href="'.$actual_link.'&page='.$i.'">'.$i.'</a>  ';
                }
            }
            if ($current_page < $total_page && $total_page > 1){
                echo '<a href="'.$actual_link.'&page='.($current_page+1).'">&gt;</a>  ';
            }}
           ?>
        </div>
</body>
</html>