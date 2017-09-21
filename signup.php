<?php
require_once('config/database.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
  try
  {
    $account = filter_input(INPUT_POST, 'account');
    $password = filter_input(INPUT_POST, 'password');
    $password2 = filter_input(INPUT_POST, 'password2');
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $comment = filter_input(INPUT_POST, 'comment');

    /* Checking */
    if(!$account) throw new Exception("Invalid Account!");
    if(!$password) throw new Exception("Invalid Password!");
    if(!$email) throw new Exception("Invalid Email!");
    if(!comment) throw new Exception("Invalid Comment!");
    if(strcmp($password, $password2) != 0) throw new Exception("Please Confirm Password!");

    /* Account Already Exitst ? */
    $cmd = "SELECT * FROM Userinfo WHERE :account=ID";
    $stm = $db->prepare($cmd);
    $stm->bindParam(':account', $account);
    $stm->execute();
    $result = $stm->fetch(PDO::FETCH_ASSOC);
    if($result) throw new Exception("Account Already Exist!");


    /* Insert to DB */
    $cmd = "INSERT INTO Userinfo VALUES(NULL, :account, :password, :email, :comment, '','')";
    $stm = $db->prepare($cmd);
    $stm->bindParam(':account', $account);
    $stm->bindParam(':password', $password);
    $stm->bindParam(':email', $email);
    $stm->bindParam(':comment', $comment);
    $stm->execute();

    /* Create a container for this user */
    $cmd = "SELECT * FROM Userinfo WHERE :account=ID";
    $stm = $db->prepare($cmd);
    $stm->bindParam(':account', $account);
    $stm->execute();

    $result = $stm->fetch(PDO::FETCH_ASSOC);
    if(!$result)  throw new Exception("Cannot Find Account For Creating Container!");
    $uid = $result['uid'];
    system("docker create -it --name user-$uid -v challenge:/challenge:ro --storage-opt" . ' --memory="500m" --cpus=".5" duckll/ctf-box');

    /* Redirect */
    header('HTTP/1.1 302 Redirect'); 
    header('Location: index.php');
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
    <title>signup</title>
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

      <div id="content" class="container">
          <div class="col-md-8 col-md-offset-2">
              <h4>Register</h4>
              <br>
              <form method="post" action="signup.php">
                  <label >ID</label>
                  <input class="form-control" name="account" id="account" onkeyup="checkRegAcc()" required>
                  <span id="msg_user_name"></span>
                  <br>
                  <label>Password</label>
                  <input class="form-control" type="password" name="password" id="password" required>
                  <label>Confirm Password</label>
                  <input class="form-control" type="password" name="password2" id="password2" required>
                  <label>Email</label>
                  <input class="form-control" type="text" name="email" required>
                  <label>Comment</label>
                  <input class="form-control" type="text" name="comment" required>
                  <br>
                  <input type="submit"  class="btn btn-primary"  id="submit" value="送出" style="float:right;">
                </form>
            </div>
        </div>
    </body>
</html>