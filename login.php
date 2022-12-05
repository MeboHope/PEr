<?php
    session_start();
   
    //check if the user is already logged in, if yes then redirect him to welcom page
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
        header("location: home.php");
        exit;
    
     include ("database.php");
    //define variables and initialize with values
    $Email = $Password= "";
    $Email_err = $Password_err = $Login_err = "";

    $query ="INSERT INTO login (Email, Password,) VALUES ('$Email','" . md5($Password) . "')";
    $result = mysqli_query($conn, $query);
    
    //processing data when form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //check if email is empty
        if (empty(trim($_POST["Email"]))) {
            $Email_err = "please enter your email";
        }else{
            $Email = trim($_POST["Email"]);
        }
        //check if password is empty
        if (empty(trim($_POST["Password"]))) {
            $Password_err = "please enter your Password";
        }else{
            $Password = trim($_POST["Password"]);
        }
        //validete credentials
        if (empty($Email_err) && empty($Password_err)) {
            // prepare a select statement
            $query = "SELECT id, Email, Password FROM login WHERE Email = ?";
            if ($stmt = mysqli_prepare($conn, $query)) {
                // bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "s", $param_Email);
                //set parameters
                $param_Email = $Email;
                //attempt to execute the prepared statement
                if (mysqli_stmt_execute($stmt)) {
                    //store result
                    mysqli_stmt_store_result($stmt);
                    //check if email exists, if yes then verify password
                    if (mysqli_stmt_num_rows($stmt) == 1) {
                        //bind result variables
                        mysqli_stmt_bind_result($stmt, $id, $Email, $hashed_Password);
                        if (mysqli_stmt_fetch($stmt)) {
                            if (password_verify($Password, $hashed_Password)){
                            //check is corect, so stsrt a new session
                                session_start();
                                //store data in session variables
                                $_SESSION["loggedin"] = true;
                                $_SESSION["id"] = $id;
                                $_SESSION["Email"] = $Email;
                                //redirect user to welcome page
                                header("Location: home.php");
                            } else{
                                //password is not valid, display a generic error message
                                $Login_err = "Invalid Email or Password.";
                            }
                        }
                    } else{
                        //email doesn't exist, display a generic error message
                        $Login_err = "Invalid Email or Password.";
                    }
                } else{
                      echo "Oops! something went wrong. please try again later.";
                }

                //close statement
                mysqli_stmt_close($stmt);
                }
            }
        }
        //close connectio
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
    <style>
    body
    {
        background-image: url();
    }
    .h2{
       background-color: white;
    }
</style>
    <h2><marquee bgcolor="green">The Dreamers</marquee></h2>
<div class="signup-form">
    <form method="post">
		<h2 color: white;>Login</h2>
		<p class="hint-text">Enter Login Details</p>
        <div class="form-group">
        	<input type="email" class="form-control" name="email" placeholder="Email" required="required">
        </div>
		<div class="form-group">
            <input type="password" class="form-control" name="pass" placeholder="Password" required="required">
        </div>
		<div class="form-group">
            <button type="submit" class="btn btn-success btn-lg btn-block">Login</button>
        </div>
        <div class="text-center">Don't have an account? <a href="register.php">Register Here</a></div>
    </form>
</div>
</body>
</html>