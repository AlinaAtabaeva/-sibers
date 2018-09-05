<?php
class Users {

 function Create() {
     
    if(isset($_POST['Submit'])) {    
        $login = $_POST['login'];
        $password = $_POST['password'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $gender = $_POST['gender'];
        $birth_date = $_POST['birth_date'];
        $role = 0;
        if(empty($login) || empty($password) || empty($first_name) || empty($last_name) || empty($birth_date) ) {                

                echo "<font color='red'> не все поля заполнены.</font><br/>";

        } else { 
            include ('bd.php');
            $query = "INSERT INTO users (login,password,first_name,last_name,gender,birth_date,role) VALUES ('$login','$password','$first_name','$last_name','$gender','$birth_date','$role');"; 
            $result = mysqli_query($dbcon, $query);
            header("Location:interf_admin.php?page=1");  
        }
      
    }
 }

 function read() {
    $id_user=(int)$_POST['id_user'];
    include ('bd.php');
    $query = "SELECT * FROM users WHERE id_user=".$id_user; 
    $result = mysqli_query($dbcon, $query);
    $table = "<table>";
    $table .= "<tr>";
    $table .= "<td> Id</td>";
    $table .= "<td>Login</td>";
    $table .= "<td>Password</td>";
    $table .= "<td>First name</td>";
    $table .= "<td>Last name</td>"; 
    $table .= "<td>Gender</td>";
    $table .= "<td>Date of birh</td>";
    $table .= "<td>Role</td>";
    $table .= "</tr>";
    while($row = mysqli_fetch_array($result)){
        $table .= "<tr>";
        $table .= "<td>".$row['id_user']."</td>";
        $table .= "<td>".$row['login']."</td>";
        $table .= "<td>".$row['password']."</td>";
        $table .= "<td>".$row['first_name']."</td>";
        $table .= "<td>".$row['last_name']."</td>";
        if ($row['gender']=='F'){
            $table .= "<td>Female</td>";
        }else{
            $table .= "<td>Male</td>";
        }

        $table .= "<td>".$row['birth_date']."</td>";
        if ($row['role']== 1){
            $table .= "<td>Admin</td>";
        }else{
            $table .= "<td>User</td>";
        }
        $table .= "</tr>";
        }
        mysqli_close($dbcon);
        $table .= "</table> ";
        echo $table;

 }

 function Update() {    
    if(isset($_POST['Submit'])) { 
     $id_user=(int)$_POST['id_user']; 
    $login = $_POST['login'];
    $password = $_POST['password'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $gender = $_POST['gender'];
    $birth_date = $_POST['birth_date'];
    $role = 0;
    if(empty($login) || empty($password) || empty($first_name) || empty($last_name) || empty($birth_date) ) {                

            echo "<font color='red'> не все поля заполнены.</font><br/>";

    } else { 
        include ('bd.php');
        $query = "UPDATE users SET login = '$login',password = '$password',first_name = '$first_name',last_name = '$last_name',gender = '$gender',birth_date = '$birth_date' WHERE id_user='$id_user';"; 

        $result = mysqli_query($dbcon, $query);
        header("Location:interf_admin.php?page=1"); 
    }
  
}
}

 function Delete() {
    $id_user=(int)$_POST['id_user'];
    include ('bd.php');
    $query = "DELETE FROM users  WHERE id_user=".$id_user;
    $result = mysqli_query($dbcon, $query);
    header("Location:interf_admin.php?page=1"); 
 }

}
?>