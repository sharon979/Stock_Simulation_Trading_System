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
        $stock=$_GET['num'];
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
        $sql1="SELECT howmany FROM successful WHERE stocknum='$stock' ";
        $result1 = mysqli_query($link, $sql1);
        $row2 = mysqli_fetch_assoc($result1);
        echo "持有張數：".$row2["howmany"]."</br>";
        $have=$row2["howmany"];
    ?>
    <form action="" method="POST">
        <h4>請輸入張數：</h4><input type="text" style="font-size:20px" id="howmany" name="howmany" placeholder="數量" required>
        <input type="submit" style="font-size:20px" id="buy" value="售出">
    </form>
    <?php
        $howmany=$_POST["howmany"];
        if(($howmany!=0)&&($howmany<=$have)){
            $link = @mysqli_connect( 
                "127.0.0.1",  // MySQL主機名稱 
                "root",       // 使用者名稱 
                "sharonwang",  // 密碼 
                "stockproject");  // 預設使用的資料庫名稱 
                $SQLCreate="INSERT into wantsell(buyer,stocknum,stockprice,howmany) VALUES('$nowaccount','$stocknum','$price','$howmany')";
                mysqli_query($link, $SQLCreate); 
            echo "<script>alert('下單成功，結果會在0:00a.m更新');</script>";
            $now=$howmany-$have;
        }
        
    ?>
    <a href="home.php?account=<?=$nowaccount?>"><button>回首頁</button></a>
    <?php
        
        //設定時間區為台北
        $today = new DateTime('NOW', new DateTimeZone('Asia/Taipei'));
        echo $today->format('H:i:s');
        $time=$today->format('H:i:s');
        /*while($time!='15:30:00'){
            echo "還沒啦"."</br>";
            sleep(5);
        }
        */
        /*$cost=5;
        while(intval($cost)>=2){
            echo "還沒啦"."</br>";
            sleep(5);
            $cost--;
        }
        echo "到了";
       */
    ?>

</body>
</html>