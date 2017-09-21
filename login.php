<?php
require_once('config/database.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
  try
  {
    $account = filter_input(INPUT_POST, 'account');
    $password = filter_input(INPUT_POST, 'password');

    /* Checking */
    if(!$account) throw new Exception("Invalid Account!");
    if(!$password) throw new Exception("Invalid Password!");

    /* Fetch from DB */
    $cmd = "SELECT * FROM Userinfo WHERE :account=ID AND :password=Password";
    $stm = $db->prepare($cmd);
    $stm->bindParam(':account', $account);
    $stm->bindParam(':password', $password);
    $stm->execute();

    $result = $stm->fetch(PDO::FETCH_ASSOC);
    if(!$result)  throw new Exception("Wrong Account or Password!");

    /* Record IP */
    $ip = "";
    $ips = ['HTTP_CLIENT_IP'            => $_SERVER['HTTP_CLIENT_IP'],
            'HTTP_X_FORWARDED_FOR'      => $_SERVER['HTTP_X_FORWARDED_FOR'],
            'HTTP_X_FORWARDED'          => $_SERVER['HTTP_X_FORWARDED'],
            'HTTP_X_CLUSTER_CLIENT_IP'  => $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'],
            'HTTP_FORWARDED_FOR'        => $_SERVER['HTTP_FORWARDED_FOR'],
            'HTTP_FORWARDED'            => $_SERVER['HTTP_FORWARDED'],
            'REMOTE_ADDR'               => $_SERVER['REMOTE_ADDR'],
            'HTTP_VIA '                 => $_SERVER['HTTP_VIA '] ];
    foreach($ips as $key => $val)
    {
      if($val != NULL)
      {
        $ip = $val;
        break;
      }
    }

    /* Update Last IP */
    $cmd = "UPDATE Userinfo SET LastIP=:ip WHERE :account=ID";
    $stm = $db->prepare($cmd);
    $stm->bindParam(':ip', $ip);
    $stm->bindParam(':account', $account);
    $stm->execute();

    /* Redirect */
    $_SESSION['uid']=$result['uid'];
    setcookie('uid',$result['uid']);
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

      <div id="content" class="container">
          <div class="col-md-8 col-md-offset-2">
              <h4>Login</h4>
              <br>
              <form method="post" action="login.php">
                	<label >ID</label>
                	<input class="form-control" name="account" id="account" onkeyup="checkRegAcc()" required>
                	<span id="msg_user_name"></span>
                	<br>
                	<label>Password</label>
                	<input class="form-control" type="password" name="password" id="password" required>
                	<br>
                	<input type="submit"  class="btn btn-primary"  id="submit" value="送出" style="float:right;">
                </form>
                <a href="signup.php">Sign Up</a>
            </div>
        </div>
