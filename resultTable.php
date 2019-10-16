<!DOCTYPE html>
<html>
<head>
<style>
table {
  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

table td, table th {
  border: 1px solid #ddd;
  padding: 8px;
}

table tr:nth-child(even){background-color: #f2f2f2;}

table tr:hover {background-color: #ddd;}

table th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #4CAF50;
  color: white;
}
</style>
</head>
<body>

<?php
$servername = "localhost";
$username = "weedbayc_live232";
$password = "PaltrySnoutRambleTenet67";
$dbname = "weedbayc_weedbayc_live232";
$tb ='Tables_in_'.$dbname;
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}	
$sql_colunm="SHOW COLUMNS FROM ".$_GET['table'];
$result_colunm = $conn->query($sql_colunm);		
$fields = "";
$i = 0;
$colum_arr=array();
echo "<h4>Table name: ".$_GET['table']."</h4>";


$_string = $_GET['str'];
if(isset($_GET['text_replace'])){
	$_string = $_GET['text_replace'];
}

?>
<h5>Replace "<?php echo $_GET['str'];?>" to 
</br>
<form action="">
	<input type="text" value="<?php echo $_GET['text_replace'];?>" name="text_replace">
	<input type="hidden" value="<?php echo $_GET['table'];?>" name="table">
	<input type="hidden" value="<?php echo $_GET['str'];?>" name="str">
	<button>Replace</button>
</form>
</br>
<?php
while($row_column = $result_colunm->fetch_assoc()) {
	if($i>0){
		if($row_column['Type']!='int(11)'):
			$fields .= " OR BINARY ".$row_column['Field']." LIKE '%".$_string."%' "; 
		endif;
	}else{
		if($row_column['Type']!='int(11)'):
			$fields .= "BINARY ".$row_column['Field']." LIKE '%".$_string."%' "; 
		endif;
	}
	array_push($colum_arr,$row_column['Field']);
	$i++;
	if(isset($_GET['text_replace'])){
		$sql_replace="
		UPDATE ".$_GET['table']."
		SET ".$row_column['Field']." = replace(".$row_column['Field'].",'".$_GET['str']."','".$_GET['text_replace']."')";
		$conn->query($sql_replace);		
	}
	
}

$sql1 = "SELECT *  FROM ".$_GET['table']." WHERE  ".$fields;
$result1 = $conn->query($sql1);
if ($result1->num_rows > 0) {
	
	echo '<h4>'.$row["Tables_in_gotweed"].'</h4>';
	echo '<table>';
		echo '<thead>';
			echo '<tr>';
				echo '<th>N/A</th>';
				foreach($colum_arr as $col){
					echo '<th>'.$col.'</th>';
					
				}
			echo '</tr>';
		echo '</thead>';
		echo '<tbody>';
		$_count=0;
		while($row1 = $result1->fetch_assoc()) {
			$_count++;
			echo '<tr>';
			echo '<td>'.$_count.'</td>'; 
			foreach($row1 as $item){
				echo '<td>'.str_replace($_string,'<mark>'.$_string.'</mark>',$item).'</td>'; 
			}
			echo '</tr>';
		}
		echo '</tbody>';
	echo '</table>'; 
}

?>

</body>
</html>
<?php $conn->close();?>