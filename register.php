<?php
session_start();
include ("database.php");
 
//define variables
$First_Name = $Last_Name = $Email = $Password ="";
$First_Name_err = $Last_Name_err = $Email_err = $Password_err = "";


if (isset($_REQUEST['First_Name'])) {

        //remove slashes
     $First_Name = striplashes($_REQUEST['$First_Name']);
     //escapes special characters in a string
     $First_Name = mysqli_real_escape_string($conn, $First_Name);
     $Last_Name = striplashes($_REQUEST['$Last_Name']);
     $Last_Name = mysqli_real_escape_string($conn, $Last_Name);
     $Email = striplashes($_REQUEST['$Email']);
     $Email = mysqli_real_escape_string($conn, $Email);
     $Password = striplashes($_REQUEST['$Password']);
     $Password = mysqli_real_escape_string($conn, $Password);
     $Confirm_Password = striplashes($_REQUEST['$Confirm_Password']);
     $Confirm_Password = mysqli_real_escape_string($conn, $ConfirmPassword);


     $query = "INSERT  INTO 'register' (First_Name, Last_Name, Email, Password) VALUES ('$First_Name', '$Last_Name', '$Email', '" . md5($Password) . "', '" . md5($Confirm_Password) . "';";
     $result = mysqli_query($conn, $query);

     //Processing from data when form is submitted
     if($_SERVER["REQUEST_METHOD"] == "POST"){

        //validate first name
        if(empty(trim($_POST['First_Name']))){
            $First_Name_err = "field can not be empty!";
        }
        elseif (!preg_match('/^[a-zA-Z_]+$/', trim($_POST["First_Name"]))) {
        $First_Name_err = "FirstName can only contain letters and underscore";
         } else{
            // Prepare a select statement
            $query = "SELECT id FROM login WHERE First_Name = ?";
         
         if($stmt = mysqli_prepare($conn, $query)) {
            //bind variables to the prepared stament as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_First_Name);
         
         // st parameters
         $param_First_Name = trim($_POST["First_Name"]);
         //attempt to execute the prepared statement
         if (mysqli_stmt_execute($stmt)) {
             // store result
            mysqli_stmt_store_result($stmt);
         
         if (mysqli_stmt_num_rows($stmt) == 1) {
             $First_Name_err = "this name is Already taken.";
         } else{
            $First_Name = trim($_POST["First_Name"]);
         }

         } else{
            echo "Oops! something went wrong. please try again later.";
         }
         // close stament
         mysqli_stmt_close($stmt);
     }
 }



        if(empty(trim($_POST['Last_Name']))){
            $Last_Name_err = "field can not be empty!";
        }
         elseif (!preg_match('/^[a-zA-Z_]+$/', trim($_POST["Last_Name"]))) {
        $First_Name_err = "LastName can only contain letters and underscore";
         } else{
            // Prepare a select statement
            $query = "SELECT id FROM login WHERE Last_Name = ?";
         
         if($stmt = mysqli_prepare($conn, $query)) {
            //bind variables to the prepared stament as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_First_Name);
         
         // st parameters
         $param_Last_Name = trim($_POST["Last_Name"]);
         //attempt to execute the prepared statement
         if (mysqli_stmt_execute($stmt)) {
             // store result
            mysqli_stmt_store_result($stmt);
         
         if (mysqli_stmt_num_rows($stmt) == 1) {
             $Last_Name_err = "this name is Already taken.";
         }
          else{
            $FLast_Name = trim($_POST["Last_Name"]);
         } 

     }else{
            echo "Oops! something went wrong. please try again later.";
         }
         // close stament
         mysqli_stmt_close($stmt);
     }
 }
}
        //Validate email
        if(empty(trim($_POST["Email"]))){
            $Email_err = "field can not be empty!";
        }
        elseif (strlen(trim($_POST["Email"]))) {
            $Email_err = "enter a valid email address";
        }
        else {
            $Email = trim($_POST["Email"]);
        }
        //Validate password
        if(empty(trim($_POST['Password']))){
            $Password_err = "field can not be empty!";
        }
        elseif (strlen(trim($_POST["Password"])) < 8) {
            $Password_err = "password must have at least 8 characters";
        }
        else{
            $Password = trim($_POST["Password"]);
        }

         //Validate confirm password
        if(empty(trim($_POST['Confirm_Password']))){
            $Confirm_Password_err = "Please confirm password!";
        } else {
            $Confirm_Password = trim($_POST['Confirm_Password']);
            if (empty($Password_err) && ($Password != $Confirm_Password)) {
                $Confirm_Password_err = "Passwords do not match";
            }
        }
     
//Check input errors befor inserting in the database
     if(empty($Email_err) && empty($Password_err) && empty($Confirm_Password_err)){

        //Prepare an insert statement
        $query = "INSERT INTO login (Email, Password) VALUES (?, ?)";

        if ($stmt = mysqli_prepare($conn, $query)) {
            //bind values to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_Email, $param_Password);
            
            //set parameters           
            $param_Email = $Email;
            $param_Password = password_hash($Password, PASSWORD_DEFAULT); //Creates a password hash

            //Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                //redirect to login page
                header("location: login.php");
            }else{
                echo "oops! something went wrong. please try again later.";
            }
            //close statement
            mysqli_stmt_close($stmt);

        }

     }
 
     //close connection
     mysqli_close($conn);

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,700">
<title>Welcome to Finance Portal</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="assests/css/style.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

</head>
<body>
<div class="signup-form">
    <form method="post">
		<h2>Register</h2>
		<p class="hint-text">Create your account</p>
        <div class="form-group">
			<div class="row">
				<div class="col"><input type="text" class="form-control" name="irst_name" placeholder="First Name" required="required"></div>
				<div class="col"><input type="text" class="form-control" name="last_name" placeholder="Last Name" required="required"></div>
			</div>        	
        </div>
        <div class="form-group">
        	<input type="email" class="form-control" name="email" placeholder="Email" required="required">
        </div>
		<div class="form-group">
            <input type="password" class="form-control" name="pass" placeholder="Password" required="required">
        </div>
		<div class="form-group">
            <input type="password" class="form-control" name="cpass" placeholder="Confirm Password" required="required">
        </div>
        </div>        
        
		<div class="form-group">
            <button type="submit" class="btn btn-success btn-lg btn-block">Register Now</button>

        </div>
        <div class="text-center">Already have an account? <a href="login.php">Sign in</a></div>
    </form>
	
</div>
</body>
</html>