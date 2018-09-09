<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Update</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel='stylesheet' href='css/style.css'>
</head>
<body>
<?php
$Errlogin=$Errpassword=$Errfirst_name= $Errlast_name= $Errbirth_date =$ok= "";
include ('bd.php');
include ('users.php');
if(isset($_SESSION['role'])){
    if($_SESSION['role']=='1'){
        if(isset($_POST["save"]))
        {
            $user = new Users;
            $user->update();
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
$id_user=(int)$_POST['id_user'];
$query = "SELECT * FROM users WHERE id_user=".$id_user;
$result = mysqli_query($dbcon, $query);
$table ="<form action='' method='post' name=''>";
$table .= "<table>";
while($row = mysqli_fetch_array($result)){
    $table .= "<input type='hidden' name='id_user' value = " .$row['id_user'] .">";
    $table .= "<tr>";
    $table .= "<td>Login</td>";
    $table .= "<td><input type='text' name='login' value =".$row['login'].">";
    $table .= "<span class='error'>*$Errlogin</span></td>";
    $table .= "</tr>";
    $table .= "<tr>";
    $table .= "<td>Password</td>";
    $table .= "<td><input input type='text' name='password' value =".$row['password'].">";
    $table .= "<span class='error'>*$Errpassword</span></td>";
    $table .= "</tr>";
    $table .= "<tr>";
    $table .= "<td>First name</td>";
    $table .= "<td><input type='text' name='first_name' value =".$row['first_name']." >";
    $table .= "<span class='error'>*$Errfirst_name</span></td>";
    $table .= "</tr>";
    $table .= "<tr>";
    $table .= "<td>Last name</td>";
    $table .= "<td><input type='text' name='last_name' value =".$row['last_name']." >";
    $table .= "<span class='error'>*$Errlast_name</span></td>";
    $table .= "</tr>";
    $table .= "<tr>";
    $table .= "<td>Gender</td>";
    if ($row['gender']=='F'){
        $table .= "<td><input type='radio' name='gender' value='M'> Male<br> <input type='radio' name='gender' value='F' checked> Female<br></td>";
    }else{
        $table .= "<td><input type='radio' name='gender' value='M' checked> Male<br> <input type='radio' name='gender' value='F'> Female<br></td>";
    }
    $table .= "</tr>";
    $table .= "<tr>";
    $table .= "<td>Date of birh</td>";
    $table .= "<td><input type='date' name='birth_date' value =".$row['birth_date']." >";
    $table .= "<span class='error'>*$Errbirth_date</span></td>";
    $table .= "</tr>";
    $table .= "<tr> ";
    $table .= " <td></td>";
    $table .= "<td><span class='sucsess'>$ok</span></td>";
    $table .= "</tr>";
    $table .= "<tr>";
    $table .= "<td></td>";
    $table .= "<td><input class='knopka' type='submit' name='save' value='Save'>";
    $table .= " <input class='knopka' type='submit' name='back' value='Back'></td>";
    $table .= "</tr>";
    }
    mysqli_close($dbcon);
    $table .= "</table> ";
    $table .= "</form> ";
    echo $table;
} else{
    header("Location:index.php");
}
}else{
    header("Location:index.php");
}
?>
</body>
</html>
