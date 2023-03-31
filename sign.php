<?php
// 建立MySQL的資料庫連接 
$link = @mysqli_connect( 
            "127.0.0.1",  // MySQL主機名稱 
            "root",       // 使用者名稱 
            "sharonwang",  // 密碼 
            "stockproject");  // 預設使用的資料庫名稱 
if ( !$link ) {
   echo "MySQL資料庫連接錯誤!<br/>";
   exit();
}
else {
   echo "MySQL資料庫test連接成功!<br/>";
}

$username=$_POST["username"];
$useraccount=$_POST["useraccount"];
$userpassword=$_POST["userpassword"];
$userpassword2=$_POST["userpassword2"];
if(isset($useraccount) && $userpassword==$userpassword2){
if(isset($useraccount)){
    $sql="SELECT useraccount from sign";
    if($result = mysqli_query($link, $sql)){
        while($row = mysqli_fetch_assoc($result)){
            if ($useraccount==$row[useraccount]) {
            $flag=1;
    }
  }
}
if(isset($flag) && $flag==1){
    echo "<script>alert('帳號重複，請重新註冊'); location.href = 'registered.php';</script>";
}else{
    $SQLCreate="INSERT into sign(username,useraccount,userpassword,dollar) VALUES('$username','$useraccount','$userpassword',500000)";
    $insertresult = mysqli_query($link, $SQLCreate);   
    echo "<script>alert('註冊成功，請登入'); location.href = 'index.php';</script>";
}
}
}else{
echo "<script>alert('密碼輸入不相同，請重新註冊'); location.href = 'registered.php';</script>";
}
mysqli_close($link);  // 關閉資料庫連接

?>