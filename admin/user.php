<?php
require_once('../config/database.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	try
	{
		/* Scan */
		foreach($_POST as $uid => $value)
		{
			/* Choose to Delete ? */
			if(isset($_POST[$uid]))
			{
				$cmd = "DELETE FROM Userinfo WHERE uid=$uid";
				$stm = $db->prepare($cmd);
				$stm->execute();
			}
		}

		/* Redirect */
	    header('HTTP/1.1 302 Redirect'); 
	    header('Location: member.php');
	}
	catch(Exception $e)
	{
		header('HTTP/1.1 400 Bad request'); 
		echo $e->getMessage();
	}
}
?>

<html>
 	<!-- Bootstrap CSS -->
    <head>
    <title>member</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
      <style type="text/css">
        .problems {
          background-color:#FF0000;
        }
      </style>
    </head>

    <body>

    	<!-- jQuery first, then Tether, then Bootstrap JS. -->
    	<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
    	<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>

    	<form method="post" action="member.php">
	    	<table class="table table-hover">
			    <thead>
			      <tr>
			        <th>uid</th>
			        <th>ID</th>
			        <th>Password</th>
			        <th>Comment</th>
			        <th>Point</th>
			        <th>Email</th>
			        <th>LastIP</th>
			        <th><input type="submit" class="btn btn-danger" value="Delete"></th>
			      </tr>
			    </thead>

	    		<tbody>
	    			<?php
					try
					{
						/* Retreive All Users' Data */
						$cmd = "SELECT * FROM Userinfo";
						$stm = $db->prepare($cmd);
						$stm->execute();

						/* Print HTML */
						while($row = $stm->fetch(PDO::FETCH_ASSOC))
						{
							print "<tr>";
							foreach ($row as $item)    print "  <td>$item</td>\n";  
							/* check box */
							print '<td><div class="radio"><label><input type="radio" name="' . $row["uid"] . '"></label></div></td>';
							print "</tr>";

							$uid++;
						}
					}
					catch(Exception $e)
					{
						header('HTTP/1.1 400 Bad request'); 
						echo $e->getMessage();
					}
					?>
	    		</tbody>
	  		</table>
	  	</form>
    </body>
</html>
