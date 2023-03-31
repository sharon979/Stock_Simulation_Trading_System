<?php
$link = @mysqli_connect( 
    '127.0.0.1',  // MySQL主機名稱 
    'root',       // 使用者名稱 
    'sharonwang',  // 密碼
    'stockproject');  // 預設使用的資料庫名稱
    $account=$_POST["account"];
    $password=$_POST["password"];
    $sql="SELECT useraccount,userpassword from sign";
    if ( $result = mysqli_query($link, $sql) ) {
        while( $row = mysqli_fetch_assoc($result) ){
            if($account==$row[useraccount] && $password==$row[userpassword]){
                $flag=1;
            }
    }
} 
if ($flag) {
    echo "<script>alert('使用者登入成功'); location.href = 'home.php?account=$account';</script>";
}   
else{        
    echo "<script>alert('帳號密碼錯誤，請查證或重新註冊'); location.href = 'index.php';</script>";
}
mysqli_close($link);  // 關閉資料庫連接
?>