<!DOCTYPE html>
<html lang="en"> 
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>股票資訊系統註冊頁面</title>
   <link rel="stylesheet" href="registered.css" charset="utf-8">

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
               <img src="signin.jpg" alt="signin">
            </div>
            <div class="bodyright">
               <h3>註冊會員</h3>
               <form action="sign.php" method="POST">
                  <input type="text" style="font-size:20px" id="username" name="username" placeholder="使用者名稱" required> 
                  <div class="clear"></div>
                  <input type="text" style="font-size:20px" id="useraccount" name="useraccount" placeholder="帳號" required>
                  <div class="clear"></div>
                  <input type="text" style="font-size:20px" id="password" name="userpassword" placeholder="密碼" required>
                  <div class="clear"></div>
                  <input type="text" style="font-size:20px" id="password" name="userpassword2" placeholder="密碼確認" required>
                  <div class="clear"></div>
                  <input type="submit" style="font-size:20px" id="login" value="註冊">
                  <div class="clear"></div>
               </form>
               <div class="clear"></div>
               <div class="registered">
                  <a href="index.php">已有帳號？點我回到登入頁面</a>
               </div>
            </div>
         </div>
   </div>
</body>
</html>



