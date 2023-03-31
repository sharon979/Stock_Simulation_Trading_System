<!DOCTYPE html>
<html lang="en"> 
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>股票資訊系統登入頁面</title>
   <link rel="stylesheet" href="all.css" charset="utf-8">

</head>
<body>
   <div class="warp">
         <div class="header">
            <a href="https://www.twse.com.tw/zh/">
               <img src="home.jpg" alt="stock">
            </a>
         </div>
         <div class="body">
            <div class="bodyleft">
               <img src="login.jpg" alt="login">
            </div>
            <div class="bodyright">
               <h3>登入 Login</h3>
               <form action="checklogin.php" method="POST">
                  <input type="text" style="font-size:20px" id="account" name="account" placeholder="帳號" required>
                  <div class="clear"></div>
                  <input type="text" style="font-size:20px" id="password" name="password" placeholder="密碼" required>
                  <div class="clear"></div>
                  <input type="submit" style="font-size:20px" id="login" value="登入">
                  <div class="clear"></div>
               </form>
               <div class="registered">
                  <a href="registered.php">還沒註冊嗎？點我註冊</a>
               </div>
            </div>
         </div>
   </div>
</body>
</html>


<?php
   
   /*
   //建立MySQL的資料庫連接 

   $link = @mysqli_connect( 
      "127.0.0.1",  // MySQL主機名稱 
      "root",       // 使用者名稱 
      "sharonwang",  // 密碼 
      "stockproject");  // 預設使用的資料庫名稱 
      $sql="DROP TABLE IF EXISTS stock";
      mysqli_query($link, $sql);
      $sql="CREATE TABLE `stock` (
              `stocknum` varchar(60) NOT NULL,
              `companyname` varchar(60),
              `trading_price`  varchar(60),
              `trading_volume`  varchar(60),
              `volume_accumulation` varchar(60),
              `o` varchar(60),
              `high` varchar(60),
              `low` varchar(60),
              `yesterday` varchar(60),
               PRIMARY KEY (`stocknum`)
         )  DEFAULT CHARSET=utf8 ";
      mysqli_query($link, $sql);
  
   $sql="SELECT `number` FROM `stockcolumn2` ";
   if ( $result = mysqli_query($link, $sql) ) {
      while($row = mysqli_fetch_assoc($result)){  
         $string="https://mis.twse.com.tw/stock/api/getStockInfo.jsp?ex_ch=tse_".$row["number"].".tw&json=1&delay=0";
         $json = file_get_contents($string);
         $obj=json_decode($json);
         $stocknum=$obj->msgArray[0]->c;
         $companyname=$obj->msgArray[0]->n;
         $trading_price=$obj->msgArray[0]->z;
         $trading_volume=$obj->msgArray[0]->tv;
         $volume_accumulation=$obj->msgArray[0]->v;
         $o=$obj->msgArray[0]->o;
         $high=$obj->msgArray[0]->h;
         $low=$obj->msgArray[0]->l;
         $yesterday=$obj->msgArray[0]->y;
         $new=$low+$yesterday;
         echo $stocknum.'</br>'.$companyname.'</br>'.$high.'</br>'.$low.'</br>'.$yesterday.'</br>'.$new.'</br>';
         
         $SQLCreate="INSERT into stock(stocknum,companyname,trading_price,trading_volume,volume_accumulation,o,high,low,yesterday) VALUES('$stocknum','$companyname','$trading_price','$trading_volume','$volume_accumulation','$o','$high','$low','$yesterday')";
         mysqli_query($link, $SQLCreate); 
      }
  }
   mysqli_close($link);   
  /*
  $mystring="05325P　台灣50麥證06售02";
  $new=mb_split("\s",$mystring);
  echo $new[0];
  echo $string="https://mis.twse.com.tw/stock/api/getStockInfo.jsp?ex_ch=tse_".$new[0].".tw&json=1&delay=0";
  */


  
?>
