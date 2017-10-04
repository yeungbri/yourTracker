<!DOCTYPE html>
<html >
  <head>
    <meta charset="UTF-8">
    <title>yourTracker
    </title>
    
    <style>
      /* CSS style for login needs to be nested to support the Prefix Script*/
      @import url(http://fonts.googleapis.com/css?family=Exo:100,200,400);
      @import url(http://fonts.googleapis.com/css?family=Source+Sans+Pro:700,400,300);
      
      body{
        overflow:hidden;
        margin: 0;
        padding: 0;
        background: #fff;
        color: #fff;
        font-family: Arial;
        font-size: 12px;
      }
      .body{
        position: absolute;
        top: -20px;
        left: -20px;
        right: -40px;
        bottom: -40px;
        width: auto;
        height: auto;
        background: url(https://bizcircle.att.com/wp-content/uploads/2015/03/buildingblocks_737.jpg) no-repeat center center fixed;
        background-size: cover;
        -webkit-filter: blur(5px);
        z-index: 0;
      }
      .grad{
        position: absolute;
        top: -20px;
        left: -20px;
        right: -40px;
        bottom: -40px;
        width: auto;
        height: auto;
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(0,0,0,0)), color-stop(70%,rgba(0,0,0,0.65)));
        /* Chrome,Safari4+ */
        z-index: 1;
        opacity: 0.7;
      }
      .header{
        position: absolute;
        top: calc(50% - 35px);
        left: calc(50% - 255px);
        z-index: 2;
      }
      .header div{
        float: left;
        color: #fff;
        font-family: 'Exo', sans-serif;
        font-size: 35px;
        font-weight: 600;
        letter-spacing: -1px;
      }
      .header div span{
        color: #5379fa;
      }
      .login{
        position: absolute;
        top: calc(50% - 75px);
        left: calc(50% - 50px);
        height: 150px;
        width: 350px;
        padding: 10px;
        z-index: 2;
      }
      .login input[type=text]{
        width: 250px;
        height: 30px;
        background: transparent;
        border: 1px solid rgba(255,255,255,0.6);
        border-radius: 2px;
        color: #fff;
        font-family: 'Exo', sans-serif;
        font-size: 16px;
        font-weight: 400;
        padding: 4px;
      }
      .login input[type=password]{
        width: 250px;
        height: 30px;
        background: transparent;
        border: 1px solid rgba(255,255,255,0.6);
        border-radius: 2px;
        color: #fff;
        font-family: 'Exo', sans-serif;
        font-size: 16px;
        font-weight: 400;
        padding: 4px;
        margin-top: 10px;
      }
      .login input[type=submit]{
        width: 260px;
        height: 35px;
        background: #fff;
        border: 1px solid #fff;
        cursor: pointer;
        border-radius: 2px;
        color: #a18d6c;
        font-family: 'Exo', sans-serif;
        font-size: 16px;
        font-weight: 400;
        padding: 6px;
        margin-top: 10px;
      }
      .login input[type=button]:hover{
        opacity: 0.8;
      }
      .login input[type=button]:active{
        opacity: 0.6;
      }
      .login input[type=text]:focus{
        outline: none;
        border: 1px solid rgba(255,255,255,0.9);
      }
      .login input[type=password]:focus{
        outline: none;
        border: 1px solid rgba(255,255,255,0.9);
      }
      .login input[type=button]:focus{
        outline: none;
      }
      ::-webkit-input-placeholder{
        color: rgba(255,255,255,0.6);
      }
      ::-moz-input-placeholder{
        color: rgba(255,255,255,0.6);
      }
    </style>
    
    <!--JQuery script, credit to PrefixFree library, supporting login --> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js">
    </script>
  </head>
  <body>
    <?php
	include("config.php");
	session_start();
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		// email and password sent from form 
		$email = mysqli_real_escape_string($db, $_POST['email']);
		$pwd = mysqli_real_escape_string($db, $_POST['password']);
		$sql = "SELECT user_id FROM user WHERE email = '$email' and pwd = '$pwd'";
		$result = mysqli_query($db, $sql);
		
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		$count = mysqli_num_rows($result);
		// If result matched $myusername and $mypassword, table row must be 1 row
		if ($count == 1) {
			$_SESSION['user_id'] = $email;
			header("location: home.php?#");
		} else {
			$error = "Your Login Name or Password is invalid";
		}
	}
	mysqli_close($db);
	?>
    <div class="body">
    </div>
    <div class="grad">
    </div>
    <div class="header">
      <div>your
        <span>Tracker
        </span>
      </div>
    </div>
    <br>
    <div class="login">
      <form action = "" method = "post">
        <input type="text" placeholder="email" name="email">
        <br>
        <input type="password" placeholder="password" name="password">
        <br>
        <input type="submit" value="submit">
      </form>
      <div style = "font-size:20px; color:#FFFFFF; margin-top:10px">
        <?php echo $error; ?>
      </div>
    </div>
    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
  </body>
</html>
