<?php
//get param from url
//display param type
//	var_dump($_GET);


try{
	//if param existing
	if (empty($_GET['id'])) throw new Exception('No ID');
	//change string to int
	$id = (int)$_GET['id'];

	//place holder
	$sql = "SELECT * FROM recipes WHERE id = ?";

	// get global params	
	require_once 'db_config.php';
	$dbh = new PDO('mysql:host=' . $host . ';dbname=' . $db . ';charset=utf8', $user, $pass);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);//solution of sql injection

	//use place holder
	$sql = "SELECT * FROM recipes WHERE id = ?";
	$stmt = $dbh->prepare($sql);
	
	//set value to place holder
	$stmt->bindValue(1,$id, PDO::PARAM_INT);

	//execute sql and display data
	$stmt->execute();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	echo '<table border="1" width="80%">';
	echo '<tr><th>recipe_name</th><th>budget</th><th>difficulty</th><th>howto</th></tr>';
	foreach ($result as $row) {
		echo '<tr>';
		echo "<td>". htmlspecialchars($row['recipe_name'],ENT_QUOTES,'UTF-8') ."</td>\n";
		echo "<td>". htmlspecialchars($row['budget'],ENT_QUOTES,'UTF-8') ."</td>\n";
		echo "<td>". htmlspecialchars($row['difficulty'],ENT_QUOTES,'UTF-8') ."</td>\n";
		echo "<td>". nl2br(htmlspecialchars($row['howto'],ENT_QUOTES,'UTF-8')) ."</td>\n";
		echo '</tr>';
	}
	echo '</table>';
	echo '<a href=index.php>retun</a>';

	$dbh = null;


}
catch(Exception $e){
	echo "ERROR:" . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
	die(); //stop process
}
?>




