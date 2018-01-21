<?php
try{
	//del from DB param from POST
	$id = (int)$_GET['id'];

	// get global params	
	require_once 'db_config.php';
	$dbh = new PDO('mysql:host=' . $host . ';dbname=' . $db . ';charset=utf8', $user, $pass);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);//solution of sql injection

	//use place holder
	$sql = "DELETE FROM recipes WHERE id = ?";
	$stmt = $dbh->prepare($sql);
	
	//set value to place holder
	$stmt->bindValue(1,$id, PDO::PARAM_INT);
	//execute sql and display data
	$stmt->execute();
	$dbh = null;
	echo '<p>Deleted.</p>';
	echo '<a href=index.php>retun</a>';


}catch(Exception $e){
	echo "ERROR:" . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
	die(); //stop process
}
?>
