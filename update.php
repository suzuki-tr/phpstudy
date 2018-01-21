<?php
try{
	//update to DB param from POST
	$recipe_name = $_POST['recipe_name'];
	$category    = (int)$_POST['category'];
	$difficulty  = (int)$_POST['difficulty'];
	$budget      = (int)$_POST['budget'];
	$howto       = $_POST['howto'];

	if(empty($_POST['id'])) throw new Exception('No ID!');
	$id          = $_POST['id'];

	// get global params	
	require_once 'db_config.php';
	$dbh = new PDO('mysql:host=' . $host . ';dbname=' . $db . ';charset=utf8', $user, $pass);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);//solution of sql injection

	//use place holder
	$sql = "UPDATE recipes set recipe_name = ?, category = ?, difficulty = ?, budget = ?, howto = ? WHERE id = ?";
	$stmt = $dbh->prepare($sql);
	
	//set value to place holder
	$stmt->bindValue(1,$recipe_name, PDO::PARAM_STR);
	$stmt->bindValue(2,$category, PDO::PARAM_INT);
	$stmt->bindValue(3,$difficulty, PDO::PARAM_INT);
	$stmt->bindValue(4,$budget, PDO::PARAM_INT);
	$stmt->bindValue(5,$howto, PDO::PARAM_STR);
	$stmt->bindValue(6,$id, PDO::PARAM_INT);
	//execute sql and display data
	$stmt->execute();

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

}catch(Exception $e){
	echo "ERROR:" . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
	die(); //stop process
}
?>
