<?php
	//edit data from DB
try{
	if (empty($_GET['id'])) throw new Exception('No id.');
	$id = (int)$_GET['id'];

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
	//$stmt = $dbh->query($sql);
	$result = $stmt->fetch(PDO::FETCH_ASSOC);
	$dbh = null;
}catch(Exception $e){
	echo "ERROR:" . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
	die(); //stop process
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>PHP Study</title>
</head>
<body>
	<p>Edit data
	<table border='1' width="80%">
		<form method="post" action="update.php">
		<tr>
			<td>Recipe Name:
			</td>
			<td>
				<input type="text" name="recipe_name" value="<?php echo htmlspecialchars($result['recipe_name'],ENT_QUOTES,'UTF-8'); ?>" required>
			</td>
		</tr>
		<tr>
			<td>Category:
			</td>
			<td>
				<select name="category">
				<option value="1" <?php if ($result['category'] === 1) echo "selected" ?>>japanese</option>
				<option value="2" <?php if ($result['category'] === 2) echo "selected" ?>>chinese</option>
				<option value="3" <?php if ($result['category'] === 3) echo "selected" ?>>italian</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>dificulty:
			</td>
			<td>
				<input type="radio" name="difficulty" value="1" <?php if ($result['difficulty'] === 1) echo "checked" ?>>easy
				<input type="radio" name="difficulty" value="2" <?php if ($result['difficulty'] === 2) echo "checked" ?>>difficult
			</td>
		</tr>
		<tr>
			<td>cost:
			</td>
			<td>
				<input type="number" min="1" max="99999" name="budget" value="<?php echo htmlspecialchars($result['budget'],ENT_QUOTES,'UTF-8'); ?>" >
			</td>
		</tr>
		<tr>
			<td>memo:
			</td>
			<td>
				<textarea name="howto" cols="40" rows="4" maxlength="150"><?php echo htmlspecialchars($result['howto'],ENT_QUOTES,'UTF-8'); ?></textarea>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<input type="hidden" name="id" value="<?php echo htmlspecialchars($result['id'],ENT_QUOTES,'UTF-8'); ?>">
				<input type="submit" value="send">
			</td>
		</tr>
		</form>
	</table>
	</p>
</body>
</html>
