<?php
header('Content-Type: text/html; charset=utf-8');
setlocale(LC_ALL,"US");
    session_start();//  вся процедура работает на сессиях. Именно в ней хранятся данные  пользователя, пока он находится на сайте. Очень важно запустить их в  самом начале странички!!!
    include ('bd.php');
    if (isset($_POST['login'])) { $login = $_POST['login']; if ($login == '') { unset($login);} } //заносим введенный пользователем логин в переменную $login, если он пустой, то уничтожаем переменную
    if (isset($_POST['password'])) { $password=$_POST['password']; if ($password =='') { unset($password);} }
    //заносим введенный пользователем пароль в переменную $password, если он пустой, то уничтожаем переменную
if (empty($login) or empty($password)) //если пользователь не ввел логин или пароль, то выдаем ошибку и останавливаем скрипт
    {
    echo("<p> You did not enter all the information, go back and fill in all the fields!</p>");
    }
    //если логин и пароль введены,то обрабатываем их, чтобы теги и скрипты не работали, мало ли что люди могут ввести
    $login = stripslashes($login);
    $login = htmlspecialchars($login);
    $password = stripslashes($password);
    $password = htmlspecialchars($password);
//удаляем лишние пробелы
    $login = trim($login);
    $password = trim($password);
	
     //Подключаемся к базе данных.
	if (!$dbcon)
	{
    echo "<p>Произошла ошибка при подсоединении к MySQL!</p>".mysql_error(); exit();
    } else {
    if (!mysqli_select_db($dbcon, "sibers"))
    {
    echo("<p>Выбранной базы данных не существует!</p>");
    }
	}
 //извлекаем из базы все данные о пользователе с введенным логином
    $result = mysqli_query($dbcon,"SELECT * FROM users WHERE login='$login'");
    $myrow = mysqli_fetch_array($result);
    if (empty($myrow["password"]))
    {
    //если пользователя с введенным логином не существует
    exit ("<body><div align='center'><br/><br/><br/>
	<h3>Извините, введённый вами login или пароль неверный." . "<a href='index.php'> <b>Назад</b> </a></h3></div></body>");
    }
    else {
    //если существует, то сверяем пароли
    if ($myrow["password"]==$password) {
        if($myrow["role"]== 1){
            //если пароли совпадают, то запускаем пользователю сессию! Можете его поздравить, он вошел!
            $_SESSION['login']=$myrow["login"]; 
            $_SESSION['id_user']=$myrow["id_user"];//эти данные очень часто используются, вот их и будет "носить с собой" вошедший пользователь
            header("Location:interf_admin.php?page=1"); 
        }else{
            echo "<font color='red'> You are not an administrator.</font><br/>";
        }
    }else {

    echo "<font color='red'>Not a valid password or login.</font><br/>";
    }
    }
    ?>