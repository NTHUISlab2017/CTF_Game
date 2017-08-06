<!-- Bootstrap CSS -->
<head>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
  <style type="text/css">
    .problems {
      background-color:	#00DBDB;
      width:100%;
      height:150;
    }
    .rowh{
      height:170;
    }
    .containerr{
      width: 900px;
      max-width: 100%;
    }
	.problemDes{
	  min-height:150;
	  word-wrap:break-word;
	}
    
  </style> 
</head>

<body>
  


<!-- jQuery first, then Tether, then Bootstrap JS. -->
<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
<?php
    require_once('config/database.php');
    
    $sql = "SELECT * FROM about" ;
    $result = mysql_query($query) ;
    
    ?>


<h3>Announcement</h3>
// ?
<br>




<div class = "container containerr">

<table border = "1">
    <?php
        while($row = mysqli_fetch_array($result)){
            echo "<tr><td>" . $row['Date'] . "</td><td>" . $row['Type'] . "</td><td>" $row['Announcement'] . "</td></tr>" ;
        }
    
    ?>
</table>











































/*
<table id='t' style="width: 100%" border = "1">
<colgroup>
<col style="width:60px">
<col style="width:60px">
<col style="width:450px">
<col style="width:100px">
</colgroup>
<thead>
<tr id='r'>
<th>Date</th><th>Type</th><th>Announcement</th><th>Flag</th>
</tr>
<tr id = 'r'>
<td><?php echo $row['Date']?></td>
<td><?php echo $row['Type']?></td>
<td><?php echo $row['Announcement']?></td>
<td><?php echo $row['Flag']?></td>
</thead>


</table>
<div id='disp'></div>
*/
