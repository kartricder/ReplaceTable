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
Enter text need replace
</br>
<form action="">
	<input type="text" value="<?php echo $_GET['str'];?>" name="str">
	<button>Search</button>
</form>
<br/>
<?php if(isset($_GET['str'])):?>
<?php
$servername = "localhost";
$username = "weedbayc_live232";
$password = "PaltrySnoutRambleTenet67";
$dbname = "weedbayc_weedbayc_live232";
$tb ='Tables_in_'.$dbname;
$_string = $_GET['str'];
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "show tables from ".$dbname;
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
	 echo '<table>';
		echo '<thead>';
			echo '<tr>';
				echo '<th>';
					echo 'N/A';
				echo '</th>';
				echo '<th>';
					echo 'Table Name';
				echo '</th>';
				echo '<th>';
					echo 'Action';
				echo '</th>';
				echo '<th>';
					echo 'SQL';
				echo '</th>';
			echo '</tr>';
		echo '</thead>';
		echo '<tbody>';
			$count = 0;
			while($row = $result->fetch_assoc()) {
				
				$sql_colunm="SHOW COLUMNS FROM ".$row[$tb];
				$result_colunm = $conn->query($sql_colunm);		
				$fields = "";
				$i = 0;
				$colum_arr=array();
				while($row_column = $result_colunm->fetch_assoc()) {
					if($i>0){
						if($row_column['Type']!='int(11)'):
							$fields .= " OR BINARY ".$row_column['Field']." LIKE '%".$_GET['str']."%' "; 
						endif;
					}else{
						if($row_column['Type']!='int(11)'):
							$fields .= "BINARY ".$row_column['Field']." LIKE '%".$_GET['str']."%' "; 
						endif;
					}
					array_push($colum_arr,$row_column['Field']);
					$i++;
					
				}
				$sql1 = "SELECT *  FROM ".$row[$tb]." WHERE  ".$fields;
				$result1 = $conn->query($sql1);
				
				if ($result1->num_rows > 0) {
						$count++;
						echo '<tr>';
						echo '<td>';
							echo '<h4>'.$count.'</h4>';
						echo '</td>';
						echo '<td>';
							echo '<h4>'.$row[$tb].'</h4>';
						echo '</td>';
						echo '<td>';
							echo "<a href='resultTable.php?table=".$row[$tb]."&str=".$_GET['str']."'>Browse</a>";
						echo '</td>';
						echo '<td>'.str_replace($_string,'<mark>'.$_string.'</mark>',$sql1).'</td>';
					echo '</tr>';
				}
				
			}
		if($count==0){
			echo '<tr>';
				echo '<td colspan="4">';
					echo 'not found';
				echo '</td>';
			echo '</tr>';
		}
		echo '</tbody>';
	echo '</table>';
	
} else {
    echo "0 results";
}
$conn->close();
endif;
?>
</body>
</html>