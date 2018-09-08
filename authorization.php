<?php
header('Content-Type: text/html; charset=utf-8');
setlocale(LC_ALL,"US");
    session_start();
    include ('bd.php');
    if (isset($_POST['login'])) { $login = $_POST['login']; if ($login == '') { unset($login);} } //enter login in session[login], if $login empty destroy this
    if (isset($_POST['password'])) { $password=$_POST['password']; if ($password =='') { unset($password);} }
    ///enter password in session[password], if $password empty destroy this
 if (empty($login) or empty($password)) //if fields empty output error
    {
        header("Location:index.php");
    }
    //processing login and password
    $login = stripslashes($login);
    $login = htmlspecialchars($login);
    $password = stripslashes($password);
    $password = htmlspecialchars($password);
    $login = trim($login);
    $password = trim($password);
	
     //connect to database
	if (!$dbcon)
	{
    echo "<p>An error occurred while connecting to MySQL!</p>".mysql_error(); exit();
    } else {
    if (!mysqli_select_db($dbcon, "sibers"))
    {
    echo("<p>The selected database does not exist!</p>");
    }
	}
    //information about user
    $result = mysqli_query($dbcon,"SELECT * FROM users WHERE login='$login'");
    $myrow = mysqli_fetch_array($result);
    //if user does not exist
    if (empty($myrow["password"]))
    {
        echo("<p>Login is required!</p>");
    }
    else {
    //if exist compare login and pasword
    if ($myrow["password"]==$password) {
        if($myrow["role"]== 1){//if user admin
            $_SESSION['login']=$myrow["login"]; 
            $_SESSION['id_user']=$myrow["id_user"];
            $_SESSION['role']=$myrow["role"];
            header("Location:interf_admin.php?page=1"); 
        }else{
            echo "<font color='red'> You are not an administrator.</font><br/>";
        }
    }else {

    echo "<font color='red'>Not a valid password or login.</font><br/>";
    }
    }
    ?>