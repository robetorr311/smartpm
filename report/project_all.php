<?php
include('connection.php');?>
<html>
	<head>
		<title>Roofing Project</title>
		<meta charset="utf-8"/>
		<style>
		th, tr {
    padding: 10px;
    color: black;
    font-size: 16px;
    font-weight: bold;
}
table{margin:0 auto;margin-top:100px}</style>
</head><body style="background: #12A5A5;text-align: center;">
<?php
$sql = "SELECT * FROM roofing_project";
$result = $conn->query($sql);
$i=1;
if ($result->num_rows > 0) {
    // output data of each row
	
	?>
	<table border="1">
		<tr>
			<th>Sr. No.</th>
			<th>Name</th>
			<th>Address</th>
			<th>Phone</th>
			<th>PDF File</th>
		</tr>
	
	<?php
    while($row = $result->fetch_assoc()) {
      ?><tr>
		<td><?php echo $i; ?></td>
		<td><?php echo $row['name']; ?></td>
		<td><?php echo $row['address']; ?></td>
		<td><?php echo $row['phone']; ?></td>
		<td><a href="pdffile.php?id=<?php echo $row['id'];?>" target="_blank">Click</a></td>
	  </tr>
<?php $i++;
	  }
	   ?>
	   </table>
	   <?php 
	   }?>
	   
	   </body></html>