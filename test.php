<?php

ignore_user_abort(); // run script in background 在背景跑.
set_time_limit(0); // run script forever 程式執行時間不做限制.
$interval=30; // 
do{
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