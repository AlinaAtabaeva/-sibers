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
include ('bd.php');
include ('users.php');
if(isset($_SESSION['role'])){
    if($_SESSION['role']==1){
        if(isset($_POST["login"]))
        {
            $user = new Users;
            $user->create();
        }

?>
<form action="" method="post" name="form1">
        <table width="25%" border="0">
            <tr> 
                <td>Login</td>
                <td><input type="text" name="login"></td>
            </tr>
            <tr> 
                <td>Password</td>
                <td><input type="password" name="password"></td>
            </tr>
            <tr> 
                <td>First name</td>
                <td><input type="text" name="first_name"></td>
            </tr>
            <tr> 
                <td>Last name</td>
                <td><input type="text" name="last_name"></td>
            </tr>
            <tr> 
                <td>Gender</td>
                <td><input type="radio" name="gender" value="M" checked> Male<br>
                <input type="radio" name="gender" value="F"> Female<br></td>
            </tr>
            <tr> 
                <td>Date of birh</td>
                <td><input type="date" name="birth_date" /></td>
            </tr>
            <tr> 
                <td></td>
                <td><input class='knopka' type="submit" name="Submit" value="Add"></td>
            </tr>
        </table>
    </form>
<?php
}   
}else{
    echo "You do not have permission to access";
}
?>
</body>
</html>
