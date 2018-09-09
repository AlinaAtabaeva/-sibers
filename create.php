<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Create</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel='stylesheet' href='css/style.css'>
</head>
<body>
<?php
$Errlogin=$Errpassword=$Errfirst_name= $Errlast_name= $Errbirth_date =$ok= "";
include ('bd.php');
include ('users.php');
if(isset($_SESSION['role'])){
    if($_SESSION['role']==1){
        if(isset($_POST["add"]))
        {
            $user = new Users;
            $user->create();
            if(isset($user->error)){
                if(isset($user->error['ok'])){
                    $ok  =$user->error['ok'];
                }
                if(isset($user->error['login'])){
                    $Errlogin =$user->error['login'];
                }
                if(isset($user->error['password'])){
                    $Errpassword =$user->error['password'];
                }
                if(isset($user->error['first_name'])){
                    $Errfirst_name =$user->error['first_name'];
                }
                if(isset($user->error['last_name'])){
                    $Errlast_name =$user->error['last_name'];
                }
                if(isset($user->error['birth_date'])){
                    $Errbirth_date  =$user->error['birth_date'];
                }
            }
        }
        if(isset($_POST["back"]))
        {
            header("Location:interf_admin.php?page=1"); 
        }

?>
<form action="" method="post" name="form1">
        <table width="25%" border="0">
            <tr> 
                <td>Login</td>
                <td><input type="text" name="login">
                <span class="error">* <?php echo $Errlogin;?></span></td>
            </tr>
            <tr> 
                <td>Password</td>
                <td><input type="password" name="password">
                <span class="error">* <?php echo $Errpassword;?></span></td>
            </tr>
            <tr> 
                <td>First name</td>
                <td><input type="text" name="first_name">
                <span class="error">* <?php echo $Errfirst_name;?></span></td>
            </tr>
            <tr> 
                <td>Last name</td>
                <td><input type="text" name="last_name">
                <span class="error">* <?php echo $Errlast_name;?></span></td>
            </tr>
            <tr> 
                <td>Gender</td>
                <td><input type="radio" name="gender" value="M" checked> Male<br>
                <input type="radio" name="gender" value="F"> Female<br></td>
            </tr>
            <tr> 
                <td>Date of birh</td>
                <td><input type="date" name="birth_date" />
                <span class="error">* <?php echo $Errbirth_date;?></span></td>
            </tr>
            <tr> 
                <td></td>
                <td><span class="sucsess"><?php echo $ok;?></span></td>
            </tr>
            <tr> 
                <td></td>
                <td><input class='knopka' type="submit" name="add" value="Add">
                <input class='knopka' type="submit" name="back" value="Back"></td>
            </tr>
        </table>
    </form>
<?php
}else{
    header("Location:index.php");
}
}else{
    header("Location:index.php");
}
?>
</body>
</html>
