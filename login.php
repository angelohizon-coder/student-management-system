<?php
    #the include_once keyword is used to embed PHP code from another file.
    include_once("connections/connections.php");

    $connection = connection();

    #if session is empty then the next thing to do is to start it
    if(!isset($_SESSION)) {
        session_start();
    }

    #checks if there's an connection error
    if($connection->connect_error) {
        echo $connection->connect_error;
    }

    if(isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM `student_users` WHERE username = '$username'";
        
        $user = $connection->query($sql) or die ($connection->error);
        $row = $user->fetch_assoc();

        #guard clause that checks whether the query is emptry or not
        if(!isset($row)) {
            echo "Incorrect username";
        }

        else if($row['password'] != $password) {
            echo "Incorrect password";
        }

        #already checked if the username is correct since it is unique and was used for searching the record within the database
        // else if ($row['access'] != 'admin') {
            
        //     echo "You don't have admin privileges. Please contact the administrator.";
        // }

        else {
            $_SESSION['UserLogin'] = $row['username'];
            $_SESSION['Access'] = $row['access'];
            
            echo header("Location: index.php");
        }
    }
?>

<html>
    <head>
        <title>PHP Tutorial sa Tagalog</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <link rel="stylesheet" href="css/styles.css">
    </head>
    <body>
        <h1>Login Page</h1>
        <br>
        <form action="" method="post">
            <label for="username">Username</label>
            <input type="text" name="username" id="username">
            <label for="password">Password</label>
            <input type="password" name="password" id="password">
            <button type="submit" name="login">Login</button>
        </form>
    </body>
</html>