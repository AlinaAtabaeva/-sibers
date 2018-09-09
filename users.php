<?php
class Users {

  public $id_user; 
  public $login; 
  public $password; 
  public $first_name; 
  public $last_name; 
  public $gender; 
  public $birth_date;
  public $role;  
  public $error=[]; 
 function Create() {
     
    if(isset($_POST['add'])) { 
            $this->login = $this->parseInput($_POST['login']);
            $this->password = $_POST['password'];
            $this->first_name =  $this->parseInput($_POST['first_name']);
            $this->last_name =  $this->parseInput($_POST['last_name']);
            $this->gender = $_POST['gender'];
            $this->birth_date = $_POST['birth_date'];
            $this->role = 0;
            $this->validation();
           if(empty($this->error)){
            include ('bd.php');
            $query = "SELECT login  FROM users WHERE login ='$this->login';"; 
            $result = mysqli_query($dbcon, $query);
            $row = mysqli_fetch_array($result);
            if(empty($row)){
              $query = "SELECT login WHERE login =''$this->login';"; 
              $result = mysqli_query($dbcon, $query);
              $query = "INSERT INTO users (login,password,first_name,last_name,gender,birth_date,role) VALUES ('$this->login','$this->password','$this->first_name','$this->last_name','$this->gender','$this->birth_date','$this->role');"; 
              $result = mysqli_query($dbcon, $query);
              mysqli_close($dbcon);
              $this->error['ok'] = "Successfully saved";
            }
            $this->error['login'] = "This login already exists";
           }
    }
}


 function read() {
  if(isset($_POST['show'])) { 
    $id_user=(int)$_POST['id_user'];
    include ('bd.php');
    $query = "SELECT * FROM users WHERE id_user=".$id_user; 
    $result = mysqli_query($dbcon, $query);
    $row = mysqli_fetch_array($result);
    $this->id_user = $row['id_user'];
    $this->login = $row['login'];
    $this->password = $row['password'];
    $this->first_name =$row['first_name'];
    $this->last_name = $row['last_name'];
    $this->gender =$row['gender'];
    $this->birth_date = $row['birth_date'];
    $this->role = $row['role'];
    mysqli_close($dbcon);
 }
}


 function Update() {    
    if(isset($_POST['save'])) { 
      $this->id_user=(int)$_POST['id_user'];    
      $this->login = $this->parseInput($_POST['login']);
      $this->password = $_POST['password'];
      $this->first_name =  $this->parseInput($_POST['first_name']);
      $this->last_name =  $this->parseInput($_POST['last_name']);
      $this->gender = $_POST['gender'];
      $this->birth_date = $_POST['birth_date'];
      $this->role = 0;
      $this->validation();
     if(empty($this->error)){
      include ('bd.php');
      $query = "UPDATE users SET login = '$this->login',password = '$this->password',first_name = '$this->first_name',last_name = '$this->last_name',gender = '$this->gender',birth_date = '$this->birth_date' WHERE id_user='$this->id_user';";
      $result = mysqli_query($dbcon, $query);
      $this->error['ok'] = "Successfully updated";
     }    
   }
}

 function Delete() {
    $id_user=(int)$_POST['id_user'];
    include ('bd.php');
    $query = "DELETE FROM users  WHERE id_user=".$id_user;
    $result = mysqli_query($dbcon, $query);
    mysqli_close($dbcon);
    header("Location:interf_admin.php?page=1"); 
 }

 function parseInput($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

 function validation(){
  if (empty($this->login)) {
      $this->error['login'] = "Login is required.";
    } else {
      // check if login only contains letters and whitespace
      if (!preg_match("/^[a-zA-Z ]*$/",$this->login)) {
        $this->error['login'] = "Only letters and white space allowed.";
      }
    }
    if (empty($this->password)) {
      $this->error['password'] = "Password is required.";
    } else {
        // check if password have least 8 characters
      if (strlen($this->password) <= '8') {
        $this->error['password'] = "Your Password Must Contain At Least 8 Characters.";
      }
      // check if password have least 1 number
      elseif(!preg_match("#[0-9]+#",$this->password)) {
        $this->error['password'] = "Your Password Must Contain At Least 1 Number.";
      }
    }
    if (empty($this->first_name)) {
      $this->error['first_name'] = "First name is required.";
    } else {
      if (!preg_match("/^[a-zA-Z ]*$/",$this->first_name)) {
        $this->error['first_name'] = "Only letters and white space allowed."; 
      }
    }
    if (empty($this->last_name)) {
      $this->error['last_name'] = "Last name is required."; 
    } else {
      if (!preg_match("/^[a-zA-Z ]*$/",$this->last_name)) {
        $this->error['last_name'] = "Only letters and white space allowed."; 
      }
    }
    if (empty($this->birth_date)) {
      $this->error['birth_date'] = "Date is required."; 
    } else {
      if ($this->birth_date > date("Y-m-d")) {
        $this->error['birth_date'] = "Only the past date."; 
      }
    }
 }

}
?>