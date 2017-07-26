<?php
	if ($_POST) {
          
          require_once('config/database.php');
          
          $Name=$_POST['Name'];
          $Point=$_POST['Point'];
          $Description=$_POST['Description'];
          $Flag=$_POST['Flag'];
          
           
          $sql = "INSERT INTO Challenge VALUES(NULL,:Name,:Point,:Description,:Flag)";
          $statement = $pdo->prepare($sql);
          $statement->bindParam(':Name',$Name);
          $statement->bindParam(':Point',$Point,PDO::PARAM_INT);
          $statement->bindParam(':Description',$Description);
          $statement->bindParam(':Flag',$Flag);
 
          var_dump($statement->execute());
        
	}

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
     
    </style>
  </head>

  <body>

    <!-- jQuery first, then Tether, then Bootstrap JS. -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
    <script>
      function doPost()
    {
     
      var Name = document.getElementById('Name').value;
      var Point = document.getElementById('Point').value;
      var Description = document.getElementById('Description').value.replace(/\n|\r\n/g,"<br>");
      var Flag = document.getElementById('Flag').value;
      document.write("");
      $.post("challenge.php",{Name:Name, Point:Point, Description:Description, Flag:Flag}, function(data){
     window.location.href = "challenge.php";
	     })
    }
    </script>

    <div id="content" class="container">
      
      <div class="col-md-8 col-md-offset-2 mid">
        <h2>Add Problem</h2>
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
          <input type="submit"  role="button" class="btn btn-primary"  value="Submit" style="float:right;" onclick="doPost()">
        </form>
      </div>
     
    </div>
  </body>
</html>
