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

  <?php
    require_once('config/database.php');
  
    $sql = "SELECT COUNT(*)as c FROM Challenge";
    $stm = $db->prepare($sql);
    $stm -> execute();
    $sum = $stm->fetch(PDO::FETCH_ASSOC);
    
    $sql = "SELECT * FROM Challenge";
    $stm = $db->prepare($sql);
    $stm -> execute();
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);

    $count = 0;
  ?>
  

  <h3>CHALLENGES</h3>
    <hr>
  <div class="container containerr">
  
	<?php
	  foreach($result as $row){
	?>
	  <?php
		if($count%4 == 0 ){
	  ?>
		<div class="row rowh">
	  <?php
	    }
	  ?>
	  
		<div class="col ">
        <button type="button" class="btn btn-primary  problems" data-toggle="modal" data-target="#<?php echo"prob1em";echo $row['pid'];?>" role="button">
          <span class="tititle"><?php echo $row['Name']?></span><br><br>
          <span class="score"><i><?php echo $row['Point']?>pts</i></span><br>
        </button>

        <!-- Modal -->
        <div class="modal fade" id="<?php echo"prob1em";echo $row['pid'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?php echo $row['Name']?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body problemDes">
                <?php echo $row['Description']?>
              </div>
              <div class="modal-footer">
			    <input id="Flag" class="form-control" type="text"  required>
                <button type="button" class="btn btn-primary"><?php echo "Submit the FLAG"?></button>
			  </div>
            </div>
          </div>
        </div>
      </div>
	  <?php
		if($count+1 == $sum["c"] && $count%4 != 3){
	  ?>
		<?php
		  for($i=0; $i<3-$count%4; $i++){
		?>
			<div class="col ">
			</div>
		<?php
		  }
		?>
	  <?php
		}
	  ?>
	  <?php
		if($count%4 == 3){
	  ?>
		</div>
	  <?php
	    }
	  ?>
      <?php
	    $count++;
	  ?>
	<?php
	  }
	?>

  </div>
  
  
</body>