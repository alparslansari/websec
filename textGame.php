<!DOCTYPE html>
<?php
session_start();
?>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>An awesome game ...</title>

    <!-- Bootstrap -->
    <link href="./css/bootstrap.min.css" rel="stylesheet">
    <link href="./css/jumbotron-narrow.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
      <style>
      .red {
        color: #d14;
      }
      </style>
  
  </head>
  <body>
      <div class="container">
      <div class="header clearfix">
        <nav>
          <ul class="nav nav-pills pull-right">
            <li role="presentation" class="active"><a href="#">Home</a></li>
            <li role="presentation"><a href="#">About</a></li>
            <li role="presentation"><a href="logout.php">Logout</a></li>
          </ul>
        </nav>
        <h3 class="text-muted">Text twist</h3>
      </div>
      
<?php if(!isset($_SESSION['user'])) {?>
  <div class="jumbotron">
    <h1>Do you want to play a cool game?</h1>
    <p class="lead">Do not be shy!.</p>
    <div class="col-lg-6">
      Sign in
      <form class="form-signin" name='signinFrm' action="textGame.php" method="post">
        <div class="form-group">
          <div class="input-group">
            <span class="input-group-addon" id="usrname" name="usrname">@</span>
            <input type="text" class="form-control" placeholder="Username" aria-describedby="usrname" id="username" name="username">
          </div>
          
          <div class="input-group">
            <span class="input-group-addon" id="psscode" name="psscode">P</span>
            <input type="password" class="form-control" placeholder="Password" aria-describedby="psscode" id="passcode" name="passcode">
          </div>
          <button class="btn btn-sm btn-success pull-right" id="signin" name="signin" value="signin" type="submit">Sign-in</button>
        </div>
      </form>
    </div>
    <div class="col-lg-6">
      Register
      <form class="form-signin" name='signupFrm' action="textGame.php" method="post">
      <div class="input-group">
        <span class="input-group-addon" id="basic-addon1">@</span>
        <input type="text" class="form-control" placeholder="Username" aria-describedby="basic-addon1" id="username1" name="username1">
      </div>
          
      <div class="input-group">
        <span class="input-group-addon" id="passcode1" name="psscode1">P</span>
        <input type="password" class="form-control" placeholder="Password" aria-describedby="psscode1" id="passcode1" name="passcode1">
      </div>
    
      <div class="input-group">
        <span class="input-group-addon" id="passcode2" name="psscode2">P</span>
        <input type="password" class="form-control" placeholder="Password - retype" aria-describedby="psscode2" id="passcode2" name="passcode2">
      </div>
      <button class="btn btn-sm btn-primary pull-right" id="signup" name="signup" value="signup" type="submit">Sign-up</button>
      </form>
    </div>
    
    <div class="col-lg-6 pull-right" id ="signuperr" style="display:none;">
    </div>
    
    <div class="col-lg-12"><br></div>
    <div class="col-lg-12" id="signerr" style="display:none;">        
      <div class="alert alert-danger" role="alert" >
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        <span class="sr-only">Error:</span>
        <h4><strong>Incorrect</strong> username or password!</h4>
      </div>
    </div>
    <br><br><br><br><br><br><br><br><br><br><br>
  </div>
      
      <footer class="footer">
        <p>&copy; 2015 ASAS</p>
      </footer>

      <?php } else { 
      
      // This is where user in SESSION
      ?>
      <div class="jumbotron">
        <h1><?php echo $_SESSION['user']; ?>, Shall we play a game?</h1>
        <p class="lead">Do not be shy!.</p>
        <!-- <h3>Message to be:</h3> -->
      </div>
      
      <div class="row marketing">
        <div class="col-lg-6">
          <h4>Twist it!</h4>
          <div>
            <canvas id="myCanvas" width="200" height="100"></canvas>
          </div>

              <div>
                  <table>
                      <tr>
                          <td>
                              <b>Attempt:</b>
                          </td>
                          <td id="attemptID">
                          </td>
                      </tr>
                      <tr>
                          <td>
                              <b>Score:</b>
                          </td>
                          <td id="scoreID">
                          </td>
                      </tr>
                      <tr>
                          <td>
                              <b>Rack:</b>
                          </td>
                          <td id="rackID">
                          </td>
                      </tr>
                      <tr>
                          <td><b>Your guesses:</b></td>
                          <td id="guessID">
                          </td>
                  </table>
                  
              </div>
              
              <div>
                <input type="text" name="wordGuess" id="wordGuess" maxlength="7"/> <a class="btn btn-lg btn-success" id="sbtGuess" href="#" role="button">Submit</a>
            </div>
            
            
            <div class="btn-grp">
              <br>
                <p><a class="btn btn-lg btn-danger" id="resetGame" href="#" role="button">I gave up! Pardon me! Please!</a></p>
                  
            </div>
    
        </div>

        <div class="col-lg-6">
          <h4><?php echo $_SESSION['user']; ?>, This will be your Fate!</h4>
          <canvas id="gameBoard" width="350" height="410"></canvas>
      </div>

      <footer class="footer">
        <p>&copy; 2015 ASAS</p>
      </footer>
      </div>
      <?php } ?>
      


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <?php if(isset($_SESSION['user'])) {?>
    <script src="js/textLIB.js"></script>
    <?php } ?>
  </body>
  
  <script>
    function signin()
    {
        document.getElementById("signerr").style.display="block";
        document.getElementById("usrname").focus()   
    }
    function signup(incele)
    {
    	document.getElementById("signuperr").innerHTML= incele;
      document.getElementById("signuperr").style.display="block";
      document.getElementById("username1").focus();
    }
  </script>
  
  
  <?php


if (isset($_POST['signin'])) {
    //print_r($_POST);

    $username = $_POST['username'];
	  $password = md5($_POST['passcode']); // Encrypts the password.
    //echo "-".$password."-";
    
    //this is the basic way of getting a database handler from PDO, PHP's built in quasi-ORM
    $dbhandle = new PDO("sqlite:texttile.db") or die("Failed to open DB");
    if (!$dbhandle) die ($error);
    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    //echo $query;
    //this next line could actually be used to provide user_given input to the query to 
    //avoid SQL injection attacks
    $statement = $dbhandle->prepare($query);
    $statement->execute();
    //$arr = $statement->errorInfo();
    //print_r($arr);
    $results = $statement->fetch();
    //print_r($results);
    //echo $results['username'];
    if(isset($results['username'])){
      // There is something in the db. The username/password match up.
       $_SESSION['user']=$username;
       echo "<script>window.location.replace('textGame.php');</script>";
       //header("Location: /textGame.php");
       exit;
    }
    else
    {
      // PASSWORD IS NOT MATCHED WITH USER
      echo "<script type=\"text/javascript\">signin();</script>";
			exit(); // Stops the script with an error message.
    }
    
}

if (isset($_POST['signup'])) {
  $password1 = $_POST['passcode1'];
  $password2 = $_POST['passcode2'];
  $username = $_POST['username1'];
  $errmsg = "<ul>";
  
  if ($username == "") 
  { // Checks for blanks.
    $errmsg = $errmsg."<li class='red'><strong>Username</strong> is missing!</li>";
  }
    
  //password1 and password2 needs to be same! Do validation!
	if ($password1 != $password2) 
  { // Checks for pass consistency
        $errmsg = $errmsg."<li class='red'><strong>Passwords</strong> does not match!</li>";
  }
  
  
  if(strlen($errmsg) < 5)
  {
    // Should be no error until here
    $password = md5($password1);
    $dbhandle = new PDO("sqlite:texttile.db") or die("Failed to open DB");
    if (!$dbhandle) die ($error);
    $query = "INSERT INTO users (username,password) VALUES ('$username','$password')";
    $statement = $dbhandle->prepare($query);
    $statement->execute();
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);
    $count = $statement->rowCount();
    if($count==1){
       $_SESSION['user']=$username;
       echo "<script>window.location.replace('textGame.php');</script>";
       //header("Location: /textGame.php");
       exit;
    } else {
       $errmsg = "<li class='red'>Username is taken!</li>";
       $errmsg = $errmsg."</ul>";
       echo "<script type=\"text/javascript\">signup(\"$errmsg\");</script>";
       exit();
    }
  }
  else
  {
    $errmsg = $errmsg."</ul>";
    echo "<script type=\"text/javascript\">signup(\"$errmsg\");</script>";
    exit();
  }

  

  
}



?>
    
</html>