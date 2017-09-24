<html>
 	<!-- Bootstrap CSS -->
    <head>
    <title>rank</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
      <style type="text/css">
        .problems {
          background-color:#FF0000;
        }
      </style>
    </head>

    <body>

	
    	<table class="table table-hover">
		    <thead>
		      <tr>
		        <th>Rank</th>
		        <th>ID</th>
		        <th>Point</th>
		      </tr>
		    </thead>

    		<tbody>
    			<?php
    			require_once('config/database.php');
				try
				{
					/* Retreive Users' Data in order */
					$cmd = "SELECT ID, Point FROM Userinfo ORDER BY Point DESC";
					$stm = $db->prepare($cmd);
					$stm->execute();

					/* Print HTML */
					$i = 1;
					while($row = $stm->fetch(PDO::FETCH_ASSOC))
					{
						print "<tr>";

						/* Rank */	
						print "  <td>$i</td>\n";	
						$i++;

						/* Info*/
						foreach ($row as $item)    print "  <td>$item</td>\n";  
						
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

    </body>
</html>
