<?php
session_start();
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="cost, expense"/>
<meta name="description" content="Программа по учету расходов"/>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="image/money.png" rel="short icon" type="image/x-icon" />
<title>
Учет расходов
</title>
</head>
<body>
<?php     
	$category=$_POST["category"];
	$amount=$_POST["amount"];
	$dateinp=date("Y-m-d");
	$user=$_SESSION["userid"];
	
      if ($user==""	){
		  echo "Зарегистрируйтесь, пожалуйста";
	  }	
	if ($category!='' && is_numeric($amount)===TRUE && $user!=""){
      $host='localhost';
 		  
      $mysqli =new mysqli($host, 'root', '', 'expenses');
	  if ($mysqli->connect_errno) {
      echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
      }
      if ($mysqli->query("INSERT INTO `expenses`.`t_expenses` (`category`,`amount`,`user`,`dateinp`) VALUES ('".$category."','".$amount."','".$user."','".$dateinp."')")=== FALSE) {
          printf("Ошибка при вставке данных в таблицу");
      }
      $mysqli->close();
	  unset($_POST);
	  $_POST = array();
	}
?>
<div class="menu"><a href="categories.php">Заполнить категории</a>
<a href="report.php">Отчет</a></div> <!--menu-->
<div class="menuright"><a href="about.php">Обо мне</a>
<a href="registration.php">Войти</a>
</div> <!--menuright-->

<div class="input">
<form name="forminput" action="" method="POST">
<div class="category">
 <label for="category">Категория:</label>
 <?php
    $host='localhost';
    $user=$_SESSION["userid"];	
    $mysqli =new mysqli($host, 'root', '', 'expenses');
	if ($mysqli->connect_errno) {
    echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }
	$result=$mysqli->query("SELECT id,category_name FROM t_categories where user='".$user."'");
	
	echo '<select name="category" id="category">';

    while($row = mysqli_fetch_array($result))
    {
       echo '<option value='.$row['id'].'>'.$row['category_name'].'</option>';
    }

	$mysqli->close();
?>
</select>
</div> <!--category-->
<div class="amount">
 <label for="amount">Сумма:</label>
 <input type="text" id="amount" name="amount" font-size="30px">
</div> <!--amount-->
<!--<div class="dateinp">
 <label for="dateinp">Дата:</label>
 <input type="date" id="dateinp" font-size="30px">
</div> <!--dateinp-->
<div class="submit"><input type="submit"  value="OK"></div>
</form>
</div> <!--input-->
<div class="itog">
<table class="tablecat">
<tr><th>Расходы</th></tr>
<?php
    $host='localhost'; 
    $user=$_SESSION["userid"];
    $dateinp=date("Y-m-d");	
	//$dateinpend=date("Y-m-d", (time()+3600*24));
 
    $mysqli =new mysqli($host, 'root', '', 'expenses');
	if ($mysqli->connect_errno) {
    echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }
	$result=$mysqli->query("SELECT category, amount, category_name FROM t_expenses, t_categories where 
	                        t_expenses.category=t_categories.id and dateinp = '". $dateinp."' and t_expenses.user='".$user."'");
	
	while($row = mysqli_fetch_array($result))
    {
        echo '<tr><td>'.$row['category_name'].'</td><td>'.$row['amount'].'</td></tr>';
    }

	$mysqli->close();

?>
</table>
</div> <!--itog-->
</body>
</html>