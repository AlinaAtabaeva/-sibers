<?php
header('Content-Type: text/html; charset=utf-8');
setlocale(LC_ALL,"US");
session_start();
    include ('bd.php');
    if (isset($_POST['login'])) { $login = $_POST['login']; if ($login == '') { unset($login);} } //enter login in session[login], if $login empty destroy this
    if (isset($_POST['password'])) { $password=$_POST['password']; if ($password =='') { unset($password);} }//enter password in session[password], if $password empty destroy this
    if (empty($login) or empty($password)) 
    {
        //if fields empty, output error                  
        $_SESSION['error']='Login or password is empty';
        header("Location:index.php");
    }elseif(!$dbcon)
        {
            //if didn't connect to database, output error
            $_SESSION['error']='An error occurred while connecting to MySQL';
            header("Location:index.php");
        }elseif(!mysqli_select_db($dbcon, "sibers"))
            {
                //if didn't find to database sibers, output error
                $_SESSION['error']='The selected database does not exist';
                header("Location:index.php");
            }else{
                //information about user
                $result = mysqli_query($dbcon,"SELECT * FROM users WHERE login='$login'");
                $myrow = mysqli_fetch_array($result);
                    if (empty($myrow["password"]))
                    {
                        //if user does not exist
                        $_SESSION['error']='Login is required!';
                        header("Location:index.php");
                    //if exist compare login and pasword
                    }elseif ($myrow["password"]==$password) {
                        if($myrow["role"]== 1){//if user admin
                            $_SESSION['login']=$myrow["login"]; 
                            $_SESSION['id_user']=$myrow["id_user"];
                            $_SESSION['role']=$myrow["role"];
                            $_SESSION['sort']='1';
                            header("Location:interf_admin.php?page=1"); 
                        }else{
                            //if user aren't administrator
                            $_SESSION['error']="You aren't an administrator.";
                            header("Location:index.php");
                        }
                    }else {
                        //password or login wrong
                        $_SESSION['error']="Not a valid password or login.";
                        header("Location:index.php");
                    }
            }
?>