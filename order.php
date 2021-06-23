<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
session_start();

if(!isset($_SESSION['session_book_id']) && !isset($_SESSION['session_quantity'])){

    header("location: index.html");
}
require("mysqli_connect.php");
// Saving the order into the database
if($_SERVER['REQUEST_METHOD'] == "POST"){

    //Saving Form values to variables & validating user inputs
    if(!empty($_POST['firstname']) || !empty($_POST['lastname']) || !empty($_POST['payment'])){

    

        $book_id = $_SESSION['session_book_id'];

        // Using Filter Extension to prevent Script Injection
        $firstname = mysqli_real_escape_string($dbc, trim(filter_var($_POST['firstname'], FILTER_SANITIZE_STRING)));
        $lastname = mysqli_real_escape_string($dbc, trim(filter_var($_POST['lastname'], FILTER_SANITIZE_STRING)));
        $payment_mode = mysqli_real_escape_string($dbc, trim(filter_var($_POST['payment'], FILTER_SANITIZE_STRING)));
        $quantity_purchased = mysqli_real_escape_string($dbc, trim(filter_var($_POST['quantity'], FILTER_SANITIZE_STRING)));

        $query = "INSERT INTO orders (book_id_fk, first_name, last_name, payment_mode, quantity_purchased) VALUES ($book_id, '$firstname', '$lastname', '$payment_mode', $quantity_purchased)";

        $result = mysqli_query($dbc, $query);

        if(mysqli_affected_rows($dbc)){

            echo "<h1 class='message'>Your order has been placed successfully!</h1><br><a class='toHome' href='index.html'>Home</a>";

            //Reducing the book quantity and updating it in the database
            $quantity_remaining = $_SESSION['session_quantity'] - $quantity_purchased;

            //Updating book quantity using UPDATE query
            $query = "UPDATE bookinventory SET book_quantity=".$quantity_remaining." WHERE book_id=".$book_id;

            mysqli_query($dbc, $query);
        }
    }else{
        echo "<h1 class='error'>Please fill up the required fields.</h1><a href='checkout.php' class='toHome'>Back</a>";
    }
}

?>
</body>
</html>