
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
    <form action="home.php" method="post">
		<h2>Welcome</h2>
        <br>

            <?php
				session_start();
				include 'database.php';


				//define variables
$ID = $First_Name = $Last_Name = $Email = $Password ="";
$ID_err = $First_Name_err = $Last_Name_err = $Email_err = $Password_err = "";

				$First_Name= $_SESSION["First_Name"];
				$Last_Name= $_SESSION["Last_Name"];
				$query=mysqli_query($conn,"SELECT * FROM register where ID='$ID' ");
				$row  = mysqli_fetch_array($query);
			

				if(isset($_POST['submit'])){
// Fetching variables of the form which travels in URL
$First_Name = $_POST['First_Name'];
$Last_Name = $_POST['Last_Name'];
$Email = $_POST['Email'];
$Password = $_POST['Password'];

}
            ?>
            
      
		<p class="hint-text"><br><b>Welcome </b><?php echo $_POST['First_Name']; ?> <?php echo $_POST['Last_Name']; ?></p>
        <div class="text-center">Want to Leave the Page? <br><a href="logout.php">Logout</a></div>
    </form>
	
</div>
</body>
</html>