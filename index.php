<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>PHP Study</title>
</head>
<body>
 <h1>PHP Study</h1>
 <p><h2>Let's study <em>basic rule</em> of HTML</h2></p>

<?php
	// get global params	
	require_once 'db_config.php';

try{

	$dbh = new PDO('mysql:host=' . $host . ';dbname=' . $db . ';charset=utf8', $user, $pass);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);//solution of sql injection

	$sql = "SELECT * FROM recipes";
	$stmt = $dbh->query($sql);
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

	echo '<table border="1">';
	echo '<tr><th>id</th><th>recipe_name</th><th>budget</th><th>difficulty</th><th>category</th><th>howto</th><th>detail</th><th>edit</th><th>delete</th></tr>';
	foreach ($result as $row) {
		echo '<tr>';
		echo "<td>". htmlspecialchars($row['id'],ENT_QUOTES,'UTF-8') ."</td>\n";
		echo "<td>". htmlspecialchars($row['recipe_name'],ENT_QUOTES,'UTF-8') ."</td>\n";
		echo "<td>". htmlspecialchars($row['budget'],ENT_QUOTES,'UTF-8') ."</td>\n";
		echo "<td>". htmlspecialchars($row['difficulty'],ENT_QUOTES,'UTF-8') ."</td>\n";
		echo "<td>". htmlspecialchars($row['category'],ENT_QUOTES,'UTF-8') ."</td>\n";
		echo "<td>". htmlspecialchars($row['howto'],ENT_QUOTES,'UTF-8') ."</td>\n";
		echo "<td><a href=detail.php?id=".$row['id'].">detail</a></td>\n";
		echo "<td><a href=edit.php?id=".$row['id'].">edit</a></td>\n";
		echo "<td><a href=del.php?id=".$row['id'].">delete</a></td>\n";
		echo '</tr>';
	}
	echo '</table>';
	$dbh = null;

}catch(Exception $e){
	echo "ERROR:" . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
	die(); //stop process
}
?>

 <p><h2>Add data to DB</h2>
  <table border='1'>
   <form method="post" action="add.php">
    <tr>
     <td>Recipe Name:</td>
     <td><input type="text" name="recipe_name" required></td>
    </tr>
    <tr>
     <td>Category:</td>
     <td>
      <select name="category">
       <option value="">choose</option>
       <option value="1">japanese</option>
       <option value="2">chinese</option>
       <option value="3">italian</option>
      </select>
     </td>
    </tr>
    <tr>
     <td>dificulty:</td>
     <td>
      <input type="radio" name="difficulty" value="1" required checked>easy
      <input type="radio" name="difficulty" value="2">difficult
     </td>
    </tr>
    <tr>
     <td>cost:</td>
     <td>
      <input type="number" min="1" max="99999" name="budget">
     </td>
    </tr>
    <tr>
     <td>memo:</td>
     <td>
      <textarea name="howto" maxlength="150">1.aaaaa
2.bbbbb
3.ccccc</textarea>
     </td>
    </tr>
    <tr>
     <td colspan="2"><input type="submit" value="send"></td>
    </tr>
   </form>
  </table>
 </p>
</body>
</html>

