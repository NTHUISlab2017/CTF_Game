<?php
	if ($_POST) {
          
          require_once('config/database.php');
		  
		  $Modify = $_POST['Modify'];
          $Name = $_POST['Name'];
          $Point = $_POST['Point'];
          $Description = $_POST['Description'];
          $Flag = $_POST['Flag'];
          
          if($Name == "cuTeTurt1eDe1eteU"){
			  $sql = "DELETE FROM Challenge WHERE pid = $Point";
			  $statement = $pdo->prepare($sql);
		  }
          else if($Modify == -1){
			  $sql = "INSERT INTO Challenge VALUES(NULL,:Name,:Point,:Description,:Flag)";
		      $statement = $pdo->prepare($sql);
			  $statement->bindParam(':Name', $Name);
			  $statement->bindParam(':Point', $Point,PDO::PARAM_INT);
			  $statement->bindParam(':Description', $Description);
			  $statement->bindParam(':Flag', $Flag);
		  }else{
			  $sql = "UPDATE Challenge SET Name=:Name, Point=:Point, Description=:Description, Flag=:Flag WHERE pid=:Modify";
			  $statement = $pdo->prepare($sql);
              $statement->bindParam(':Name', $Name);
              $statement->bindParam(':Point', $Point,PDO::PARAM_INT);
              $statement->bindParam(':Description', $Description);
              $statement->bindParam(':Flag', $Flag);
              $statement->bindParam(':Modify', $Modify);

		  }
		  var_dump($statement->execute());
        
	}

?>
<?php
    require_once('config/database.php');
  
    $sql = "SELECT COUNT(*)as c FROM Challenge";
    $stm = $pdo->prepare($sql);
    $stm -> execute();
    $sum = $stm->fetch(PDO::FETCH_ASSOC);
    
    $sql = "SELECT * FROM Challenge";
    $stm = $pdo->prepare($sql);
    $stm -> execute();
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);

    $count = 0;
?>
<!-- Bootstrap CSS -->
  <head>
    <title>AddProblem</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <style type="text/css">
      .mid{
        position: absolute;
        width:600px;
        top:0;
        right:0;
        bottom:0;
        left:0;
        margin:auto;
      }
      .des{
        height:200;
      }
      .tableW_{
		  width:300px;
	  }
	  .tableW{
		  width:150px;
	  }
    </style>
  </head>

  <body>
  
    <!-- jQuery first, then Tether, then Bootstrap JS. -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
    <script>
    function doPost(modify)
    {
	  if(modify == -1){
	    var Modify = modify;
		var Name = document.getElementById('Name').value;
		var Point = document.getElementById('Point').value;
		var Description = document.getElementById('Description').value.replace(/\n|\r\n/g,"<br>");
		var Flag = document.getElementById('Flag').value;		
	  }
	  else{
	    var Modify = modify;
		var Name = document.getElementById('m_Name' + modify).value;
		var Point = document.getElementById('m_Point' + modify).value;
		var Description = document.getElementById('m_Description' + modify).value.replace(/\n|\r\n/g, "<br>");
		var Flag = document.getElementById('m_Flag' + modify).value;
	  }	  
      $.post("challenge.php",{Modify:Modify, Name:Name, Point:Point, Description:Description, Flag:Flag}, function(data){
        setTimeout('window.location.href = "challenge.php"',100)
     
	     })
    }
	function doDelete(pid)
	{
		
	  var Name = "cuTeTurt1eDe1eteU";
      var Point = pid;
      var Description = "0";
      var Flag = "0";
      $.post("challenge.php",{Name:Name, Point:Point, Description:Description, Flag:Flag}, function(data){
        setTimeout('window.location.href = "challenge.php"',100)
	     })
	}
    </script>

    <div id="content" class="container">
      
      <div class="col-md-8 col-md-offset-2 mid">
        <h2>Add problem</h2>
        <br>
        <form method="post" action="challenge.php">
          <div class="row">
            <div class="col">
            <label >Name</label>
              <input id="Name" class="form-control" type="text"  required>
            </div>
            <div class="col">
            <label>Point</label>
              <input id="Point" class="form-control" type="text"  required>
            </div>
          </div>
          
          <label>Description</label>
            <textarea id="Description" class="form-control des" type="text"  required></textarea>
          <label>Flag</label>
            <input id="Flag" class="form-control" type="text"  required>
          <br>
          <input type="button"  role="button" class="btn btn-primary"  value="Submit" style="float:right;" onclick="doPost(-1)">
        </form>
		<br><br>
		<h2>Modify problems</h2>
        <br>
		<table class="table">
		  <thead>
			<tr>
			  <th>Problem</th>
			  <th></th>
			  <th></th>
			</tr>
		  </thead> 
		  <tbody>
		  <?php
			foreach($result as $row)
			{
		  ?>
			<tr>
			  <td class = "tableW_"><?php echo $row['Name'] ?></td>
			  <td class = "tableW"><button type="button" role="button" data-toggle="modal" data-target="#<?php echo"delete". $row['pid'];?>" class="btn btn-outline-danger">Delete</button></td>
			  <div class="modal fade" id="<?php echo"delete". $row['pid'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				  <div class="modal-dialog" role="document">
					<div class="modal-content">
					  <div class="modal-body">
						<div class="alert alert-danger" role="alert">
						  <strong><?php echo "Determine to delete Problem ". $row['Name']. ' ?';?></strong>
						</div>
					  </div>
					  <div class="modal-footer">
						<button type="button" id="<?php echo"delete". $row['pid'];?>" class="btn btn-danger" role="button" onclick="doDelete(<?php echo $row['pid']?>)">Yes</button>
						<button type="button" class="btn btn-primary" role="button" data-dismiss="modal">No</button>
					  </div>
					</div>
				  </div>
			  </div>
			  <td class = "tableW"><button type="button" role="button" data-toggle="modal" data-target="#<?php echo"modify". $row['pid'];?>" class="btn btn-outline-primary">Modify</button></td>
			  <div class="modal fade" id="<?php echo"modify". $row['pid'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				  <div class="modal-dialog" role="document">
					<div class="modal-content">
					  <div class="modal-body">
					    <form method="post" action="challenge.php">
						  <div class="row">
							<div class="col">
							<label>Name</label>
							  <input id="<?php echo 'm_Name'. $row['pid'];?>" class="form-control" type="text" value="<?php echo $row['Name']?>" required>
							
							</div>
							<div class="col">
							<label>Point</label>
							  <input id="<?php echo 'm_Point'. $row['pid'];?>" class="form-control" type="text" value="<?php echo $row['Point']?>" required>
							</div>
						  </div>
						  <label>Description</label>
							<textarea id="<?php echo 'm_Description'. $row['pid'];?>" class="form-control des" type="text" required><?php echo $row['Description']?></textarea>
						  <label>Flag</label>
							<input id="<?php echo 'm_Flag'. $row['pid'];?>" class="form-control" type="text" value="<?php echo $row['Flag']?>" required>
						  <br>
						  <input type="button"  id="<?php echo 'modify'. $row['pid'];?>" role="button" class="btn btn-primary"  value="Submit" style="float:right;" onclick="doPost(<?php echo $row['pid'];?>)">
						</form>
					  </div>
					</div>
				  </div>
			  </div>
			  </tr>
		  <?php
			}
		  ?>
		  </tbody>
		</table>
      </div>
     
    </div>
  </body>
</html>
