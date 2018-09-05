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
include ('bd.php');
include ('users.php');?>
<form action="logout.php">
    <input class="knopka" type="submit" value="Exit"/>
</form>
<form action="create.php">
    <input class="knopka" type="submit" value="Create"/>
</form>

<?php
 
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

// Находим общее число страниц 
$total = intval(((int)$posts[0] - 1) / $num) + 1; 

// Определяем начало сообщений для текущей страницы 
$page = intval($page); 
// Если значение $page меньше единицы или отрицательно 
// переходим на первую страницу 
// А если слишком большое, то переходим на последнюю 

if(empty($page) || $page < 0){ 
    $page = 1; 
}
  if($page > $total) {
    $page = $total; 
  }
// Вычисляем начиная к какого номера 
// следует выводить сообщения 
$start = $page * $num - $num; 
// Выбираем $num сообщений начиная с номера $start
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
// В цикле переносим результаты запроса в массив $postrow 
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

    // Проверяем нужны ли стрелки назад 
    if ($page != 1) $pervpage = '<a href= ./interf_admin.php?page=1><<</a> 
                                   <a href= ./interf_admin.php?page='. ($page - 1) .'><</a> '; 
                                   
    // Проверяем нужны ли стрелки вперед 
    if ($page != $total) $nextpage = ' <a href= ./interf_admin.php?page='. ($page + 1) .'>></a> 
                                       <a href= ./interf_admin.php?page=' .$total. '>>></a>'; 

    // Находим две ближайшие станицы с обоих краев, если они есть 
    if($page - 2 > 0) $page2left = ' <a href= ./interf_admin.php?page='. ($page - 2) .'>'. ($page - 2) .'</a> | '; 
    if($page - 1 > 0) $page1left = '<a href= ./interf_admin.php?page='. ($page - 1) .'>'. ($page - 1) .'</a> | '; 
    if($page + 2 <= $total) $page2right = ' | <a href= ./interf_admin.php?page='. ($page + 2) .'>'. ($page + 2) .'</a>'; 
    if($page + 1 <= $total) $page1right = ' | <a href= ./interf_admin.php?page='. ($page + 1) .'>'. ($page + 1) .'</a>'; 

    // Вывод меню 
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
    
?>
</body>
</html>

<script>

</script>
