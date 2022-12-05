
<?php
    $url='localhost';
    $username='root';
    $password='';
    $dbname= 'dremers';
    $conn=mysqli_connect($url,$username,$password, $dbname);
    if(!$conn){
        die('Could not Connect My Sql:' .mysql_error());
    }
    else
    {
    	@mysqli_select_db($conn, "Welcome");
    }
    date_default_timezone_set("Asia/Karachi");
    $error = "";
?>


