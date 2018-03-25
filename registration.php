<?php
session_start();
?>
<?php 
    $username=$_POST["username"];
	$password=  md5($_POST["password"]);
	
	
	if ($username!='' && $password!=''){
      $host='localhost';	  
      $mysqli =new mysqli($host, 'root', '', 'expenses');
	  if ($mysqli->connect_errno) {
      echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
      }
	  $username = $mysqli->real_escape_string($username);
	  $password = $mysqli->real_escape_string($password);
	  
	  $result=$mysqli->query("SELECT id,login,password FROM t_users where login='".$username."'");
	  $row = mysqli_fetch_array($result);
	  if ($row["password"]==""){
	  
	   if ($mysqli->query("INSERT INTO `expenses`.`t_users` (`login`,`password`) VALUES ('".$username."','".$password."')")=== FALSE) {
          printf("Ошибка при вставке данных в таблицу");
       }
	   $result=$mysqli->query("SELECT id,login,password FROM t_users where login='".$username."'");
	   $row = mysqli_fetch_array($result);
	   $_SESSION["userid"]= $row["id"];
	   }
	  else if ($row["password"]!=$password){
		  echo "Неверно введен пароль";
          }
	  else {
		 $_SESSION["userid"]= $row["id"];
		 
		 }
      $mysqli->close();
	  unset($_POST);
	  $_POST = array();
          header('Location: index.php');
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="cost, expense"/>
<meta name="description" content="Сайт для учета расходов"/>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="image/money.png" rel="short icon" type="image/x-icon" />
<title>
Регистрация
</title>
</head>
<body>

<div class="menuabout"><a href="index.php">Главная</a></div>
  <div class="regform">
    <form class="login-form" action="" method="POST">
      <input type="text" placeholder="username" name="username"/>
      <input type="password" placeholder="password" name="password"/>
      <div class="submit"><input type="submit"  value="LOGIN"></div>
    </form>
  </div>
</div>
</body>
</html>