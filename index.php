<?php
 session_start();
 header('Content-Type: text/html; charset=utf-8');
 include ('bd.php');
?>
<!DOCTYPE HTML">
<html>
<head>
<title>Enter</title>
<link rel='stylesheet' href='css/style.css'>
</head>
<body>
<?php
// Проверяем, пусты ли переменные логина и id пользователя
    if (empty($_SESSION['login']) or empty($_SESSION['id_user']))
    {
?>

 <div class = 'login'>
		
<form action="authorization.php" method="post">
    <label>Login:</label><br/>
  <input name="login" type="text" size="15" maxlength="15"><br/>
    <label>Password:</label><br/>
  <input name="password" type="password" size="15" maxlength="15"><br/><br/>
  <input  class="knopka" type="submit" value="Enter"><br/><br/>
</form>
</div>
<?php
    }
    else  
    {
        header("Location:interf_admin.php"); }
    ?> 
</body>
</html>