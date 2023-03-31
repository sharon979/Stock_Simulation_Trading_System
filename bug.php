<?php
  ignore_user_abort(); // run script in background 在背景跑.
  set_time_limit(0); // run script forever 程式執行時間不做限制.
  $interval=60*60*24; // do every 15 minutes... 15分鐘
  do{
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
         sleep(1);
      }
  }

   mysqli_close($link);  
   


      //訂單整理
    $link = @mysqli_connect( 
        "127.0.0.1",  // MySQL主機名稱 
        "root",       // 使用者名稱 
        "sharonwang",  // 密碼 
        "stockproject");  // 預設使用的資料庫名稱 
    $sql="SELECT * from wantorder";
    if ( $result = mysqli_query($link, $sql) ) {
       while($row = mysqli_fetch_assoc($result)){  
          $buyer=$row["buyer"];
          $num=$row["stocknum"];
          $stockprice=$row["stockprice"];
          $howmany=$row["howmany"];
          echo "buyer:".$buyer."stocknum:".$num."stockprice:".$stockprice."howmany:".$howmany."</br>";
          $sql1="SELECT trading_price from stock where stocknum=$num";
          $result1 = mysqli_query($link, $sql1);
          $row1 = mysqli_fetch_assoc($result1);
          $nowprice=$row1["trading_price"];
          echo "stcoknum:".$num."nowprice:".$row1["trading_price"]."</br>";

          $sql2="SELECT dollar from sign where useraccount='$buyer'";
          $result2 = mysqli_query($link, $sql2);
          $row2 = mysqli_fetch_assoc($result2);
          $buyerdollar=$row2["dollar"];
          echo "dollar".$buyerdollar."</br>";
          if($stockprice>=$nowprice){
            $needspend=$nowprice*$howmany*1000;
            echo $needspend;
            if($needspend>$buyerdollar){
                echo "錢不夠購買此股票ＱＱ";
                $SQLCreate="INSERT into fails(account,stocknum,howmany,why) VALUES('$buyer','$num','$howmany','使用者錢不夠ＱＱ')";
                mysqli_query($link, $SQLCreate); 
            }
            else{
                echo "下單成功"."</br>";
                $SQLCreate="INSERT into successful(account,stocknum,pay,howmany) VALUES('$buyer','$num','$needspend',$howmany)";
                mysqli_query($link, $SQLCreate); 
                $pay=$buyerdollar-$needspend;
                echo $pay;
                $SQLUpdate="UPDATE sign SET dollar='$pay' where useraccount='$buyer'";
                mysqli_query($link, $SQLUpdate); 
            }
          }
          else if($stockprice<$nowprice){
            echo "失敗！下單金額過低"."</br>";
            $SQLCreate="INSERT into fails(account,stocknum,howmany,why) VALUES('$buyer','$num','$howmany','下單金額過低')";
            mysqli_query($link, $SQLCreate); 
          }
          $SQLDelete ="DELETE  FROM wantorder WHERE buyer='$buyer'";  
          mysqli_query($link, $SQLDelete); 

       }
   }


      //訂單整理
    $link = @mysqli_connect( 
        "127.0.0.1",  // MySQL主機名稱 
        "root",       // 使用者名稱 
        "sharonwang",  // 密碼 
        "stockproject");  // 預設使用的資料庫名稱 
    $sql="SELECT * from wantsell";
    if ( $result = mysqli_query($link, $sql) ) {
       while($row = mysqli_fetch_assoc($result)){  
          $buyer=$row["buyer"];
          $num=$row["stocknum"];
          $stockprice=$row["stockprice"];
          $howmany=$row["howmany"];
          echo "buyer:".$buyer."stocknum:".$num."stockprice:".$stockprice."howmany:".$howmany."</br>";
          $sql1="SELECT trading_price from stock where stocknum='$num'";
          $result1 = mysqli_query($link, $sql1);
          $row1 = mysqli_fetch_assoc($result1);
          $nowprice=$row1["trading_price"];
          echo "stcoknum:".$num."nowprice:".$row1["trading_price"]."</br>";

          $sql2="SELECT dollar from sign where useraccount='$buyer'";
          $result2 = mysqli_query($link, $sql2);
          $row2 = mysqli_fetch_assoc($result2);
          $buyerdollar=$row2["dollar"];
          echo "dollar".$buyerdollar."</br>";
          if($stockprice<=$nowprice){
            $willearn=$nowprice*$howmany*1000;
            echo $willearn;
            echo "售出成功"."</br>";
                $SQLCreate="INSERT into earn(account,stocknum,dollar,howmany) VALUES('$buyer','$num','$willearn',$howmany)";
                mysqli_query($link, $SQLCreate); 
                $nowdollar=$buyerdollar+$willearn;
                echo $nowdollar;
                $SQLUpdate="UPDATE sign SET dollar='$nowdollar' where useraccount='$buyer'";
                mysqli_query($link,$SQLUpdate); 
                
                $SQLCreate2="INSERT into aboutsell(account,stocknum,howmany,result) VALUES('$buyer','$num','$howmany','$willearn')";
                mysqli_query($link, $SQLCreate2); 
                
            $sql3="SELECT howmany from successful where account='$buyer' and stocknum=$num";
            $result3 = mysqli_query($link, $sql3);
            if (!$result3) {
                  printf("Error: %s\n", mysqli_error($link));
                  exit();
            }
            $row3 = mysqli_fetch_assoc($result3);
            $buyerhave=$row3["howmany"];
            $nowhave=$buyerhave-$howmany;
            echo "nowhave:".$nowhave;
            if(intval($nowhave)==0){
              $SQLDelete ="DELETE  FROM successful WHERE account='$buyer'and stocknum='$num'";  
              mysqli_query($link, $SQLDelete); 
            }
            else{
              $SQLUpdate="UPDATE successful SET howmany='$nowhave' where account='$buyer'and stocknum='$num'";
              mysqli_query($link, $SQLUpdate); 
            }
          }
          else if($stockprice>$nowprice){
            echo "失敗！下單金額過高"."</br>";
            $SQLCreate="INSERT into aboutsell(account,stocknum,howmany,result) VALUES('$buyer','$num','$howmany','售出金額過高無法出售Ｑ')";
            mysqli_query($link, $SQLCreate); 
          }
          $SQLDelete ="DELETE  FROM wantsell WHERE buyer='$buyer'";  
          mysqli_query($link, $SQLDelete); 
       }
   }
  sleep($interval); // wait 15 minutes 等待15分鐘
  }while(true);

?>