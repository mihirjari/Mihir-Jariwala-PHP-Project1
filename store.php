<?php
    require("mysqli_connect.php");

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        if(isset($_POST['book'])){

            //Starting the session
            session_start();
            //Storing the user's selection in the SESSION variable
            $_SESSION['session_book'] = $_POST['book'];

            //Redirect to checkout page after storing users choice into SESSION variable
            header("location: checkout.php");
            
        }
       
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books List</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<p class="tag">The Books List</p> 
<div id="bookList">
    
    <?php

        $query = "SELECT * FROM bookinventory";
        $result = mysqli_query($dbc, $query);

        if(mysqli_num_rows($result) > 0){

            while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){   
                
                echo "<form action='store.php' method='POST'><input type='submit' class='book' value='".$row['book_name']."' name='book'></form>";
                
            }
        }
    ?>
<a class="toHome" href="index.html">Home</a>

    
</div>
</body>
</html>


