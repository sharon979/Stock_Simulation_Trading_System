<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="success.css" charset="utf-8">
</head>
<body>
    <div class="warp">
        <div class="title">
            <?php
                $nowaccount=$_GET['account'];
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
                echo "歡迎".$row['username']; 
            ?>
            <div class="money">
            <?php
                $nowaccount=$_GET['account'];
                $link = @mysqli_connect( 
                    "127.0.0.1",  // MySQL主機名稱 
                    "root",       // 使用者名稱 
                    "sharonwang",  // 密碼 
                    "stockproject");  // 預設使用的資料庫名稱 
                    $sql="SELECT username,dollar FROM sign WHERE useraccount='$nowaccount' ";
                    $result = mysqli_query($link, $sql);
                    if (!$result) {
                        printf("Error: %s\n", mysqli_error($link));
                        exit();
                    }
                $row = mysqli_fetch_assoc($result);
                echo "現有金額：".$row['dollar']; 
            ?>
            </div>
            <div class="home">
                <a href="home.php?account=<?=$nowaccount?>"><button>回首頁</button></a>
            </div>
        </div>
        <div class="information">
            <div class="not">
                <a href="user.php?account=<?=$nowaccount?>">待處理訂單</a>
            </div>
            <div class="table1">
                <?php
                    $link = @mysqli_connect( 
                        "127.0.0.1",  // MySQL主機名稱 
                        "root",       // 使用者名稱 
                        "sharonwang",  // 密碼 
                        "stockproject");  // 預設使用的資料庫名稱 
                        $sql="SELECT * FROM successful WHERE account='$nowaccount' ";
                        $result = mysqli_query($link, $sql);
                        if (!$result) {
                           printf("Error: %s\n", mysqli_error($link));
                           exit();
                       }
                        echo "<table width=50% class='table'>";
                        echo"<tr bgcolor='#f5f290'>"."<td>"."股票編號"."</td>"."<td>"."張數"."</td>"."<td>"."售出"."</td>";
                       if ( $result = mysqli_query($link, $sql) ) {
                            while($row = mysqli_fetch_assoc($result)){  
                            $num=$row["stocknum"];
                        echo"<tr bgcolor=#e0e0e0 style='font-size:18px;border:1px #f0f0f0 solid;border-collapse:collapse;' rules='all' cellpadding='10px';>"."<td>".$row["stocknum"]."</td>"."<td>".$row["howmany"]."</td>"."<td><a href='sell.php?account=$nowaccount&num=$num'><button>我要售出</button></a></td>"."</br>";                        
                            }
                        }
                ?>
            </div>
            <div class="success">
                <h3>成功訂單</h3>
            </div>
            <div class="fails">
                <a href="fails.php?account=<?=$nowaccount?>">失敗訂單</a>
            </div>
        </div>
    
    </div>
    
</body>
</html>
