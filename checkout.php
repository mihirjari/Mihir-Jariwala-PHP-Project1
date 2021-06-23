<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<p class="tag">Checkout</p>
    
<div id="formSection">

        <?php

            require("mysqli_connect.php");        
            session_start();

            if(isset($_SESSION['session_book'])){

                // Fetching the book id from the database using Prepared statement & session variable 
                $query = mysqli_prepare($dbc, "SELECT * FROM bookinventory WHERE book_name = ?");
                mysqli_stmt_bind_param($query, "s", $_SESSION['session_book']);
                mysqli_stmt_execute($query);
                $result = mysqli_stmt_get_result($query);

                if(mysqli_num_rows($result) > 0){
                    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){

                        $_SESSION['session_book_id'] = $row['book_id'];
                        
                        //Storing book quantity into session variable to validate quantity user input
                        $_SESSION['session_quantity'] = $row['book_quantity']; 


                    }
                }
                

                echo "<p class='message'>You Selected: ".$_SESSION['session_book']."</p><p class='message'>Quantity Available: ".$_SESSION['session_quantity']."</p>";
                
                //checking if there is stock of the selected book by the user
                if($_SESSION['session_quantity'] > 0){
            ?>
             
                <form action="order.php" method="POST">

                    <label for="firstname">First Name: </label>
                    <input type="text" name="firstname" id="firstname" value="<?php if(isset($_POST['firstname'])) echo $_POST['firstname']; ?>">

                    <br>

                    <label for="lastname">Last Name: </label>
                    <input type="text" name="lastname" id="lastname" value="<?php if(isset($_POST['lastname'])) echo $_POST['lastname']; ?>">

                    <p class="message">Payment Options: </p>
                    <input type="radio" name="payment" id="option1" value="Debit">
                    <label for="option1">Debit</label>
                    <br>

                    <input type="radio" name="payment" id="option2" value="Credit">
                    <label for="option2">Credit</label>
                    <br>

                    <input type="radio" name="payment" id="option3" value="Cash On Delivery">
                    <label for="option3">Cash On Delivery</label>
                    <br>

                    <label for="quantity">Quantity</label>
                    <input type="number" name="quantity" id="quantity" min="1" max="<?php echo $_SESSION['session_quantity'] ?>">

                    <br>

                    <input type="submit" value="Purchase" class="button">
                
                </form>

                <a href="index.html" class="toHome">Cancel</a>

        <?php
                }else{
                    echo "<p class='error'>The Book you selected is out of stock! Please try again later. <a href='store.php' class='toHome'>Back to Store</a></p>";
                }
            }else{
                
                header("location: index.html");
            }

        ?>
</div>
</body>
</html>