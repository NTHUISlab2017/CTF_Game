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
	
	$uid = $_SESSION['uid'];
	$sql = "SELECT * FROM Eventlog WHERE UID=$uid";
    $stm = $db->prepare($sql);
    $stm -> execute();
    $color = $stm->fetchAll(PDO::FETCH_ASSOC);
	
	foreach($color as $row){
		$correct[$row['PID']] = 1;
	}

    $count = 0;
?>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
  <style type="text/css">
    .problems {
      
      width:100%;
      height:150px;
    }
    .problem-instance {
        padding-bottom: 15px;
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
    .btsize{
		width:100;
	}
  </style>
</head>

<body>
  <div style='height: 54px;'></div>
  <div class="container containerr">
  <h3>CHALLENGES</h3>
    <hr>
   <script>
	function messageGo(pid){

	  var problemid = pid;
	  var flag = document.getElementById('flag' + pid).value;

		$.ajax({
			url:"flag.php",
			data: {"problemid":problemid,"flag":flag},
			type : "POST",
			dataType:'text',
			error:function(){
                alert("error");
                        },
			success:function(c){
			    alert(c) ;
			}
		});
	}

	</script>



	<?php
	  foreach($result as $row){
	?>
	  <?php
		if($count%4 == 0 ){
	  ?>
		<div class="row rowh problem-instance">
	  <?php
	    }
	  ?>

	  <?php 
		if($correct[$row['pid']]==1){
		 $color_ = '#fc8df1';
		}
		else{
	     $color_ = '#00DBDB';
		}
	  ?> 
	    <div class="col ">
        <button type="button" style="background-color:<?php echo $color_;?>;" class="btn btn-primary  problems" data-toggle="modal" data-target="#<?php echo"prob1em";echo $row['pid'];?>" role="button">
          <span class="tititle"><?php echo $row['Name']?></span><br><br>
          <span class="score"><i><?php echo $row['Point']?>pts</i></span><br>
        </button>

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
			  <form id="filedownload">
				<?php
				   $dir='./admin/'.(string)$row['pid'];
				   if(is_dir($dir)){
					   $file = scandir($dir);
					   for($i=2;$i<sizeof($file);$i++){
						   $n=$i-1;
				?>
				<a href="filedownload.php?file_name=<?php echo $file[$i];?>&probid=<?php echo $row['pid'];?>"><?php echo $file[$i];?></a>
				<?php
					   }
				   }
				?>
			  </form>
			  <form id="message_form" method="POST">
              <div class="modal-footer">
			    <input id="<?php echo 'flag'. $row['pid'];?>" class="form-control" type="text"  required>
                <button type="button" role="button" class="btn btn-primary" onclick="messageGo(<?php echo $row['pid'];?>)"><?php echo "Submit the FLAG"?></button>
			  </div>
			  </form>
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
</html>
