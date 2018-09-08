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
include ('users.php');?>
<!--button exit and create new user-->
<form action="logout.php">
    <input class="knopka" type="submit" value="Exit"/>
</form>
<form action="create.php">
    <input class="knopka" type="submit" value="Create"/>
</form>

<?php
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
  }
  else if (isset($_POST['delete'])) {
    $user->delete();
  }else if (isset($_POST['update'])) {
    header("Location:update.php"); 
  }else if (isset($_POST['sort'])) {
      if ($_POST['sort']==1)
      $sort =1;
      if ($_POST['sort']==2)
      $sort =2;
  };
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
// if $sort==1 ORDER BY Acs if $sort==2 ORDER BY Desc
if ($sort==1) {
    $result = mysqli_query($dbcon,"SELECT * FROM users  ORDER BY login LIMIT $start, $num"); 
}else if($sort==2){
    $result = mysqli_query($dbcon,"SELECT * FROM users  ORDER BY login DESC LIMIT $start, $num"); 
}
echo "<form action='' method='post' name=''>";
if ($sort==1){
    echo  "<input type='radio' name='sort' value='1' checked>Asc <br><input type='radio' name='sort' value='2'> Desc<br>";
}else{
    echo  "<input type='radio' name='sort' value='1'>Asc <br><input type='radio' name='sort' value='2' checked> Desc<br>";
}
echo "<input class='knopka' type='submit' name='' value='Sort' />";
echo "</form> ";
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
    if ($page != 1) $pervpage = '<a href= ./interf_admin.php?page=1><<</a> 
                                   <a href= ./interf_admin.php?page='. ($page - 1) .'><</a> '; 
                                   
    // button next
    if ($page != $total) $nextpage = ' <a href= ./interf_admin.php?page='. ($page + 1) .'>></a> 
                                       <a href= ./interf_admin.php?page=' .$total. '>>></a>'; 

    // We find the two nearest stanitsas from both edges, if they exist
    if($page - 2 > 0) $page2left = ' <a href= ./interf_admin.php?page='. ($page - 2) .'>'. ($page - 2) .'</a> | '; 
    if($page - 1 > 0) $page1left = '<a href= ./interf_admin.php?page='. ($page - 1) .'>'. ($page - 1) .'</a> | '; 
    if($page + 2 <= $total) $page2right = ' | <a href= ./interf_admin.php?page='. ($page + 2) .'>'. ($page + 2) .'</a>'; 
    if($page + 1 <= $total) $page1right = ' | <a href= ./interf_admin.php?page='. ($page + 1) .'>'. ($page + 1) .'</a>'; 

    // pagination button
    $table = "<table>";
    $table .= "<tr>";
    $table .= "<td>";
    if (isset($pervpage))$table .= $pervpage;
    if (isset($page2left))$table .= $page2left;
    if (isset($page1left))$table .= $page1left;
    $table .= $page;
    if (isset($page1right))$table .= $page1right;
    if (isset($page2right))$table .= $page2right;
    if (isset($nextpage))$table .= $nextpage;
    $table .= "</td>";
    $table .= "</tr>";
    $table .= "</table> ";
    if ($total!=1){
        echo $table;
        }
    }   
}else{
    echo "You do not have permission to access";
}
?>
</body>
</html>

