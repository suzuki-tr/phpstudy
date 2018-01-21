<?php
try{
	//add to DB param from POST
	$recipe_name = $_POST['recipe_name'];
	$category    = (int)$_POST['category'];
	$difficulty  = (int)$_POST['difficulty'];
	$budget      = (int)$_POST['budget'];
	$howto       = $_POST['howto'];

	// get global params	
	require_once 'db_config.php';
	$dbh = new PDO('mysql:host=' . $host . ';dbname=' . $db . ';charset=utf8', $user, $pass);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);//solution of sql injection

	//use place holder
	$sql = "INSERT INTO recipes (recipe_name, category, difficulty, budget, howto) VALUES (?, ?, ?, ?, ?)";
	$stmt = $dbh->prepare($sql);
	
	//set value to place holder
	$stmt->bindValue(1,$recipe_name, PDO::PARAM_STR);
	$stmt->bindValue(2,$category, PDO::PARAM_INT);
	$stmt->bindValue(3,$difficulty, PDO::PARAM_INT);
	$stmt->bindValue(4,$budget, PDO::PARAM_INT);
	$stmt->bindValue(5,$howto, PDO::PARAM_STR);
	//execute sql and display data
	$stmt->execute();

	$sql = "SELECT * FROM recipes WHERE recipe_name = ? and category= ? and difficulty = ? and budget = ? and howto = ?";
	$stmt = $dbh->prepare($sql);
	$stmt->bindValue(1,$recipe_name, PDO::PARAM_STR);
	$stmt->bindValue(2,$category, PDO::PARAM_INT);
	$stmt->bindValue(3,$difficulty, PDO::PARAM_INT);
	$stmt->bindValue(4,$budget, PDO::PARAM_INT);
	$stmt->bindValue(5,$howto, PDO::PARAM_STR);
	$stmt->execute();
	$result = $stmt->fetch(PDO::FETCH_ASSOC);

	echo '<p>Added following data.</p>';
	echo '<table border="1">';
	echo '<tr><th>id</th><th>recipe_name</th><th>budget</th><th>difficulty</th><th>category</th><th>howto</th></tr>';
	echo '<tr>';
	echo "<td>". htmlspecialchars($result['id'],ENT_QUOTES,'UTF-8') ."</td>\n";
	echo "<td>". htmlspecialchars($result['recipe_name'],ENT_QUOTES,'UTF-8') ."</td>\n";
	echo "<td>". htmlspecialchars($result['budget'],ENT_QUOTES,'UTF-8') ."</td>\n";
	echo "<td>". htmlspecialchars($result['difficulty'],ENT_QUOTES,'UTF-8') ."</td>\n";
	echo "<td>". htmlspecialchars($result['category'],ENT_QUOTES,'UTF-8') ."</td>\n";
	echo "<td>". htmlspecialchars($result['howto'],ENT_QUOTES,'UTF-8') ."</td>\n";
	echo '</tr>';
	echo '</table>';
	echo '<a href=index.php>retun</a>';
	$dbh = null;


}catch(Exception $e){
	echo "ERROR:" . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
	die(); //stop process
}
?>
