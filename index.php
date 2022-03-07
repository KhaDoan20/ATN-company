<?php
session_start();
include("db_config.php");
$dbconn = pg_connect($db_conn_string);
$error = "";
if ($_SERVER["REQUEST_METHOD"]=="POST"){
    $uname = $_POST["username"];
    $passwd = $_POST["password"];
    $query = "SELECT * FROM acc WHERE username = '".$uname."' AND password = '".$passwd."'";
    $result = pg_query($dbconn, $query);
    if (pg_num_rows($result) == 1){
        $info = pg_fetch_array($result);
        $role = $info["shopname"];
        $_SESSION["shopname"] = $role;
        $_SESSION["refresh"] = '';
        $_SESSION["selected_shop"] = "All";
        header("location: displaytable.php");
    }
    else $error = "Wrong username or password.";
}
?>
<!DOCTYPE html>
<html lang = "eng">
<head>
	<meta charset="utf-8">
	<meta name ="descriptions" content = "ATN shop">
	<meta name = "viewport" content ="width=device-width, initial-scale = 0.5 ">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
	<link href="https://fonts.googleapis.com/css2?family=Rampart+One&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/base.css">
	<link rel="stylesheet" type="text/css" href="css/Header Navigation.css">
	<link rel="stylesheet" type="text/css" href="css/Notification.css">
	<link rel="stylesheet" type="text/css" href="css/Cart.css">
	<link rel="stylesheet" type="text/css" href="css/Searching.css">
	<link rel="stylesheet" type="text/css" href="css/SignIn.css">
	<link rel="stylesheet" type="text/css" href="css/Sign up.css">
	<title>ATN Sign In</title>
</head>

<body class="body__signIn">

	<style>
		body { 
 	 	background-image: url('https://images.unsplash.com/photo-1587654780291-39c9404d746b?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2070&q=80');}
	</style>
	<div class="modal">

		<div class="modal__overlay">
		
		</div>

		<div class="modal__content">

			<div class="signInForm">
				
			<form  method="POST">

				<div class="signInForm__container">
								
					<h3 class="signInForm__heading">Sign In</h3>
				
				<div class="signInForm__form">

					<div class="signInForm__layout">

					<input name="username" type="text" class="signInForm__layout-input" placeholder="Username">
			
				</div>

				<div class="signInForm__layout">

					<input name="password" type="password" class="signInForm__layout-input" placeholder="password"> 

				</div>

								
				</div>
						
				<div class="signInForm__aside">
							<p class="signInForm_aside-switch"> Don't have an account ?<a href="SignUp.php" class="signInForm_aside-Btn">Sign up</a></p>
				</div>

				<div class="signInForm__controls">

				
				<button class="btn btn__goBack"><a class="goback_signup" href="index.php">Go Back</a></button>
				

						
				<input value="Sign In" type="submit" name="login" class="btn btn__signUp" >
					

				</div>
				
				</div>
				</form>

			</div>

				

			</div>
		</div>
		

</body>

</html>