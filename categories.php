<?php
session_start();
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
Категории расходов
</title>
</head>
<body>
<?php     
	$textcat=$_POST["textcat"];
	$user=$_SESSION["userid"];
	if ($user==""){
		  echo "Зарегистрируйтесь, пожалуйста";
	  }
	 
	if ($textcat!='' && $user!=''){
      $host='localhost';
        
      $mysqli =new mysqli($host, 'root', '', 'expenses');
	  if ($mysqli->connect_errno) {
      echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
      }
	  $textcat = $mysqli->real_escape_string($textcat);
      if ($mysqli->query("INSERT INTO `expenses`.`t_categories` (`category_name`,`user`) VALUES ('".$textcat."','".$user."')")=== FALSE) {
          printf("Ошибка при вставке данных в таблицу");
      }
      $mysqli->close();
	  unset($_POST);
	  $_POST = array();
	}
?>
<div class="menu"><a href="index.php">Главная</a></div>
<div class="input">
<form name="forminputcateg" action="" method="POST">
<div class="categorycat">
<label for="categorycat">Введите название категории:</label>
 <input type="text" id="categorycat" name="textcat" size="30px">
<div class="submit"><input type="submit" name="submitcat" value="OK"></div>
</div> <!--categorycat-->
</form>
</div> <!--categoryinput-->
<div class="itog">
<table class="tablecat">
<tr><th>Название категории</th></tr>
<?php
    $host='localhost'; 
    $user=$_SESSION["userid"];	
    $mysqli =new mysqli($host, 'root', '', 'expenses');
	if ($mysqli->connect_errno) {
    echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }
	$result=$mysqli->query("SELECT id,category_name FROM t_categories where user='".$user."'");
	
	while($row = mysqli_fetch_array($result))
    {
        echo '<tr><td>'.$row['category_name'].'</td></tr>';
    }

	$mysqli->close();
?>
</table>
</div> <!--itog-->
</body>
</html>