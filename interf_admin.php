<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Admin</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel='stylesheet' href='css/style.css'>
</head>
<body>

<?php
if(isset($_SESSION['role'])){
    if($_SESSION['role']=='1'){
//connect bd
include ('bd.php');
//file with function 
include ('users.php');
 //Variable for pagination  
if(isset($_GET['page'])){
    $page = $_GET['page'];
}else{
    $page = 1;
}

$user = new Users;
$sort =1;

if (isset($_POST['show'])) {
    $user->read();
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
    $table .= "<tr>";
    $table .= "<td>".$user->id_user."</td>";
    $table .= "<td>".$user->login."</td>";
    $table .= "<td>".$user->password."</td>";
    $table .= "<td>".$user->first_name."</td>";
    $table .= "<td>".$user->last_name."</td>";
    if ($user->gender=='F'){
        $table .= "<td>Female</td>";
    }else{
        $table .= "<td>Male</td>";
    }
    $table .= "<td>".$user->birth_date."</td>";
    if ($user->role== 1){
        $table .= "<td>Admin</td>";
    }else{
        $table .= "<td>User</td>";
    }
    $table .= "</tr>";
    $table .= "</table> ";
    echo $table;
    echo " <form method=post onsubmit='return close()'>";
    echo " <input class='knopka' type='submit' value='Close' />";
    echo " </form>";
}else if (isset($_POST['delete'])) {
    $user->delete();
  }else if (isset($_POST['update'])) {
    header("Location:update.php"); 
  }else if (isset($_POST['sort'])) {
      if ($_POST['sort']==1){
        $_SESSION['sort']=1;
      }
      if ($_POST['sort']==2){
        $_SESSION['sort']=2;
      }
  }

 //button exit and create new user
  echo "<div class = 'butMen'>";
  echo "<form action='logout.php'>";
  echo " <input class='knopka' type='submit' value='Exit'/>";
  echo "</form>";
  echo "<form action='create.php'>";
  echo "<input class='knopka' type='submit' value='Create'/>";
  echo "</form>";
  echo "</div>";

$num = 5; 
$query = "SELECT COUNT(*) FROM users"; 
$result = mysqli_query($dbcon, $query);
$posts = mysqli_fetch_row($result); 

// Find the total number of pages
$total = intval(((int)$posts[0] - 1) / $num) + 1; 

//Define the beginning of messages for the current page
$page = intval($page); 

if(empty($page) || $page < 0){ 
    $page = 1; 
}
  if($page > $total) {
    $page = $total; 
  }
// We calculate starting to which number should output messages
$start = $page * $num - $num; 
echo "<div class= 'butSort'>";
echo "<form action='' method='post' name=''>";
echo "<span>Data sorting</span><br>";
// if $sort==1 ORDER BY Acs if $sort==2 ORDER BY Desc
if($_SESSION['sort']=='1') {
    $result = mysqli_query($dbcon,"SELECT * FROM users  ORDER BY login LIMIT $start, $num"); 
    echo  "<input type='radio' name='sort' value='1' checked>Asc <input type='radio' name='sort' value='2'> Desc";
}elseif($_SESSION['sort']=='2') {
    $result = mysqli_query($dbcon,"SELECT * FROM users  ORDER BY login DESC LIMIT $start, $num"); 
    echo  "<input type='radio' name='sort' value='1'>Asc<input type='radio' name='sort' value='2' checked> Desc";
}
echo "<input class='knopka' type='submit' name='' value='Sort' />";
echo "</form> ";
echo "</div> ";
// output to the table
$table = "<table>";
    $table .= "<tr>";
    $table .= "<td>Users</td>";
    $table .= "</tr>";
    while($row = mysqli_fetch_array($result)){
    $table .= "<tr>";
    $table .= "<form action='' method='post'>"; 
    $table .= "<input type='hidden' name='id_user' value = " .$row['id_user'] .">";
    $table .= "<td>".$row['login']."</td>";
    $table .= "<td><input class='knopka' type='submit' name='show' value='Show'></td>";
    $table .= "<td><input class='knopka' type='submit' name='delete' value='Delete' /></td>";
    $table .= "</form>";
    $table .= "<form action='update.php' method='post'>"; 
    $table .= "<input type='hidden' name='id_user' value = " .$row['id_user'] .">";
    $table .= "<td><input class='knopka' type='submit' name='update' value='Update' /></td>";
    $table .= "</form>";
    $table .= "</tr>";
    }
    mysqli_close($dbcon);
    $table .= "</table> ";
    echo $table;

    // button back
    if ($page != 1) $pervpage = '<a href= ./interf_admin.php?page=1>«</a> 
                                   <a href= ./interf_admin.php?page='. ($page - 1) .'>‹</a> '; 
                                   
    // button next
    if ($page != $total) $nextpage = ' <a href= ./interf_admin.php?page='. ($page + 1) .'>›</a> 
                                       <a href= ./interf_admin.php?page=' .$total. '>»</a>'; 

    // We find the two nearest stanitsas from both edges, if they exist
    if($page - 2 > 0) $page2left = ' <a href= ./interf_admin.php?page='. ($page - 2) .'>'. ($page - 2) .'</a>'; 
    if($page - 1 > 0) $page1left = '<a href= ./interf_admin.php?page='. ($page - 1) .'>'. ($page - 1) .'</a>'; 
    if($page + 2 <= $total) $page2right = '<a href= ./interf_admin.php?page='. ($page + 2) .'>'. ($page + 2) .'</a>'; 
    if($page + 1 <= $total) $page1right = '<a href= ./interf_admin.php?page='. ($page + 1) .'>'. ($page + 1) .'</a>'; 

    // pagination button
    if($total!=1){
        echo '<ul class="pagination">';
        if (isset($pervpage))echo '<li>'.$pervpage.'</li>';
        if (isset($page2left))echo '<li>'.$page2left.'</li>';
        if (isset($page1left)) echo '<li>'.$page1left.'</li>';
        echo '<li><a class="active">'.$page.'</a></li>';
        if (isset($page1right))echo '<li>'.$page1right.'</li>';
        if (isset($page2right))echo '<li>'.$page2right.'</li>';
        if (isset($nextpage))echo '<li>'.$nextpage.'</li>';
        echo '</ul>';
    }
}else{
    header("Location:index.php");
}
}else{
    header("Location:index.php");
     }
?>
</body>
</html>

