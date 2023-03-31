<?php
    if( $_SERVER['HTTP_REFERER'] == "" )
    {
    header("Location:".$fromurl); exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>歡迎來到首頁</title>
    <link rel="stylesheet" href="home.css" charset="utf-8">
</head>
<body>
    <div class="warp">
        <div class="header">
            <h1>歡迎來到股票查詢系統</h1>
            <div class="nowuser">歡迎 
                <?php  
               $nowaccount=$_GET['account'];
               //echo $nowaccount;
               
               $link = @mysqli_connect( 
                 "127.0.0.1",  // MySQL主機名稱 
                 "root",       // 使用者名稱 
                 "sharonwang",  // 密碼 
                 "stockproject");  // 預設使用的資料庫名稱 
                 $sql="SELECT username FROM sign WHERE useraccount='$nowaccount' ";
                 $result = mysqli_query($link, $sql);
                 if (!$result) {
                    printf("Error: %s\n", mysqli_error($link));
                    exit();
                }
                 $row = mysqli_fetch_assoc($result);
                 echo "  ".$row['username']; 
            ?>
            </div>
            <a href="user.php?account=<?=$nowaccount?>"><button id="me">個人訂單查詢</button></a>
            <a href="index.php"><button id="out">登出</button></a>
            <div class="information">
                <h3>股票查詢</h3>
                <form action="" method="POST">
                <input type="text" style="font-size:20px" id="stock" name="stock" placeholder="請輸入股票代碼" required>
                <input type="submit" style="font-size:20px" id="input" value="送出">
                </form>
                <?php
                    $stock=$_POST["stock"];
                    $link = @mysqli_connect( 
                        "127.0.0.1",  // MySQL主機名稱 
                        "root",       // 使用者名稱 
                        "sharonwang",  // 密碼 
                        "stockproject");  // 預設使用的資料庫名稱 
                        $sql="SELECT * FROM stock WHERE stocknum='$stock' ";
                        $result = mysqli_query($link, $sql);
                        if (!$result) {
                           printf("Error: %s\n", mysqli_error($link));
                           exit();
                       }
                        $result = mysqli_query($link, $sql);
                        $row = mysqli_fetch_assoc($result);
                        $cname=$row["companyname"];
                        echo "<table width=50% class='table'>";
                        echo"<tr bgcolor='#f5f290'>"."<td>"."編號"."</td>"."<td>"."公司名稱"."</td>"."<td>"."當盤成交價"."</td>"."<td>"."當盤成交量"."</td>"."<td>"."累積成交量"."</td>"."<td>"."開盤"."</td>"."<td>"."最高"."</td>"."<td>"."最低"."</td>"."<td>"."昨收"."</td>"."</tr>";
                        echo"<tr bgcolor=#e0e0e0 style='font-size:18px;border:1px #f0f0f0 solid;border-collapse:collapse;' rules='all' cellpadding='10px';>"."<td>".$row["stocknum"]."</td>"."<td>".$row["companyname"]."</td>"."<td>".$row["trading_price"]."</td>"."<td>".$row["trading_volume"]."</td>"."<td>".$row['volume_accumulation']."</td>"."<td>".$row['o']."</td>"."<td>".$row['high']."</td>"."<td>".$row['low']."</td>"."<td>".$row['yesterday']."</td>"."</tr>";                        
                ?>
            </div>
            <div class="buy">
                <a href='buy.php?stock=<?=$stock?>&account=<?=$nowaccount?>'><button class="buysomething">我要下單</button></a>
                <?php
                    /*
                    $howmany=0;
                    $howmany=$_POST["howmany"];
                    echo $stock;
                    $link = @mysqli_connect( 
                        "127.0.0.1",  // MySQL主機名稱 
                        "root",       // 使用者名稱 
                        "sharonwang",  // 密碼 
                        "stockproject");  // 預設使用的資料庫名稱 
                        $sql="SELECT * FROM stock WHERE stocknum='$stock' ";
                        $result = mysqli_query($link, $sql);
                        if (!$result) {
                           printf("Error: %s\n", mysqli_error($link));
                           exit();
                       }
                        $result = mysqli_query($link, $sql);
                        $row = mysqli_fetch_assoc($result);
                        if (!mysqli_num_rows($result))  
                        {  
                            echo "資料庫中無此股票！";  
                        }  
                        else{
                            echo "<script>alert('送出訂單');</script>";
                        }
                    /*if($stock!=1){
                        echo "<script>alert('送出訂單'.$howmany.'張'.$cname.'股票'); location.href = '';</script>";
                    
                    }
                    */
                    //echo $howmany;
                ?>
            </div>
            
        </div>
        <div class="body">
        </div>
    </div>
</body>
</html>


