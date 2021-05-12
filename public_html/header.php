

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>OverWatch</title>
    <link rel="stylesheet" href="assets/css/header-style.css?ver=<?=rand(1,100000)?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

   <nav class="navbar navbar-default" role="navigation">
        
            <div class="navbar-header">
                
                <a class="navbar-brand" href="index.php"><img src="assets/img/logo.PNG" height="45px" width="200px"></a>
            </div>
            <div class="search-and-cart">
                    <div class= "cart">
                    <a href="view_cart.php" ><i class="fa" style="font-size:24px">&#xf07a;</i></a>
                        <?php
                        include "include/Config.php";
                            if(isset($_SESSION['cart'])){
                                $quantity=0;
                                foreach($_SESSION['cart'] as $id => $value) {
                                    $quantity += $_SESSION['cart'][$id]['quantity'];
                                } 
                                echo '<span class="badge badge-warning" id="lblCartCount">'.$quantity.'</span>';
                            }else {
                                echo '<span class="badge badge-warning" id="lblCartCount">0</span>';
                            }
                            
                        ?>
                        
                    </div>  
                    
                    <div class="search-container">
                        <form class="navbar-form navbar-right" action="index.php" method="GET">
                        <input type="text" placeholder="Search.." name="searchValue">
                        <button type="submit" name="search"><i class="fa fa-search"></i></button>
                        </form>
                    </div>
                </div>
                
            </div>
            <div class="category">
                <div class="brand-dropdown">

                    <form action="index.php" method="GET">
    
                        <div class="dropdown">
                            <button class="dropbtn" >BRAND <i class="arrow down"></i></button>
                            <div class="dropdown-content">
                            <div class="brand-list">
                                    <ul>
                                        <h4 class = "category">BRAND</h4>
                                        <?php
                                        $query = "select Brand from product group by Brand";
                                        $result = mysqli_query($conn, $query);
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo    '<li><button type="submit" name="brand" value="'.$row['Brand'].'">'.$row['Brand'].'</button></li>';
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
                <div class="watch-for-man">
                    <form action="index.php" method="GET">
                        
                        <div class="dropdown">
                            <button class="dropbtn" type="submit" name="gender" value="1">MAN <i class="arrow down"></i></button>
                            <div class="dropdown-content">
                                <div class="brand-list">
                                    <ul>
                                        <h4 class = "category">BRAND</h4>
                                        <?php
                                        $query = "select Brand from product where Gender=1 group by Brand ";
                                        $result = mysqli_query($conn, $query);
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo    '<li><button type="submit" name="brand-man" value="'.$row['Brand'].'">'.$row['Brand'].'</button></li>';
                                        }
                                        ?>
                                    </ul>
                                </div>
                                  
                            </div>
                        </div>
                    </form>

                </div>
                <div class="watch-for-woman">

                    <form action="index.php" method="GET">
                        
                        <div class="dropdown">
                            <button class="dropbtn" type="submit" name="gender" value="0">WOMAN <i class="arrow down"></i></button>
                            <div class="dropdown-content">
                            <div class="brand-list">
                                    <ul>
                                        <h4 class = "category">BRAND</h4>
                                        <?php
                                        $query = "select Brand from product where Gender=0 group by Brand";
                                        $result = mysqli_query($conn, $query);
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo    '<li><button type="submit" name="brand-woman" value="'.$row['Brand'].'">'.$row['Brand'].'</button></li>';
                                        }
                                        ?>
                                    </ul>
                                </div>
                                
                            </div>
                        </div>
                    </form>

                </div>
                
            </div>
</div>
    </nav>
</body>
</html>