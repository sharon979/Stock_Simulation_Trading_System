<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="warp">
        <div class="information"></div>
    </div>
    <?php
        $stock=$_GET['stock'];
        $nowaccount=$_GET['account'];
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
        echo "股票代碼：".$row["stocknum"]."</br>";
        echo "公司名稱：".$row["companyname"]."</br>";
        echo "現在價格：".$row["trading_price"]."</br>";     
        $stocknum= $row["stocknum"];
        $price=$row["trading_price"];
    ?>
    <form action="" method="POST">
        <h4>請輸入張數：</h4><input type="text" style="font-size:20px" id="howmany" name="howmany" placeholder="數量" required>
        <input type="submit" style="font-size:20px" id="buy" value="購買">
    </form>
    <?php
        $howmany=$_POST["howmany"];
        if($howmany!=0){
            $link = @mysqli_connect( 
                "127.0.0.1",  // MySQL主機名稱 
                "root",       // 使用者名稱 
                "sharonwang",  // 密碼 
                "stockproject");  // 預設使用的資料庫名稱 
                $SQLCreate="INSERT into wantorder(buyer,stocknum,stockprice,howmany) VALUES('$nowaccount','$stocknum','$price','$howmany')";
                mysqli_query($link, $SQLCreate); 
            echo "<script>alert('下單成功，結果會在0:00a.m更新');</script>";
        }
    ?>
    <a href="home.php?account=<?=$nowaccount?>"><button>回首頁</button></a>
    
</body>
</html>