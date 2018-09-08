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
include ('bd.php');
include ('users.php');
if(isset($_SESSION['role'])){
    if($_SESSION['role']=='1'){
        if(isset($_POST["login"]))
        {
            $user = new Users;
            $user->update();
        }
$id_user=(int)$_POST['id_user'];
$query = "SELECT * FROM users WHERE id_user=".$id_user;
$result = mysqli_query($dbcon, $query);
$table ="<form action='' method='post' name=''>";
$table .= "<table width='25%' border='0'>";
while($row = mysqli_fetch_array($result)){
    $table .= "<input type='hidden' name='id_user' value = " .$row['id_user'] .">";
    $table .= "<tr>";
    $table .= "<td>Login</td>";
    $table .= "<td><input type='text' name='login' value =".$row['login']."></td>";
    $table .= "</tr>";
    $table .= "<tr>";
    $table .= "<td>Password</td>";
    $table .= "<td><input input type='password' name='password' value =".$row['password']."></td>";
    $table .= "</tr>";
    $table .= "<tr>";
    $table .= "<td>First name</td>";
    $table .= "<td><input type='text' name='first_name' value =".$row['first_name']." ></td>";
    $table .= "</tr>";
    $table .= "<tr>";
    $table .= "<td>Last name</td>";
    $table .= "<td><input type='text' name='last_name' value =".$row['last_name']." ></td>";
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
    $table .= "<td><input type='date' name='birth_date' value =".$row['birth_date']." ></td>";
    $table .= "</tr>";
    $table .= "<tr>";
    $table .= "<td></td>";
    $table .= "<td><input class='knopka' type='submit' name='Submit' value='Save'></td>";
    $table .= "</tr>";
    }
    mysqli_close($dbcon);
    $table .= "</table> ";
    $table .= "</form> ";
    echo $table;
}   
}else{
    echo "You do not have permission to access";
}
?>
</body>
</html>
