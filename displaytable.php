<?php
include("db_config.php");
include("show_db.php");
session_start();
$dbconn = pg_connect($db_conn_string);
$role = $_SESSION["shopname"];

$page = $_SERVER['PHP_SELF'];
    
if(isset($_POST["submit_time"]))
{
    $_SESSION["refresh"] = $_POST["refresh_time"];
}

if(isset($_POST["selected_shop"]))
{
    $_SESSION["selected_shop"] = $_POST["shop"];
}
?>

<!DOCTYPE html>
<html lang="en">

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
    <link rel="stylesheet" type="text/css" href="displaytable.css">
	<title>ATN Store</title>
</head>
<body>
<h1 class="signInForm__heading"> ATN Company Management</h1>
<label class="noti"> <?php echo "You are logging in with the ".$role." account";?></label>
    <?php
    if ($role == "director"){
        ?>
        <meta http-equiv="refresh" content="<?php echo $_SESSION["refresh"];?>;URL='<?php echo $page?>'">
     <form class="dropform" action="" method="POST">
         
        <select class ="dropdown" name="refresh_time">
            <option value=" ">Stop Refresh</option>
            <option value="5">5 Sec</option>
            <option value="10">10 Sec</option>
            <option value="15">15 Sec</option>
        </select>
        
        <input class="button" type="submit" name="submit_time" value="  Set " />
            <label><?php echo "Current refresh time is ".$_SESSION["refresh"]." seconds";?></label>
    </form> 
    
    <form class="dropform" action="" method="POST">
        <select class ="dropdown" name="shop">
            <option value="shop_a">Shop A</option>
            <option value="shop_b">Shop B</option>
            <option value="All" selected>All Shop</option>
        </select>
        <input class="button" type="submit" name="selected_shop" value="View" />
    </form>

    <?php
       $selected_shop =  $_SESSION["selected_shop"];
    if ($selected_shop == "All"){
        $query = "SELECT * FROM product";  
    }
    else{
            $query="SELECT * FROM product WHERE shop_name = '$selected_shop'" ; 
        }
    }
    else{
        $query="SELECT * FROM product WHERE shop_name = '$role'" ;   
        }

$result=pg_query($dbconn, $query);
$num_field = pg_num_fields($result);
if ($_SERVER["REQUEST_METHOD"]=="POST"){
    if (isset($_POST['insert'])){
        $add_query="INSERT INTO product VALUES ('".$role."',";
        for ($i=0;$i<$num_field;$i++){
            $field_name = pg_field_name($result,$i);
            if ($field_name!='shop_name'){
                $field_value = $_POST[$field_name];
                if($i!=$num_field-1)                
                    $add_query=$add_query."'".$field_value."',";               
                else $add_query=$add_query."'".$field_value."'"; 
            }        
        }
        $add_query=$add_query.")";
        $add_result=pg_query($dbconn, $add_query);
    }
    if (isset($_POST['delete'])){
        $del_query="DELETE FROM product WHERE product_id="."'".$_POST['product_id']."'";
        $del_result=pg_query($dbconn,$del_query);
    }
    if (isset($_POST['edit'])){
        $edit_query="UPDATE product SET product_name="."'".$_POST['product_name']."', price="."'".$_POST['price']."', amount="."'".$_POST['amount']."' WHERE product_id="."'".$_POST['product_id']."'";
        $edit_result=pg_query($dbconn,$edit_query);
    }
    $result = pg_query($dbconn,$query);
    $num_field = pg_num_fields($result);
}
   display_table($result, $role); 
    ?>
    <div class="logout">
		<div><a class="button" id="signout" href="LogOut.php">Log Out</a></div>
	</div>
</body>
</html>



