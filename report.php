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
Отчет
</title>
</head>
<body>
<div class="menuabout"><a href="index.php">Главная</a></div>
<div class="dateinp">
<form name="formperiod" action="" method="POST">
 <label for="datefrom">Дата с:</label>
 <input type="date" id="datefrom" name="datefrom">
  <label for="dateto">Дата по:</label>
 <input type="date" id="dateto" name="dateto">
 <div class="submit"><input type="submit"  value="OK"></div>
 </form>
</div> <!--dateinp-->
<div class="report">
<table class="tablereport">
<tr><th>Расходы за период</th></tr>
<?php
    $host='localhost'; 
    $user=$_SESSION["userid"];
    $datefrom=$_POST["datefrom"];	
	$dateto=$_POST["dateto"];
	//$dateinpend=date("Y-m-d", (time()+3600*24));
    if (isset($datefrom) && isset($dateto)){
    $mysqli =new mysqli($host, 'root', '', 'expenses');
	if ($mysqli->connect_errno) {
    echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }
	$result=$mysqli->query("SELECT category, sum(amount) as amount_all, category_name FROM t_expenses, t_categories where 
	                        t_expenses.category=t_categories.id and dateinp between '". $datefrom."' and '".$dateto."' and t_expenses.user='".$user."'
							group by category, category_name");
	
	while($row = mysqli_fetch_array($result))
    {
        echo '<tr><td>'.$row['category_name'].'</td><td>'.$row['amount_all'].'</td></tr>';
    }

	$mysqli->close();
	}	
?>
</table>
</div><!--report-->
</body>
</html>